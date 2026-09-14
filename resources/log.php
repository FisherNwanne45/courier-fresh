<?php
session_start(); // Ensure this is called only once per request
include_once('front.php'); // Includes DB connection ($connection) and site data
/** @var mysqli $connection Set in front.php */
require_once __DIR__ . '/security.php';

$error = ''; // Variable To Store Error Message

if (isset($_GET['timeout']) && !isset($_POST['submit'])) {
    $error = 'Your session has expired due to inactivity. Please log in again.';
}

if (isset($_POST['submit'])) {
    verify_csrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username or Password is invalid";
    } else {
        $lockedMinutes = login_is_locked($connection, $username);

        if ($lockedMinutes !== null) {
            $error = "Too many failed login attempts. Please try again in {$lockedMinutes} minute(s).";
        } else {
            $stmt = mysqli_prepare($connection, "SELECT * FROM userlog WHERE username = ?");
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
            mysqli_stmt_close($stmt);

            $authenticated = false;

            if ($row) {
                $storedHash = $row['password'] ?? '';

                if (password_is_bcrypt($storedHash)) {
                    $authenticated = password_verify($password, $storedHash);
                } elseif (hash_equals((string) $storedHash, $password)) {
                    // Legacy plaintext password on record: it matches, so let the user
                    // in and transparently upgrade it to a proper hash for next time.
                    $authenticated = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $upd = mysqli_prepare($connection, "UPDATE userlog SET password = ? WHERE id = ?");
                    mysqli_stmt_bind_param($upd, 'si', $newHash, $row['id']);
                    mysqli_stmt_execute($upd);
                    mysqli_stmt_close($upd);
                }
            }

            if ($authenticated) {
                login_reset($connection, $username);
                session_regenerate_id(true); // prevent session fixation

                $_SESSION['login_user'] = $row['username'];
                $link = ($row['amt'] === 'admin') ? 'index.php' : 'vault.php';

                header("location: " . $link);
                exit();
            } else {
                login_register_failure($connection, $username);
                $error = "Username or Password is invalid";
            }
        }
    }

    mysqli_close($connection); // Closing Connection
}
