<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

// Use include_once to avoid double inclusion and function redeclaration
include_once 'config.php';
require_once 'security.php';
// If front.php is necessary, include it after config (or not, depending on its purpose)
// include_once 'front.php';   // uncomment if needed

verify_csrf_get();

// Check if we have a valid numeric ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Prepare and execute delete statement
    $sql = 'DELETE FROM user WHERE id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Database error during prepare
        $_SESSION['error'] = 'Database error: ' . htmlspecialchars($conn->error);
        header('Location: index.php');
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Success: set a success message and redirect
        $_SESSION['success'] = 'Record deleted successfully.';
        header('Location: index.php');
        exit;
    } else {
        // No rows affected (record not found)
        $_SESSION['error'] = 'Record not found or could not be deleted.';
        header('Location: index.php');
        exit;
    }
    $stmt->close();
} else {
    // Invalid or missing ID
    $_SESSION['error'] = 'Invalid request.';
    header('Location: index.php');
    exit;
}
