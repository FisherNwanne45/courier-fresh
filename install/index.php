<?php
/**
 * Installer wizard -- turns a fresh clone of this app (no DB, no .env) into
 * a working site: environment check -> database setup (creates the DB +
 * schema + seed defaults) -> site & appearance -> SMTP -> admin account ->
 * done. Steps 3+ reuse resources/config.php (colorSchemes(), listThemes(),
 * mail_encrypt(), sendMailSMTP(), csrf helpers) once the database exists,
 * rather than re-implementing any of that.
 *
 * Locked after step 6 writes install/installed.lock -- delete that file to
 * re-run the wizard (e.g. to point the app at a different database).
 */

session_start();
require_once __DIR__ . '/../resources/security.php';

const INSTALL_LOCK = __DIR__ . '/installed.lock';
const ENV_PATH = __DIR__ . '/../resources/.env';

$isInstalled = is_file(INSTALL_LOCK);

$step = max(1, min(6, (int) ($_GET['step'] ?? 1)));
$error = '';
$notice = '';

// --- Small helpers, local to the installer (steps 1-2 can't rely on
// resources/config.php -- it dies on a bad/missing DB connection, which is
// the exact state those steps exist to fix). ------------------------------

function installEnvExists(): bool
{
    return is_file(ENV_PATH);
}

/** Raw .env reader -- independent of resources/config.php's env()/loadEnvFile(),
 *  which we can't call in isolation without executing the rest of that file. */
