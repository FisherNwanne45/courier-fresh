<?php
include_once('config.php');
/** @var string $servername Set in config.php */
/** @var string $username Set in config.php */
/** @var string $password Set in config.php */
/** @var string $dbname Set in config.php */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Checking Connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Selecting Database
$db = mysqli_select_db($connection, "$dbname");

// Check if session variable 'login_user' is set
if (isset($_SESSION['login_user'])) {
    // Storing Session
    $user_check = $_SESSION['login_user'];
    // SQL Query To Fetch Complete Information Of User
    $ses_stmt = mysqli_prepare($connection, "SELECT * FROM userlog WHERE username = ?");
    mysqli_stmt_bind_param($ses_stmt, 's', $user_check);
    mysqli_stmt_execute($ses_stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($ses_stmt));
    mysqli_stmt_close($ses_stmt);
    $login_session = $row['username'] ?? null;
    $id = $row['id'] ?? null;
} else {
    // Handle the case where the session variable is not set
    $login_session = null;
    $id = null;
}