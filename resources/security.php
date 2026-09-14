<?php
/**
 * Shared security helpers: CSRF tokens, login throttling, and the
 * plaintext -> bcrypt password migration check.
 *
 * Must be included after session_start(). Depends on nothing else.
 */

// --- CSRF -----------------------------------------------------------------

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

/**
 * Call at the top of any POST handler that changes state.
 * Halts the request with a 403 if the token is missing/invalid.
 */
function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if ($token === '' || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die('Your session has expired or the form was submitted incorrectly. Please go back, refresh the page, and try again.');
    }
}

/**
 * For state-changing GET links (e.g. delete actions rendered as <a href>).
 * Append csrf_url_token() to the query string, verify with verify_csrf_get().
 */
function csrf_url_token(): string
{
    return urlencode(csrf_token());
}

function verify_csrf_get(): void
{
    $token = $_GET['csrf_token'] ?? '';
    if ($token === '' || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die('Invalid or expired link. Please go back and try again.');
    }
}

// --- Login throttling -------------------------------------------------

const LOGIN_MAX_ATTEMPTS = 5;
const LOGIN_LOCKOUT_MINUTES = 15;

function login_identifier(string $username): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    return strtolower(trim($username)) . '|' . $ip;
}

/**
 * Returns minutes remaining if locked, or null if the login may proceed.
 */
function login_is_locked(mysqli $connection, string $username): ?int
{
    $identifier = login_identifier($username);
    $stmt = mysqli_prepare($connection, "SELECT locked_until FROM login_attempts WHERE identifier = ?");
    if (!$stmt) {
        return null; // fail open if the migration hasn't been run yet
    }
    mysqli_stmt_bind_param($stmt, 's', $identifier);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if ($row && $row['locked_until'] && strtotime($row['locked_until']) > time()) {
        return (int) ceil((strtotime($row['locked_until']) - time()) / 60);
    }
    return null;
}

function login_register_failure(mysqli $connection, string $username): void
{
    $identifier = login_identifier($username);

    $stmt = mysqli_prepare($connection, "SELECT attempts FROM login_attempts WHERE identifier = ?");
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 's', $identifier);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    $attempts = (int) ($row['attempts'] ?? 0) + 1;
    $lockedUntil = $attempts >= LOGIN_MAX_ATTEMPTS
        ? date('Y-m-d H:i:s', time() + LOGIN_LOCKOUT_MINUTES * 60)
        : null;

    $stmt = mysqli_prepare(
        $connection,
        "INSERT INTO login_attempts (identifier, attempts, first_attempt_at, locked_until)
         VALUES (?, ?, NOW(), ?)
         ON DUPLICATE KEY UPDATE attempts = VALUES(attempts), locked_until = VALUES(locked_until)"
    );
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 'sis', $identifier, $attempts, $lockedUntil);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function login_reset(mysqli $connection, string $username): void
{
    $identifier = login_identifier($username);
    $stmt = mysqli_prepare($connection, "DELETE FROM login_attempts WHERE identifier = ?");
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 's', $identifier);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// --- Password hashing helper -----------------------------------------

function password_is_bcrypt(?string $hash): bool
{
    return $hash !== null && preg_match('/^\$2[axy]\$/', $hash) === 1;
}
