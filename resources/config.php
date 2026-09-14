<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';

// --- Load credentials from .env (kept out of reach via .htaccess) ---------
if (!function_exists('loadEnvFile')) {
    function loadEnvFile(string $path): void
    {
        if (!is_readable($path)) {
            return;
        }
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key = trim($key);
            $value = trim($value);
            if ($key !== '' && getenv($key) === false) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}
if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}
loadEnvFile(__DIR__ . '/.env');

$servername = env('DB_HOST', 'localhost');
$username   = env('DB_USER', 'root');
$password   = env('DB_PASS', '');
$dbname     = env('DB_NAME', 'courier');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// THIS IS THE NEW CRUCIAL LINE
$conn->set_charset("utf8mb4");

$result = $conn->query("SELECT * FROM site");

if (!$result) {
    echo '<h2 style="text-align:center;">Query failed: ' . $conn->error . '</h2>';
    exit;
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $addr = $row['addr'];
    $phone = $row['phone'];
    $email = $row['email'];
    $chat = $row['tawk'];
    $url = $row['url'];
    $favicon = $row['favicon'];
    $track = $url . "/tracking.php";
} else {
    echo '<h2 style="text-align:center;">No Data Found</h2>';
    exit;
}

// These SMTP_* constants are the "nothing configured yet" placeholder used
// only until an admin saves real values from the dashboard (Email / SMTP
// Settings), and as the safety net if the mail_settings table is ever
// empty. Deliberately NOT sourced from .env -- a fresh install must never
// silently inherit a real mailbox's credentials from the environment; every
// site's SMTP has to be entered explicitly (installer or dashboard).
define('SMTP_HOST', '');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_FROM_NAME', $name ?? 'Courier');

// --- SMTP password encryption at rest --------------------------------------
// The mail_settings table never stores the SMTP password in plaintext; it is
// encrypted with APP_KEY (from .env) using AES-256-CBC before it's saved.

function mail_encryption_key(): string
{
    $key = env('APP_KEY', '');
    if ($key === '') {
        throw new RuntimeException('APP_KEY is missing from .env -- cannot encrypt/decrypt the SMTP password.');
    }
    return hash('sha256', $key, true); // 32 raw bytes, required for aes-256-cbc
}

function mail_encrypt(string $plaintext): string
{
    if ($plaintext === '') {
        return '';
    }
    $key = mail_encryption_key();
    $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $cipher = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $cipher);
}

