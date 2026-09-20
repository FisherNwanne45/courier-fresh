<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}
include_once 'config.php';
require_once 'security.php';

$message = '';
$testResultMessage = '';

// Whatever is currently saved -- used to pre-fill the form and as the
// fallback when the password field, or a test-send, is left blank.
$saved = getMailSettings();

$encryptionOptions = [
    'tls' => 'STARTTLS (recommended, port 587)',
    'ssl' => 'SSL / TLS (port 465)',
    'none' => 'None (unencrypted, not recommended)',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $action = $_POST['action'] ?? 'save';

    $posted = [
        'smtp_host' => trim($_POST['smtp_host'] ?? ''),
        'smtp_port' => (int) ($_POST['smtp_port'] ?? 587),
        'smtp_encryption' => in_array($_POST['smtp_encryption'] ?? '', ['tls', 'ssl', 'none'], true)
            ? $_POST['smtp_encryption']
            : 'tls',
        'smtp_username' => trim($_POST['smtp_username'] ?? ''),
        'smtp_from_email' => trim($_POST['smtp_from_email'] ?? ''),
        'smtp_from_name' => trim($_POST['smtp_from_name'] ?? ''),
        'smtp_reply_to' => trim($_POST['smtp_reply_to'] ?? ''),
        'bcc_enabled' => !empty($_POST['bcc_enabled']) ? 1 : 0,
        'bcc_email' => trim($_POST['bcc_email'] ?? ''),
        'notify_on_create' => !empty($_POST['notify_on_create']) ? 1 : 0,
        'notify_on_status_update' => !empty($_POST['notify_on_status_update']) ? 1 : 0,
    ];

    // Password field is masked and left blank on every page load; only a
    // non-blank value here means the admin actually typed a new one.
    $newPasswordEntered = trim($_POST['smtp_password'] ?? '');
    $posted['smtp_password'] = $newPasswordEntered !== '' ? $newPasswordEntered : $saved['smtp_password'];

    $validationError = '';
    if ($posted['smtp_host'] === '') {
        $validationError = 'SMTP host is required.';
    } elseif ($posted['smtp_port'] < 1 || $posted['smtp_port'] > 65535) {
        $validationError = 'SMTP port must be between 1 and 65535.';
    } elseif ($posted['smtp_from_email'] === '' || !filter_var($posted['smtp_from_email'], FILTER_VALIDATE_EMAIL)) {
        $validationError = 'A valid "From" email address is required.';
    } elseif ($posted['bcc_enabled'] && !filter_var($posted['bcc_email'], FILTER_VALIDATE_EMAIL)) {
        $validationError = 'BCC is enabled but the BCC email address is invalid.';
    }

    if ($validationError !== '') {
        $message = '<div class="alert alert-danger">' . htmlspecialchars($validationError) . '</div>';
    } elseif ($action === 'test') {
        $testRecipient = trim($_POST['test_recipient'] ?? '');
        if (!filter_var($testRecipient, FILTER_VALIDATE_EMAIL)) {
            $testResultMessage = '<div class="alert alert-danger">Enter a valid email address to send the test to.</div>';
        } else {
            $result = sendMailSMTP(
                $testRecipient,
                $testRecipient,
                'Test email from ' . ($posted['smtp_from_name'] ?: 'your courier admin'),
                '<p>This is a test email sent from the <strong>Email / SMTP Settings</strong> page.</p>'
                    . '<p>If you received this, the SMTP settings currently in the form are working.</p>',
                "This is a test email sent from the Email / SMTP Settings page.\nIf you received this, the SMTP settings currently in the form are working.",
                $posted['smtp_from_email'],
                $posted['smtp_from_name'],
                $posted // send using what's in the form right now, saved or not
            );

            $testResultMessage = $result['success']
                ? '<div class="alert alert-success">Test email sent to ' . htmlspecialchars($testRecipient) . '. Check the inbox (and spam folder).</div>'
                : '<div class="alert alert-danger">Test email failed: ' . htmlspecialchars($result['message']) . '</div>';
        }
        // Keep showing what the admin typed, since nothing was saved.
        $saved = $posted;
    } else {
        $encPassword = mail_encrypt($posted['smtp_password']);

        $stmt = $conn->prepare(
            "UPDATE mail_settings SET
                smtp_host = ?, smtp_port = ?, smtp_encryption = ?, smtp_username = ?,
                smtp_password_enc = ?, smtp_from_email = ?, smtp_from_name = ?, smtp_reply_to = ?,
                bcc_enabled = ?, bcc_email = ?, notify_on_create = ?, notify_on_status_update = ?,
                updated_at = NOW()
             WHERE id = 1"
        );
        $stmt->bind_param(
            'sissssssisii',
            $posted['smtp_host'],
            $posted['smtp_port'],
            $posted['smtp_encryption'],
            $posted['smtp_username'],
            $encPassword,
            $posted['smtp_from_email'],
            $posted['smtp_from_name'],
            $posted['smtp_reply_to'],
            $posted['bcc_enabled'],
            $posted['bcc_email'],
            $posted['notify_on_create'],
            $posted['notify_on_status_update']
        );
        $stmt->execute();
        $stmt->close();

        $message = '<div class="alert alert-success">Email / SMTP settings saved.</div>';
        $saved = getMailSettings();
    }
}

$pageTitle = 'Email / SMTP Settings';
$activeNav = 'email_settings';
include 'partials/admin_start.php';
?>
<div class="mb-4">
    <h1 class="h4 mb-0">Email / SMTP Settings</h1>
    <div class="text-muted small">Configure the mail server used to send tracking notifications.</div>