function installReadEnv(): array
{
    if (!is_file(ENV_PATH)) {
        return [];
    }
    $values = [];
    foreach (file(ENV_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
        $values[trim($key)] = trim($value);
    }
    return $values;
}

function installWriteEnv(string $host, string $user, string $pass, string $name, string $appKey): void
{
    $contents = <<<ENV
# Environment configuration for the courier app.
# This file is intentionally NOT committed with real production secrets checked in
# elsewhere in the codebase -- it is the single place DB credentials live now.
# Access to this file is blocked by .htaccess; keep it that way.

# --- Database ---
DB_HOST={$host}
DB_USER={$user}
DB_PASS={$pass}
DB_NAME={$name}

# --- SMTP / outbound email ---
# NOT configured here, deliberately -- a fresh install must never silently
# inherit a real mailbox's credentials from the environment. SMTP is entered
# once during installation (or later from the dashboard's Email / SMTP
# Settings page) and stored encrypted in the mail_settings DB table; that is
# the only place it lives.

# --- App encryption key (used to encrypt the stored SMTP password) ---
# Generated once by the installer. Do not change this after saving SMTP
# settings or the stored password will no longer decrypt.
APP_KEY={$appKey}

ENV;
    file_put_contents(ENV_PATH, $contents);
}

/** Attempts a DB connection from whatever is currently in .env. Returns
 *  null (rather than throwing/dying) if anything about it doesn't work,
 *  so callers can redirect back to the Database step instead of crashing. */
function installTryConnect(): ?mysqli
{
    if (!installEnvExists()) {
        return null;
    }
    $env = installReadEnv();
    if (empty($env['DB_HOST']) || empty($env['DB_NAME'])) {
        return null;
    }
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($env['DB_HOST'], $env['DB_USER'] ?? '', $env['DB_PASS'] ?? '', $env['DB_NAME']);
    if ($conn->connect_error) {
        return null;
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

function h(?string $v): string
{
    return htmlspecialchars($v ?? '', ENT_QUOTES);
}

// --- Already installed? ----------------------------------------------------
if ($isInstalled && $step < 6) {
    // Steps 1-5 are setup steps; once locked, only the finish page (which
    // itself just links onward) is worth showing.
    $step = 6;
}

// --- Step 2: Database -------------------------------------------------------
$dbForm = ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'name' => 'courier', 'create' => true];
if (installEnvExists()) {
    $env = installReadEnv();
    $dbForm = [
        'host' => $env['DB_HOST'] ?? 'localhost',
        'user' => $env['DB_USER'] ?? 'root',
        'pass' => $env['DB_PASS'] ?? '',
        'name' => $env['DB_NAME'] ?? 'courier',
        'create' => true,
    ];
}

if ($step === 2 && $_SERVER['REQUEST_METHOD'] === 'POST' && !$isInstalled) {
    verify_csrf();

    $dbForm['host'] = trim($_POST['db_host'] ?? '');
    $dbForm['user'] = trim($_POST['db_user'] ?? '');
    $dbForm['pass'] = (string) ($_POST['db_pass'] ?? '');
    $dbForm['name'] = trim($_POST['db_name'] ?? '');
    $dbForm['create'] = isset($_POST['db_create']);

    if ($dbForm['host'] === '' || $dbForm['user'] === '' || $dbForm['name'] === '') {
        $error = 'Host, username, and database name are required.';
    } elseif (!preg_match('/^[A-Za-z0-9_]+$/', $dbForm['name'])) {
        $error = 'Database name may only contain letters, numbers, and underscores.';
    } else {
        mysqli_report(MYSQLI_REPORT_OFF);
        $probe = @new mysqli($dbForm['host'], $dbForm['user'], $dbForm['pass']);
        if ($probe->connect_error) {
            $error = 'Could not connect: ' . $probe->connect_error;
        } else {
            $dbReady = true;
            if ($dbForm['create']) {
                if (!$probe->query("CREATE DATABASE IF NOT EXISTS `{$dbForm['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
                    $dbReady = false;
                    $error = 'Could not create database: ' . $probe->error;
                }
            }
            if ($dbReady && !$probe->select_db($dbForm['name'])) {
                $dbReady = false;
                $error = "Database \"{$dbForm['name']}\" doesn't exist and wasn't created (leave \"create if missing\" checked, or create it manually first).";
            }

            if ($dbReady) {
                $schemaSql = file_get_contents(__DIR__ . '/schema.sql');
                if ($probe->multi_query($schemaSql)) {
                    do {
                        if ($result = $probe->store_result()) {
                            $result->free();
                        }
                    } while ($probe->more_results() && $probe->next_result());
                }
                if ($probe->error) {
                    $error = 'Schema install failed: ' . $probe->error;
                    $dbReady = false;
                }
            }

            if ($dbReady) {
                require_once __DIR__ . '/seed.php';
                try {
                    installSeedDefaults($probe);
                } catch (Throwable $e) {
                    $error = 'Seeding default data failed: ' . $e->getMessage();
                    $dbReady = false;
                }
            }

            if ($dbReady) {
                $existingKey = installReadEnv()['APP_KEY'] ?? '';
                $appKey = $existingKey !== '' ? $existingKey : bin2hex(random_bytes(32));
                installWriteEnv($dbForm['host'], $dbForm['user'], $dbForm['pass'], $dbForm['name'], $appKey);

                // Dompdf's writable font-metrics cache, used by the PDF
                // receipt download on the tracking page -- receipt-pdf.php
                // also creates this on demand if it's ever missing, but
                // provisioning it now means the first download isn't the
                // one paying for that.
                $fontCacheDir = __DIR__ . '/../resources/dompdf-cache';
                if (!is_dir($fontCacheDir)) {
                    @mkdir($fontCacheDir, 0775, true);
                    @file_put_contents(
                        $fontCacheDir . '/.htaccess',
                        "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n"
                        . "<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n"
                    );
                }

                header('Location: index.php?step=3');
                exit;
            }
        }
    }
}

// --- Steps 3-6 need a working DB; from here on, reuse the app's own
// config.php (colorSchemes, listThemes, mail_encrypt, sendMailSMTP, ...)
// instead of re-implementing any of it. ------------------------------------
$conn = null;
$siteRow = null;
if ($step >= 3) {
    if (!installTryConnect()) {
        header('Location: index.php?step=2');
        exit;
    }
    require_once __DIR__ . '/../resources/config.php'; // sets $conn, $row (site id=20), defines helpers
    $siteRow = $row;
}

// --- Step 3: Site & Appearance ----------------------------------------------
if ($step === 3 && $_SERVER['REQUEST_METHOD'] === 'POST' && !$isInstalled) {
    verify_csrf();

    $postedName = trim($_POST['name'] ?? '');
    $postedAddr = trim($_POST['addr'] ?? '');
    $postedPhone = trim($_POST['phone'] ?? '');
    $postedEmail = trim($_POST['email'] ?? '');
    $postedTheme = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['active_theme'] ?? 'theme1');
    $postedScheme = $_POST['track_color_scheme'] ?? 'red';

    $themeKeys = array_column(listThemes(), 'key');
    $schemes = colorSchemes();

    if ($postedName === '') {
        $error = 'Site name is required.';
    } elseif (!in_array($postedTheme, $themeKeys, true)) {
        $error = 'Please choose a valid theme.';
    } elseif (!array_key_exists($postedScheme, $schemes)) {
        $error = 'Please choose a valid tracking-page color.';
    } else {
        $image = $siteRow['image'] ?? '';
        $favicon = $siteRow['favicon'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $image = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../resources/img/' . $image);
        }
        if (!empty($_FILES['favicon']['name'])) {
            $favicon = basename($_FILES['favicon']['name']);
            move_uploaded_file($_FILES['favicon']['tmp_name'], __DIR__ . '/../resources/img/' . $favicon);
        }

        $stmt = $conn->prepare(
            "UPDATE site SET name = ?, addr = ?, phone = ?, email = ?, active_theme = ?,
                track_color_scheme = ?, image = ?, favicon = ? WHERE id = 20"
        );
        $stmt->bind_param('ssssssss', $postedName, $postedAddr, $postedPhone, $postedEmail, $postedTheme, $postedScheme, $image, $favicon);
        $stmt->execute();
        $stmt->close();

        header('Location: index.php?step=4');
        exit;
    }
    $siteRow = array_merge($siteRow, [
        'name' => $postedName, 'addr' => $postedAddr, 'phone' => $postedPhone, 'email' => $postedEmail,
        'active_theme' => $postedTheme, 'track_color_scheme' => $postedScheme,
    ]);
}

// --- Step 4: SMTP -------------------------------------------------------
$mailSaved = ($step === 4) ? getMailSettings() : [];
if ($step === 4 && $_SERVER['REQUEST_METHOD'] === 'POST' && !$isInstalled) {
    verify_csrf();

    $action = $_POST['action'] ?? 'save';
    $posted = [
        'smtp_host' => trim($_POST['smtp_host'] ?? ''),
        'smtp_port' => (int) ($_POST['smtp_port'] ?? 587),
        'smtp_encryption' => in_array($_POST['smtp_encryption'] ?? '', ['tls', 'ssl', 'none'], true) ? $_POST['smtp_encryption'] : 'tls',
        'smtp_username' => trim($_POST['smtp_username'] ?? ''),
        'smtp_from_email' => trim($_POST['smtp_from_email'] ?? ''),
        'smtp_from_name' => trim($_POST['smtp_from_name'] ?? ''),
        'smtp_reply_to' => '',
        'bcc_enabled' => 0,
        'bcc_email' => '',
        'notify_on_create' => 1,
        'notify_on_status_update' => 1,
    ];
    $posted['smtp_password'] = trim($_POST['smtp_password'] ?? '');

    if ($action === 'skip') {
        header('Location: index.php?step=5');
        exit;
    }

    if ($posted['smtp_host'] === '' || $posted['smtp_from_email'] === '' || !filter_var($posted['smtp_from_email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'SMTP host and a valid "From" email address are required (or use Skip for now).';
        $mailSaved = $posted;
    } elseif ($action === 'test') {
        $testRecipient = trim($_POST['test_recipient'] ?? $posted['smtp_from_email']);
        $result = sendMailSMTP(
            $testRecipient, $testRecipient,
            'Test email from ' . ($posted['smtp_from_name'] ?: 'your courier admin'),
            '<p>This is a test email sent from the installer.</p><p>If you received this, the SMTP settings currently in the form are working.</p>',
            "This is a test email sent from the installer.\nIf you received this, the SMTP settings currently in the form are working.",
            $posted['smtp_from_email'], $posted['smtp_from_name'], $posted
        );
        $notice = $result['success']
            ? "Test email sent to {$testRecipient}. Check the inbox (and spam folder)."
            : 'Test email failed: ' . $result['message'];
        $error = $result['success'] ? '' : $notice;
        $notice = $result['success'] ? $notice : '';
        $mailSaved = $posted;
    } else {
        $encPassword = mail_encrypt($posted['smtp_password']);
        $stmt = $conn->prepare(
            "UPDATE mail_settings SET smtp_host=?, smtp_port=?, smtp_encryption=?, smtp_username=?,
                smtp_password_enc=?, smtp_from_email=?, smtp_from_name=?, updated_at=NOW() WHERE id=1"
        );
        $stmt->bind_param('sisssss', $posted['smtp_host'], $posted['smtp_port'], $posted['smtp_encryption'],
            $posted['smtp_username'], $encPassword, $posted['smtp_from_email'], $posted['smtp_from_name']);
        $stmt->execute();
        $stmt->close();

        header('Location: index.php?step=5');
        exit;
    }
}

// --- Step 5: Admin account ---------------------------------------------
if ($step === 5 && $_SERVER['REQUEST_METHOD'] === 'POST' && !$isInstalled) {
    verify_csrf();

    $adminUser = trim($_POST['admin_username'] ?? '');
    $adminPass = (string) ($_POST['admin_password'] ?? '');
    $adminPass2 = (string) ($_POST['admin_password_confirm'] ?? '');

    if ($adminUser === '' || strlen($adminPass) < 8) {
        $error = 'Username is required and password must be at least 8 characters.';
    } elseif ($adminPass !== $adminPass2) {
        $error = 'Passwords do not match.';
    } else {
        $hash = password_hash($adminPass, PASSWORD_DEFAULT);
        try {
            $stmt = $conn->prepare("INSERT INTO userlog (username, password, amt) VALUES (?, ?, 'admin')");
            $stmt->bind_param('ss', $adminUser, $hash);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?step=6');
            exit;
        } catch (mysqli_sql_exception $e) {
            $error = str_contains($e->getMessage(), 'Duplicate')
                ? 'That username is already taken.'
                : ('Could not create the admin account: ' . $e->getMessage());
        }
    }
}
$hasAdmin = false;
if ($step === 5 && $conn) {
    $r = $conn->query("SELECT id FROM userlog WHERE amt = 'admin' LIMIT 1");
    $hasAdmin = $r && $r->num_rows > 0;
}

// --- Step 6: Finish ----------------------------------------------------
if ($step === 6 && !$isInstalled) {
    file_put_contents(INSTALL_LOCK, 'Installed ' . date('c') . "\n");
    $isInstalled = true;
}

// --- Environment check (step 1) -----------------------------------------
$envChecks = [];
if ($step === 1) {
    $envChecks = [
        ['label' => 'PHP version 8.1+', 'pass' => version_compare(PHP_VERSION, '8.1.0', '>='), 'detail' => 'Running PHP ' . PHP_VERSION, 'required' => true],
        ['label' => 'mysqli extension', 'pass' => extension_loaded('mysqli'), 'detail' => 'Required to connect to the database.', 'required' => true],
        ['label' => 'openssl extension', 'pass' => extension_loaded('openssl'), 'detail' => 'Required to encrypt the stored SMTP password.', 'required' => true],
        ['label' => 'mbstring extension', 'pass' => extension_loaded('mbstring'), 'detail' => 'Used for correct handling of non-Latin text.', 'required' => false],
        ['label' => '.env is writable', 'pass' => is_writable(dirname(ENV_PATH)) || (is_file(ENV_PATH) && is_writable(ENV_PATH)), 'detail' => dirname(ENV_PATH), 'required' => true],
        ['label' => 'resources/img/ is writable', 'pass' => is_writable(__DIR__ . '/../resources/img'), 'detail' => 'Needed for logo/favicon/parcel-image uploads.', 'required' => true],
        ['label' => 'install/ is writable', 'pass' => is_writable(__DIR__), 'detail' => 'Needed to lock the installer once finished.', 'required' => true],
        ['label' => 'Composer dependencies installed', 'pass' => is_file(__DIR__ . '/../vendor/autoload.php'), 'detail' => 'Run "composer install" in the project root. Only needed for the PDF receipt download on the tracking page -- everything else works without it.', 'required' => false],
    ];
}
$envAllRequiredPass = empty(array_filter($envChecks, fn($c) => $c['required'] && !$c['pass']));

$stepLabels = [1 => 'Environment', 2 => 'Database', 3 => 'Site & Appearance', 4 => 'SMTP', 5 => 'Admin Account', 6 => 'Finish'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Install &middot; Courier App</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<style>
    :root { --bs-primary:#4f46e5; --bs-primary-rgb:79,70,229; }
    body { font-family:'Inter',-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif; background:#f3f4f6; color:#1f2937; }
    .install-shell { max-width:720px; margin:0 auto; padding:2.5rem 1.25rem 4rem; }
    .install-brand { display:flex; align-items:center; gap:.6rem; font-weight:700; font-size:1.15rem; margin-bottom:1.5rem; }
    .install-brand i { color:var(--bs-primary); font-size:1.4rem; }
    .stepper { display:flex; flex-wrap:wrap; gap:.4rem; margin-bottom:1.75rem; }
    .stepper .pill { font-size:.75rem; font-weight:600; padding:.3rem .65rem; border-radius:20px; background:#fff; border:1px solid #e5e7eb; color:#9ca3af; }
    .stepper .pill.active { background:var(--bs-primary); border-color:var(--bs-primary); color:#fff; }
    .stepper .pill.done { color:#16a34a; border-color:#bbf7d0; background:#f0fdf4; }
    .card { border:1px solid #e5e7eb; border-radius:10px; }
    .form-label { font-weight:600; font-size:.85rem; }
    .btn-primary { background-color:var(--bs-primary); border-color:var(--bs-primary); font-weight:600; }
    .btn-primary:hover, .btn-primary:focus { background-color:#4338ca; border-color:#4338ca; }
    .env-check { display:flex; align-items:flex-start; gap:.6rem; padding:.6rem 0; border-bottom:1px solid #f3f4f6; }
    .env-check:last-child { border-bottom:0; }
    .env-check i { font-size:1.1rem; margin-top:.1rem; }
    .env-check .ok { color:#16a34a; }
    .env-check .bad { color:#dc2626; }
    .env-check .warn { color:#d97706; }
    .theme-swatch, .scheme-swatch { cursor:pointer; }
    .theme-swatch input, .scheme-swatch input { display:none; }
    .theme-swatch .box, .scheme-swatch .box { border:2px solid #e5e7eb; border-radius:8px; padding:.75rem; }
    .theme-swatch input:checked + .box, .scheme-swatch input:checked + .box { border-color:var(--bs-primary); box-shadow:0 0 0 3px rgba(var(--bs-primary-rgb),.12); }
</style>
</head>
<body>
<div class="install-shell">
    <div class="install-brand"><i class="bi bi-truck"></i> Courier App Installer</div>

    <div class="stepper">
        <?php foreach ($stepLabels as $n => $label): ?>
            <span class="pill <?= $n === $step ? 'active' : ($n < $step || $isInstalled ? 'done' : '') ?>">
                <?= $n ?>. <?= h($label) ?>
            </span>
        <?php endforeach; ?>
    </div>

    <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
    <?php if ($notice): ?><div class="alert alert-success"><?= h($notice) ?></div><?php endif; ?>

    <?php if ($isInstalled && $step === 6): ?>

        <div class="card p-4 text-center">
            <div class="mb-2"><i class="bi bi-check-circle-fill text-success" style="font-size:2.5rem;"></i></div>
            <h1 class="h4 mb-2">Installation complete</h1>
            <p class="text-muted">The database is set up, defaults are seeded, and your admin account is ready.</p>
            <div class="d-flex gap-2 justify-content-center mt-3">
                <a href="../resources/login.php" class="btn btn-primary"><i class="bi bi-box-arrow-in-right me-1"></i>Go to Admin Login</a>
                <a href="../index.php" class="btn btn-outline-secondary">View Site</a>
            </div>
            <p class="text-muted small mt-4 mb-0">
                This wizard is now locked (<code>install/installed.lock</code>). Delete that file to run it again --
                e.g. to point the app at a different database.
            </p>
        </div>

    <?php elseif ($step === 1): ?>

        <div class="card p-4">
            <h1 class="h5 mb-1">Environment check</h1>
            <p class="text-muted small">Everything below marked required must pass before continuing.</p>
            <div class="mt-2">
                <?php foreach ($envChecks as $c): ?>
                    <div class="env-check">
                        <i class="bi <?= $c['pass'] ? 'bi-check-circle-fill ok' : ($c['required'] ? 'bi-x-circle-fill bad' : 'bi-exclamation-triangle-fill warn') ?>"></i>
                        <div>
                            <div><strong><?= h($c['label']) ?></strong> <?= $c['required'] ? '' : '<span class="text-muted small">(recommended)</span>' ?></div>
                            <div class="text-muted small"><?= h($c['detail']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-3">
                <?php if ($envAllRequiredPass): ?>
                    <a href="index.php?step=2" class="btn btn-primary">Continue <i class="bi bi-arrow-right ms-1"></i></a>
                <?php else: ?>
                    <button class="btn btn-primary" disabled>Fix the required items above to continue</button>
                <?php endif; ?>
            </div>
        </div>

    <?php elseif ($step === 2): ?>

        <div class="card p-4">
            <h1 class="h5 mb-1">Database</h1>
            <p class="text-muted small">
                Creates the database (if needed), all required tables, and seeds default data
                (a demo tracking number, a demo vault login, and the default email templates).
            </p>
            <form method="post" action="index.php?step=2">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Database host</label>
                    <input type="text" name="db_host" class="form-control" value="<?= h($dbForm['host']) ?>" required>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Database user</label>
                        <input type="text" name="db_user" class="form-control" value="<?= h($dbForm['user']) ?>" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Database password</label>
                        <input type="password" name="db_pass" class="form-control" value="<?= h($dbForm['pass']) ?>">
                    </div>
                </div>
                <div class="mb-2 mt-3">
                    <label class="form-label">Database name</label>
                    <input type="text" name="db_name" class="form-control" value="<?= h($dbForm['name']) ?>" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="db_create" id="db_create" <?= $dbForm['create'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="db_create">Create this database if it doesn't already exist</label>
                </div>
                <button type="submit" class="btn btn-primary">Test &amp; Continue <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
        </div>

    <?php elseif ($step === 3): ?>

        <div class="card p-4">
            <h1 class="h5 mb-1">Site &amp; Appearance</h1>
            <p class="text-muted small">Basic site details, front-end theme, and the tracking-page accent color. Everything here can be changed later from the dashboard.</p>
            <form method="post" action="index.php?step=3" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Site name</label>
                    <input type="text" name="name" class="form-control" value="<?= h($siteRow['name'] ?? '') ?>" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= h($siteRow['phone'] ?? '') ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= h($siteRow['email'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="addr" class="form-control" value="<?= h($siteRow['addr'] ?? '') ?>">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">Logo</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Favicon</label>
                        <input type="file" name="favicon" class="form-control">
                    </div>
                </div>

                <label class="form-label d-block">Theme</label>
                <div class="row g-2 mb-3">
                    <?php foreach (listThemes() as $t): if (!$t['ready']) continue; ?>
                        <div class="col-sm-4">
                            <label class="theme-swatch d-block">
                                <input type="radio" name="active_theme" value="<?= h($t['key']) ?>" <?= ($siteRow['active_theme'] ?? 'theme1') === $t['key'] ? 'checked' : '' ?>>
                                <div class="box"><?= h($t['label']) ?></div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <label class="form-label d-block">Tracking page color</label>
                <div class="row g-2 mb-3">
                    <?php foreach (colorSchemes() as $key => $scheme): ?>
                        <div class="col-sm-3">
                            <label class="scheme-swatch d-block">
                                <input type="radio" name="track_color_scheme" value="<?= h($key) ?>" <?= ($siteRow['track_color_scheme'] ?? 'red') === $key ? 'checked' : '' ?>>
                                <div class="box">
                                    <div class="rounded mb-1" style="height:28px;background:<?= $scheme['gradient'] ?>;"></div>
                                    <?= h($scheme['label']) ?>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary">Save &amp; Continue <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
        </div>

    <?php elseif ($step === 4): ?>

        <div class="card p-4">
            <h1 class="h5 mb-1">SMTP</h1>
            <p class="text-muted small">Used to send tracking-update emails. You can skip this and configure it later from the dashboard.</p>
            <form method="post" action="index.php?step=4">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-sm-8">
                        <label class="form-label">SMTP host</label>
                        <input type="text" name="smtp_host" class="form-control" value="<?= h($mailSaved['smtp_host'] ?? '') ?>">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Port</label>
                        <input type="number" name="smtp_port" class="form-control" value="<?= h((string) ($mailSaved['smtp_port'] ?? 587)) ?>">
                    </div>
                </div>
                <div class="row g-3 mt-0">
                    <div class="col-sm-6">
                        <label class="form-label">Encryption</label>
                        <select name="smtp_encryption" class="form-select">
                            <?php foreach (['tls' => 'STARTTLS (587)', 'ssl' => 'SSL/TLS (465)', 'none' => 'None'] as $val => $label): ?>
                                <option value="<?= $val ?>" <?= ($mailSaved['smtp_encryption'] ?? 'tls') === $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">SMTP username</label>
                        <input type="text" name="smtp_username" class="form-control" value="<?= h($mailSaved['smtp_username'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label">SMTP password</label>
                    <input type="password" name="smtp_password" class="form-control" placeholder="<?= !empty($mailSaved['smtp_password']) ? '(unchanged)' : '' ?>">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">"From" email</label>
                        <input type="email" name="smtp_from_email" class="form-control" value="<?= h($mailSaved['smtp_from_email'] ?? ($siteRow['email'] ?? '')) ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">"From" name</label>
                        <input type="text" name="smtp_from_name" class="form-control" value="<?= h($mailSaved['smtp_from_name'] ?? ($siteRow['name'] ?? '')) ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Send a test to</label>
                    <input type="email" name="test_recipient" class="form-control" placeholder="you@example.com">
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" name="action" value="save" class="btn btn-primary">Save &amp; Continue <i class="bi bi-arrow-right ms-1"></i></button>
                    <button type="submit" name="action" value="test" class="btn btn-outline-secondary">Send Test Email</button>
                    <button type="submit" name="action" value="skip" class="btn btn-link text-muted">Skip for now</button>
                </div>
            </form>
        </div>

    <?php elseif ($step === 5): ?>

        <div class="card p-4">
            <h1 class="h5 mb-1">Admin account</h1>
            <p class="text-muted small">This is the account you'll use to log into the dashboard.</p>
            <?php if ($hasAdmin): ?>
                <div class="alert alert-info">An admin account already exists.</div>
                <a href="index.php?step=6" class="btn btn-primary">Continue <i class="bi bi-arrow-right ms-1"></i></a>
            <?php else: ?>
                <form method="post" action="index.php?step=5">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Username / email</label>
                        <input type="text" name="admin_username" class="form-control" required autofocus>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="admin_password" class="form-control" minlength="8" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Confirm password</label>
                            <input type="password" name="admin_password_confirm" class="form-control" minlength="8" required>
                        </div>
                    </div>
                    <div class="form-text mb-3">At least 8 characters.</div>
                    <button type="submit" class="btn btn-primary">Create Account &amp; Finish <i class="bi bi-arrow-right ms-1"></i></button>
                </form>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>
</body>
</html>