function mail_decrypt(?string $encoded): string
{
    if (!$encoded) {
        return '';
    }
    $key = mail_encryption_key();
    $raw = base64_decode($encoded, true);
    if ($raw === false) {
        return '';
    }
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($raw, 0, $ivLength);
    $cipher = substr($raw, $ivLength);
    $plain = openssl_decrypt($cipher, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? '' : $plain;
}

// --- DB-backed SMTP / notification settings ---------------------------------

/**
 * Reads the single-row mail_settings table and returns it merged over the
 * .env-based defaults, with the SMTP password already decrypted. If the
 * table is empty (fresh install, migration not run), the .env defaults are
 * returned as-is.
 */
function getMailSettings(): array
{
    global $conn;

    $defaults = [
        'smtp_host' => SMTP_HOST,
        'smtp_port' => SMTP_PORT,
        'smtp_encryption' => 'tls',
        'smtp_username' => SMTP_USER,
        'smtp_password' => SMTP_PASS,
        'smtp_from_email' => SMTP_USER,
        'smtp_from_name' => SMTP_FROM_NAME,
        'smtp_reply_to' => '',
        'bcc_enabled' => 0,
        'bcc_email' => '',
        'notify_on_create' => 1,
        'notify_on_status_update' => 1,
    ];

    $result = $conn->query("SELECT * FROM mail_settings WHERE id = 1 LIMIT 1");
    $row = $result ? $result->fetch_assoc() : null;

    if (!$row) {
        return $defaults;
    }

    return [
        'smtp_host' => $row['smtp_host'] !== '' ? $row['smtp_host'] : $defaults['smtp_host'],
        'smtp_port' => (int) $row['smtp_port'],
        'smtp_encryption' => $row['smtp_encryption'] ?: $defaults['smtp_encryption'],
        'smtp_username' => $row['smtp_username'] !== '' ? $row['smtp_username'] : $defaults['smtp_username'],
        'smtp_password' => mail_decrypt($row['smtp_password_enc']) ?: $defaults['smtp_password'],
        'smtp_from_email' => $row['smtp_from_email'] !== '' ? $row['smtp_from_email'] : $defaults['smtp_from_email'],
        'smtp_from_name' => $row['smtp_from_name'] !== '' ? $row['smtp_from_name'] : $defaults['smtp_from_name'],
        'smtp_reply_to' => $row['smtp_reply_to'],
        'bcc_enabled' => (int) $row['bcc_enabled'],
        'bcc_email' => $row['bcc_email'],
        'notify_on_create' => (int) $row['notify_on_create'],
        'notify_on_status_update' => (int) $row['notify_on_status_update'],
    ];
}

/**
 * Sends an email using the dashboard-configured SMTP settings by default.
 * Pass $settingsOverride (same shape as getMailSettings()) to send using
 * values that haven't been saved yet -- used by the "Send test email" button
 * so admins can test before committing a change.
 */
function sendMailSMTP($to, $toName, $subject, $htmlBody, $textBody, $from = null, $fromName = null, ?array $settingsOverride = null)
{
    $settings = $settingsOverride ?? getMailSettings();

    $fromEmail = $from ?: $settings['smtp_from_email'];
    $fromDisplayName = $fromName ?: $settings['smtp_from_name'];

    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $settings['smtp_host'];
        $mail->Port       = $settings['smtp_port'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $settings['smtp_username'];
        $mail->Password   = $settings['smtp_password'];

        switch ($settings['smtp_encryption']) {
            case 'ssl':
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                break;
            case 'none':
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
                break;
            case 'tls':
            default:
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                break;
        }

        // Recipients
        $mail->setFrom($fromEmail, $fromDisplayName);
        $mail->addAddress($to, $toName);
        $mail->addReplyTo($settings['smtp_reply_to'] ?: $fromEmail, $fromDisplayName);

        if (!empty($settings['bcc_enabled']) && !empty($settings['bcc_email'])) {
            $mail->addBCC($settings['bcc_email']);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $textBody;

        $mail->send();
        return ['success' => true, 'message' => 'Email sent'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $mail->ErrorInfo];
    }
}

// --- Notification templates --------------------------------------------

/**
 * Fetch one email template by its key (e.g. 'parcel_created').
 * Returns null if it doesn't exist.
 */
function getEmailTemplate(string $key): ?array
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM email_templates WHERE template_key = ? LIMIT 1");
    $stmt->bind_param('s', $key);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

function listEmailTemplates(): array
{
    global $conn;
    $result = $conn->query("SELECT * FROM email_templates ORDER BY name");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

/**
 * Renders a template's subject/html_body/text_body by substituting
 * {{placeholder}} tokens.
 *
 * $data is used for the subject and the plain-text body (raw values).
 * $htmlData (if given) is used for the HTML body instead of $data -- pass
 * HTML-escaped values there so admin/customer-entered text can't break the
 * markup, while still being able to pass pre-built safe HTML fragments
 * (like a shipment-history table) through untouched.
 */
function renderEmailTemplate(array $template, array $data, ?array $htmlData = null): array
{
    $htmlData = $htmlData ?? $data;

    $wrap = function (array $values): array {
        $out = [];
        foreach ($values as $key => $value) {
            $out['{{' . $key . '}}'] = $value;
        }
        return $out;
    };

    return [
        'subject' => strtr($template['subject'], $wrap($data)),
        'html' => strtr($template['html_body'], $wrap($htmlData)),
        'text' => strtr($template['text_body'], $wrap($data)),
    ];
}

// --- Email send log -------------------------------------------------------

/**
 * Records the outcome of an email send attempt so it shows up in the
 * Notification Log and can be resent later if it failed.
 */
function logEmailSend(
    string $templateKey,
    string $recipientEmail,
    string $recipientName,
    string $subject,
    string $htmlBody,
    string $textBody,
    bool $success,
    string $errorMessage = '',
    string $trackingNumber = ''
): void {
    global $conn;
    $status = $success ? 'sent' : 'failed';
    $stmt = $conn->prepare(
        "INSERT INTO email_log
            (template_key, recipient_email, recipient_name, subject, html_body, text_body, status, error_message, tracking_number)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        'sssssssss',
        $templateKey,
        $recipientEmail,
        $recipientName,
        $subject,
        $htmlBody,
        $textBody,
        $status,
        $errorMessage,
        $trackingNumber
    );
    $stmt->execute();
    $stmt->close();
}

// --- UI helpers -------------------------------------------------------

/**
 * Renders a shipment status as a colored Bootstrap label/badge instead of
 * plain text, so status is scannable at a glance in the parcel list.
 */
function statusBadge(string $status): string
{
    $status = trim($status);
    if ($status === '') {
        return '<span class="badge bg-light text-muted border">&mdash;</span>';
    }

    $class = match (true) {
        str_contains($status, 'Delivered'), str_contains($status, 'Arrived') => 'bg-success',
        str_contains($status, 'Hold') => 'bg-danger',
        str_contains($status, 'Way'), str_contains($status, 'Pickup') => 'bg-warning text-dark',
        str_contains($status, 'Confirmed'), str_contains($status, 'Courier') => 'bg-info text-dark',
        default => 'bg-secondary',
    };

    return '<span class="badge ' . $class . '">' . htmlspecialchars($status) . '</span>';
}

/**
 * Human-friendly relative time (e.g. "5m ago") for a MySQL DATETIME string.
 */
function timeAgo(string $datetime): string
{
    $diff = time() - strtotime($datetime);
    if ($diff < 60) {
        return 'just now';
    }
    if ($diff < 3600) {
        return (int) floor($diff / 60) . 'm ago';
    }
    if ($diff < 86400) {
        return (int) floor($diff / 3600) . 'h ago';
    }
    return (int) floor($diff / 86400) . 'd ago';
}

/**
 * Notifications shown in the admin topbar bell: failed email deliveries and
 * active login lockouts (a signal of possible brute-force attempts).
 * Fails safe (returns empty) if a table is missing rather than erroring.
 */
function getAdminNotifications(mysqli $conn, int $limit = 5): array
{
    $failed = ['count' => 0, 'items' => []];
    $security = ['count' => 0, 'items' => []];

    $countResult = $conn->query("SELECT COUNT(*) AS c FROM email_log WHERE status = 'failed' AND created_at >= NOW() - INTERVAL 7 DAY");
    if ($countResult) {
        $failed['count'] = (int) ($countResult->fetch_assoc()['c'] ?? 0);

        $itemsResult = $conn->query("SELECT recipient_email, created_at FROM email_log WHERE status = 'failed' ORDER BY created_at DESC LIMIT " . (int) $limit);
        if ($itemsResult) {
            while ($row = $itemsResult->fetch_assoc()) {
                $failed['items'][] = [
                    'message' => 'Failed to email ' . $row['recipient_email'],
                    'time' => timeAgo($row['created_at']),
                ];
            }
        }
    }

    $secCountResult = $conn->query("SELECT COUNT(*) AS c FROM login_attempts WHERE locked_until IS NOT NULL AND locked_until > NOW()");
    if ($secCountResult) {
        $security['count'] = (int) ($secCountResult->fetch_assoc()['c'] ?? 0);

        $secItemsResult = $conn->query("SELECT identifier, locked_until FROM login_attempts WHERE locked_until IS NOT NULL AND locked_until > NOW() ORDER BY locked_until DESC LIMIT " . (int) $limit);
        if ($secItemsResult) {
            while ($row = $secItemsResult->fetch_assoc()) {
                $parts = explode('|', $row['identifier']);
                $security['items'][] = [
                    'message' => 'Login locked: "' . ($parts[0] ?? 'unknown') . '" from ' . ($parts[1] ?? 'unknown IP'),
                    'time' => 'until ' . date('H:i', strtotime($row['locked_until'])),
                ];
            }
        }
    }

    return ['failed_emails' => $failed, 'security' => $security];
}

/**
 * Absolute base URL of the admin app (e.g. "https://example.com/courier/resources"),
 * used to build fully-qualified asset URLs (like the logo) for outgoing emails --
 * a relative "img/header.png" would break in every email client.
 */
function siteBaseUrl(): string
{
    if (php_sapi_name() === 'cli' || empty($_SERVER['HTTP_HOST'])) {
        return rtrim(env('APP_URL', 'http://localhost'), '/');
    }
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    return $scheme . '://' . $_SERVER['HTTP_HOST'] . $dir;
}

// --- Appearance: color schemes & themes ------------------------------------

/**
 * Fixed, pre-designed gradient presets for the public tracking-result page.
 * Fixed catalog of languages the translator widget (resources/translator.php,
 * included by every theme's header) can offer. Admin > Appearance picks a
 * subset of these (site.translate_languages); this same catalog supplies
 * the human-readable labels the front-end widget's own <select> shows.
 */
function translatorLanguageCatalog(): array
{
    return [
        'en' => 'English', 'fr' => 'French', 'es' => 'Spanish', 'de' => 'German',
        'it' => 'Italian', 'pt' => 'Portuguese', 'ar' => 'Arabic', 'zh-CN' => 'Chinese (Simplified)',
        'zh-TW' => 'Chinese (Traditional)', 'ko' => 'Korean', 'ja' => 'Japanese', 'ru' => 'Russian',
        'hi' => 'Hindi', 'nl' => 'Dutch', 'tr' => 'Turkish', 'pl' => 'Polish', 'sv' => 'Swedish',
        'da' => 'Danish', 'no' => 'Norwegian', 'fi' => 'Finnish', 'is' => 'Icelandic',
        'el' => 'Greek', 'he' => 'Hebrew', 'id' => 'Indonesian', 'ms' => 'Malay',
        'th' => 'Thai', 'vi' => 'Vietnamese', 'fil' => 'Filipino', 'km' => 'Khmer', 'lo' => 'Lao',
        'my' => 'Burmese', 'mn' => 'Mongolian',
        // Eastern & Central Europe
        'uk' => 'Ukrainian', 'cs' => 'Czech', 'sk' => 'Slovak', 'ro' => 'Romanian',
        'hu' => 'Hungarian', 'bg' => 'Bulgarian', 'hr' => 'Croatian', 'sr' => 'Serbian',
        'sl' => 'Slovenian', 'bs' => 'Bosnian', 'mk' => 'Macedonian', 'sq' => 'Albanian',
        'lt' => 'Lithuanian', 'lv' => 'Latvian', 'et' => 'Estonian', 'be' => 'Belarusian',
        // Western Europe & other
        'ga' => 'Irish', 'cy' => 'Welsh', 'mt' => 'Maltese', 'eu' => 'Basque',
        'ca' => 'Catalan', 'gl' => 'Galician',
        // South & Central Asia
        'bn' => 'Bengali', 'ur' => 'Urdu', 'fa' => 'Persian', 'ps' => 'Pashto',
        'pa' => 'Punjabi', 'ta' => 'Tamil', 'te' => 'Telugu', 'mr' => 'Marathi',
        'gu' => 'Gujarati', 'kn' => 'Kannada', 'ml' => 'Malayalam', 'ne' => 'Nepali',
        'si' => 'Sinhala',
        // Caucasus & Central Asia
        'ka' => 'Georgian', 'hy' => 'Armenian', 'az' => 'Azerbaijani', 'kk' => 'Kazakh', 'uz' => 'Uzbek',
        // Africa
        'sw' => 'Swahili', 'am' => 'Amharic', 'af' => 'Afrikaans', 'zu' => 'Zulu',
        'xh' => 'Xhosa', 'yo' => 'Yoruba', 'ig' => 'Igbo', 'ha' => 'Hausa', 'so' => 'Somali',
        // Other
        'ht' => 'Haitian Creole',
    ];
}

/**
 * Admins pick one by name in Admin > Appearance -- there is no free-form
 * gradient/color picker, by design.
 */
function colorSchemes(): array
{
    return [
        'red' => [
            'label' => 'Red',
            'brand' => '#c42031',
            'brand_dark' => '#8a1620',
            'gradient' => 'linear-gradient(135deg, #9c1826 0%, #c42031 50%, #a01b28 100%)',
            'shadow' => 'rgba(156,24,38,.5)',
            'text' => '#fff',
            'text_rgb' => '255,255,255',
        ],
        'blue' => [
            'label' => 'Blue',
            'brand' => '#3655FF',
            'brand_dark' => '#2540cc',
            'gradient' => 'linear-gradient(135deg, #2540cc 0%, #3655FF 50%, #2c4ad9 100%)',
            'shadow' => 'rgba(37,64,204,.5)',
            'text' => '#fff',
            'text_rgb' => '255,255,255',
        ],
        'yellow' => [
            'label' => 'Yellow',
            'brand' => '#FEC201',
            'brand_dark' => '#E0A900',
            'gradient' => 'linear-gradient(135deg, #E0A900 0%, #FEC201 50%, #F0B800 100%)',
            'shadow' => 'rgba(224,169,0,.5)',
            // Yellow is too light for white text to read on -- every other
            // scheme uses white, this one uses near-black instead.
            'text' => '#1a1400',
            'text_rgb' => '26,20,0',
        ],
        'green' => [
            'label' => 'Green',
            'brand' => '#0c8378',
            'brand_dark' => '#0a685f',
            'gradient' => 'linear-gradient(135deg, #0a685f 0%, #0c8378 50%, #0b7269 100%)',
            'shadow' => 'rgba(10,104,95,.5)',
            'text' => '#fff',
            'text_rgb' => '255,255,255',
        ],
    ];
}

function getColorScheme(?string $key): array
{
    $schemes = colorSchemes();
    return $schemes[$key] ?? $schemes['red'];
}

/**
 * Every folder under themes/, with a friendly label and whether it actually
 * has a PHP entry point (index.php) -- static/unfinished themes (e.g. a raw
 * HTML mirror) show up but aren't selectable yet.
 */
function listThemes(): array
{
    $themesDir = __DIR__ . '/../themes';
    $themes = [];

    if (!is_dir($themesDir)) {
        return $themes;
    }

    foreach (scandir($themesDir) as $entry) {
        if ($entry === '.' || $entry === '..' || !is_dir($themesDir . '/' . $entry)) {
            continue;
        }
        $label = ucwords(str_replace(['_', '-'], ' ', preg_replace('/(\d+)$/', ' $1', $entry)));
        $themes[] = [
            'key' => $entry,
            'label' => trim($label),
            'ready' => is_file($themesDir . '/' . $entry . '/index.php'),
        ];
    }

    usort($themes, fn($a, $b) => $a['key'] <=> $b['key']);
    return $themes;
}
