<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Include session.php – it should already load config.php
include_once 'session.php';
require_once 'security.php';

// If session.php does NOT load config.php, uncomment the next line
// include_once 'config.php';

verify_csrf_get();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = 'DELETE FROM userlog WHERE id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error'] = 'Database error: ' . htmlspecialchars($conn->error);
        header('Location: users.php');
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = 'User deleted successfully.';
        header('Location: users.php');
        exit;
    } else {
        $_SESSION['error'] = 'User not found or could not be deleted.';
        header('Location: users.php');
        exit;
    }
    $stmt->close();
} else {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: users.php');
    exit;
}
