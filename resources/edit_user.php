<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php (reassigned below to the vault user being edited) */
/** @var string $login_session Logged-in username, set in session.php */
require_once('security.php');
include_once 'config.php';

if (count($_POST) > 0) {
    verify_csrf();

    $editId = (int) ($_POST['id'] ?? 0);

    // Whitelisted columns this form is allowed to update.
    $fields = [
        'paydate', 'username', 'qty', 'frt', 'deptim', 'pudate', 'putm', 'pudes',
        'rmk', 'rmk2', 'rmk3', 'rmk4', 'rmk5', 'rmk6', 'rmk7',
        'cdt3', 'cdt4', 'cdt5', 'cdt6', 'cdt7',
        'ctm3', 'ctm4', 'ctm5', 'ctm6', 'ctm7',
        'loc3', 'loc4', 'loc5', 'loc6', 'loc7',
        'status3', 'status4', 'status5', 'status6', 'status7',
        'rank2', 'mail2', 'mail', 'phone2', 'paym', 'shipm', 'comment',
        'status2', 'cdt', 'ctm', 'cdt2', 'ctm2', 'coldate',
        'loc1', 'loc2', 'amt', 'type', 'dur', 'rate', 'phone', 'name', 'rank', 'cid',
        'status', 'remark',
    ];

    $values = [];
    foreach ($fields as $field) {
        $values[$field] = $_POST[$field] ?? '';
    }

    // Password is optional here: only touch it if a new one was supplied,
    // and always store it hashed -- never plaintext.
    $newPassword = trim($_POST['password'] ?? '');
    if ($newPassword !== '') {
        $fields[] = 'password';
        $values['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    $setClause = implode(', ', array_map(fn($f) => "`$f` = ?", $fields));
    $bindValues = array_map(fn($f) => $values[$f], $fields);
    $bindValues[] = $editId;

    $stmt = $conn->prepare("UPDATE userlog SET $setClause WHERE id = ?");
    $stmt->execute($bindValues);
    $stmt->close();

    $_SESSION['Success'] = 'Vault User successfully edited!';
    header('Location: edit_user.php?id=' . $editId);
    exit();
}

$viewId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM userlog WHERE id = ?");
$stmt->bind_param('i', $viewId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row) {
    die('Vault user not found.');
}

$pageTitle = 'Edit Vault User';
$activeNav = 'vault';
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Edit Vault User &mdash; <?php echo htmlspecialchars($row['name'] ?? ''); ?></h1>
                </div>

                <?php if (isset($_SESSION['Success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['Success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['Success']); ?>
                <?php endif; ?>

                <form class="admin-card" method="post" action="">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int) ($row['id'] ?? 0); ?>">

                    <div class="admin-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vault Serial Number</label>
                                <input type="text" name="cid" value="<?php echo htmlspecialchars($row['cid'] ?? ''); ?>" class="form-control">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Vault Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="remark" value="<?php echo htmlspecialchars($row['remark'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vault Content</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="text" name="username" value="<?php echo htmlspecialchars($row['username'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" value="" placeholder="Leave blank to keep current password" class="form-control" autocomplete="new-password">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Receipt Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Import Tax Charges</label>
                                <input type="text" name="rank" value="<?php echo htmlspecialchars($row['rank'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Import Tax Remark</label>
                                <select name="phone" class="form-select" required>
                                    <option value="Cleared" <?php if ($row['phone'] == 'Cleared') echo 'selected'; ?>>Cleared</option>
                                    <option value="Not Cleared" <?php if ($row['phone'] == 'Not Cleared') echo 'selected'; ?>>Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">VAT Charges</label>
                                <input type="text" name="mail" value="<?php echo htmlspecialchars($row['mail'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">VAT Remark</label>
                                <select name="type" class="form-select" required>
                                    <option value="Cleared" <?php if ($row['type'] == 'Cleared') echo 'selected'; ?>>Cleared</option>
                                    <option value="Not Cleared" <?php if ($row['type'] == 'Not Cleared') echo 'selected'; ?>>Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Inspection Fee Charges</label>
                                <input type="text" name="dur" value="<?php echo htmlspecialchars($row['dur'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Inspection Fee Remarks</label>
                                <select name="paydate" class="form-select" required>
                                    <option value="Cleared" <?php if ($row['paydate'] == 'Cleared') echo 'selected'; ?>>Cleared</option>
                                    <option value="Not Cleared" <?php if ($row['paydate'] == 'Not Cleared') echo 'selected'; ?>>Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Handling Charges</label>
                                <input type="text" name="loc1" value="<?php echo htmlspecialchars($row['loc1'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Handling Remarks</label>
                                <select name="cdt" class="form-select" required>
                                    <option value="Cleared" <?php if ($row['cdt'] == 'Cleared') echo 'selected'; ?>>Cleared</option>
                                    <option value="Not Cleared" <?php if ($row['cdt'] == 'Not Cleared') echo 'selected'; ?>>Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Storage Fee Charges</label>
                                <input type="text" name="status" value="<?php echo htmlspecialchars($row['status'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Storage Fee Remarks</label>
                                <select name="mail2" class="form-select" required>
                                    <option value="Cleared" <?php if ($row['mail2'] == 'Cleared') echo 'selected'; ?>>Cleared</option>
                                    <option value="Not Cleared" <?php if ($row['mail2'] == 'Not Cleared') echo 'selected'; ?>>Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Insurance Fee Charges</label>
                                <input type="text" name="phone2" value="<?php echo htmlspecialchars($row['phone2'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Insurance Fee Remarks</label>
                                <select name="paym" class="form-select" required>
                                    <option value="Cleared" <?php if ($row['paym'] == 'Cleared') echo 'selected'; ?>>Cleared</option>
                                    <option value="Not Cleared" <?php if ($row['paym'] == 'Not Cleared') echo 'selected'; ?>>Not Cleared</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="amt" value="user">
                    </div>
                    <div class="admin-card-header border-top border-bottom-0">
                        <button type="submit" name="submit" value="Submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
<?php include 'partials/admin_end.php'; ?>
