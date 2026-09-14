<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php (reassigned below to the user being edited) */
/** @var string $login_session Logged-in username, set in session.php */

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}

include_once 'config.php';
require_once 'security.php';

$message = '';

if (count($_POST) > 0) {
    verify_csrf();

    $newUsername = trim($_POST['username'] ?? '');
    $newPassword = trim($_POST['password'] ?? '');

    if ($newUsername === '') {
        $message = '<div class="alert alert-danger">Username cannot be empty.</div>';
    } elseif ($newPassword !== '' && strlen($newPassword) < 8) {
        $message = '<div class="alert alert-danger">New password must be at least 8 characters.</div>';
    } else {
        if ($newPassword !== '') {
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE userlog SET username = ?, password = ? WHERE username = ?");
            $stmt->bind_param('sss', $newUsername, $hashed, $user_check);
        } else {
            $stmt = $conn->prepare("UPDATE userlog SET username = ? WHERE username = ?");
            $stmt->bind_param('ss', $newUsername, $user_check);
        }
        $stmt->execute();
        $stmt->close();

        $_SESSION['login_user'] = $newUsername;
        $user_check = $newUsername;

        $message = '<div class="alert alert-success alert-dismissible fade show">
            <strong>Well done!</strong> Login information updated!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    }
}

$stmt = $conn->prepare("SELECT * FROM userlog WHERE username = ?");
$stmt->bind_param('s', $user_check);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

$pageTitle = 'Change Password';
$activeNav = 'password';
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Change Password</h1>
                    <div class="text-muted small">Update your own admin login credentials.</div>
                </div>

                <?php if (!empty($message)) echo $message; ?>

                <form class="admin-card" style="max-width:560px;" name="frmUser" method="post" action="">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int) ($row['id'] ?? 0); ?>">

                    <div class="admin-card-body">
                        <div class="mb-3">
                            <label class="form-label">Current Username</label>
                            <input type="text" class="form-control" disabled
                                value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Change Username</label>
                            <input type="text" class="form-control" placeholder="Enter New Username"
                                name="username" value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Change Password</label>
                            <input type="password" class="form-control" placeholder="Leave blank to keep current password"
                                name="password" value="" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="admin-card-header border-top border-bottom-0">
                        <button type="submit" name="submit" value="Submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
<?php include 'partials/admin_end.php'; ?>
