<?php
// Ensure session is started if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
include('config.php');
/** @var string $servername Set in config.php */
/** @var string $username Set in config.php */
/** @var string $password Set in config.php */
/** @var string $dbname Set in config.php */

// Establish database connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check database connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select database
$db = mysqli_select_db($connection, $dbname);

// Check if user session exists and fetch user details
if (isset($_SESSION['login_user'])) {
    // Idle timeout: sign the admin out after a period of inactivity, rather
    // than relying on the session cookie/file staying alive indefinitely.
    $idleTimeoutSeconds = 30 * 60; // 30 minutes
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $idleTimeoutSeconds) {
        $_SESSION = [];
        session_unset();
        session_destroy();
        mysqli_close($connection);
        header('Location: login.php?timeout=1');
        exit();
    }
    $_SESSION['last_activity'] = time();

    $user_check = $_SESSION['login_user'];
    $ses_stmt = mysqli_prepare($connection, "SELECT * FROM userlog WHERE username = ?");
    mysqli_stmt_bind_param($ses_stmt, 's', $user_check);
    mysqli_stmt_execute($ses_stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($ses_stmt));
    mysqli_stmt_close($ses_stmt);
    $ses_sql2 = mysqli_query($connection, "SELECT * FROM site");
    $rows = mysqli_fetch_assoc($ses_sql2);

    // Check if user session data exists
    if (!$row) {
        mysqli_close($connection); // Close database connection if session data not found
        header('Location: login.php'); // Redirect to login page if session data not found
        exit(); // Stop further script execution
    }

    $login_session = $row['username'];
    $id = $row['id']; // Example: Fetching user ID from session

    // Additional session tasks or user data retrieval can be added here
} else {
    mysqli_close($connection); // Close database connection if user is not logged in
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit(); // Stop further script execution
}

// Close database connection after use
mysqli_close($connection);