</div>

<?php if ($saved['smtp_host'] === SMTP_HOST && $saved['smtp_username'] === SMTP_USER): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-1"></i>
        These are still the fallback values from the server's .env file. Fill in and save your
        real SMTP provider details below.
    </div>
<?php endif; ?>
<?= $message ?>
<?= $testResultMessage ?>

<form class="admin-card mb-4" action="" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="action" value="save">
    <div class="admin-card-body">
        <h2 class="h6 text-uppercase text-muted mb-3 border-bottom pb-2">SMTP Server</h2>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">SMTP Host</label>
                <input type="text" name="smtp_host" id="smtp_host" class="form-control" placeholder="smtp.example.com"
                    value="<?= htmlspecialchars($saved['smtp_host']) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">SMTP Port</label>
                <input type="number" name="smtp_port" id="smtp_port" class="form-control"
                    value="<?= (int) $saved['smtp_port'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Encryption</label>
                <select name="smtp_encryption" id="smtp_encryption" class="form-select">
                    <?php foreach ($encryptionOptions as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $saved['smtp_encryption'] === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">SMTP Username</label>
                <input type="text" name="smtp_username" id="smtp_username" class="form-control"
                    value="<?= htmlspecialchars($saved['smtp_username']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">SMTP Password</label>
                <input type="password" name="smtp_password" id="smtp_password" class="form-control"
                    placeholder="Leave blank to keep the saved password" autocomplete="new-password">
            </div>
        </div>

        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Outgoing Mail Identity</h2>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">From Email</label>
                <input type="email" name="smtp_from_email" id="smtp_from_email" class="form-control"
                    value="<?= htmlspecialchars($saved['smtp_from_email']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">From Name</label>
                <input type="text" name="smtp_from_name" id="smtp_from_name" class="form-control"
                    value="<?= htmlspecialchars($saved['smtp_from_name']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Reply-To (optional)</label>
                <input type="email" name="smtp_reply_to" id="smtp_reply_to" class="form-control"
                    placeholder="Defaults to the From Email above"
                    value="<?= htmlspecialchars($saved['smtp_reply_to']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">BCC a copy to</label>
                <input type="email" name="bcc_email" id="bcc_email" class="form-control mb-2"
                    placeholder="admin@example.com" value="<?= htmlspecialchars($saved['bcc_email']) ?>">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bcc_enabled" value="1" id="bcc_enabled"
                        <?= $saved['bcc_enabled'] ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="bcc_enabled">
                        Send a blind copy of every outgoing email to this address
                    </label>
                </div>
            </div>
        </div>

        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Notifications</h2>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="notify_on_create" value="1" id="notify_on_create"
                <?= $saved['notify_on_create'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="notify_on_create">
                Email the receiver when a new tracking record is created
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="notify_on_status_update" value="1"
                id="notify_on_status_update" <?= $saved['notify_on_status_update'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="notify_on_status_update">
                Email the receiver when a tracking record's status is updated
            </label>
        </div>
    </div>
    <div class="admin-card-header border-top border-bottom-0">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Save Settings</button>
    </div>
</form>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><i class="bi bi-send me-2 text-primary"></i>Send a Test Email</h2>
    </div>
    <div class="admin-card-body">
        <p class="text-muted small">
            Sends using whatever is currently in the form above (even if you haven't saved yet),
            so you can confirm it works before committing the change.
        </p>
        <form action="" method="post" class="row g-2 align-items-end"
            onsubmit="return copySmtpFieldsIntoTestForm(this);">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="test">
            <div class="col-sm-8 col-md-6">
                <label class="form-label">Send test to</label>
                <input type="email" name="test_recipient" id="test_recipient" class="form-control"
                    placeholder="you@example.com" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-send me-1"></i>Send Test Email
                </button>
            </div>
            <!-- Mirrors of the SMTP fields above so the test form can be submitted
                                 independently while still testing the currently-typed values. -->
            <input type="hidden" name="smtp_host" id="test_smtp_host">
            <input type="hidden" name="smtp_port" id="test_smtp_port">
            <input type="hidden" name="smtp_encryption" id="test_smtp_encryption">
            <input type="hidden" name="smtp_username" id="test_smtp_username">
            <input type="hidden" name="smtp_password" id="test_smtp_password">
            <input type="hidden" name="smtp_from_email" id="test_smtp_from_email">
            <input type="hidden" name="smtp_from_name" id="test_smtp_from_name">
            <input type="hidden" name="smtp_reply_to" id="test_smtp_reply_to">
            <input type="hidden" name="bcc_enabled" id="test_bcc_enabled">
            <input type="hidden" name="bcc_email" id="test_bcc_email">
        </form>
    </div>
</div>
<?php
$extraScripts = <<<'HTML'
<script>
function copySmtpFieldsIntoTestForm(testForm) {
    var ids = ['smtp_host', 'smtp_port', 'smtp_encryption', 'smtp_username',
        'smtp_password', 'smtp_from_email', 'smtp_from_name', 'smtp_reply_to',
        'bcc_email'];
    ids.forEach(function (id) {
        var source = document.getElementById(id);
        var target = document.getElementById('test_' + id);
        if (source && target) {
            target.value = source.value;
        }
    });

    var bccSource = document.getElementById('bcc_enabled');
    var testBcc = document.getElementById('test_bcc_enabled');
    if (bccSource && bccSource.checked) {
        testBcc.disabled = false;
        testBcc.value = '1';
    } else {
        testBcc.disabled = true;
    }
    return true;
}
</script>
HTML;
include 'partials/admin_end.php';
?>