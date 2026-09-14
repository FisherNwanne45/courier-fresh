<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once('config.php');
require_once('security.php');

if (isset($_POST['save'])) {
    verify_csrf();
    $target_dir = "img/";
    $filename = explode('.', $_FILES['image']['name']);
    $ext = $filename[count($filename) - 1];
    $imgname = time() . '.' . $ext;
    $target_file = $target_dir . $imgname;
    $cid = trim($_POST['cid']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];
    $rate = $_POST['rate'];
    $dur = $_POST['dur'];
    $coldate = $_POST['coldate'];
    $paydate = $_POST['paydate'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];
    $loc1 = $_POST['loc1'];
    $mail = $_POST['mail'];
    $mail2 = $_POST['mail2'];

    $phone2 = $_POST['phone2'];
    $paym = $_POST['paym'];
    $cdt2 = $_POST['cdt2'];

    $cdt = $_POST['cdt'];
    $ctm = $_POST['ctm'];

    $amt = $_POST['amt'];

    $dupStmt = $conn->prepare("SELECT id FROM userlog WHERE cid = ?");
    $dupStmt->bind_param('s', $cid);
    $dupStmt->execute();
    $dupStmt->store_result();
    $cidTaken = $dupStmt->num_rows > 0;
    $dupStmt->close();

    $uploadOk = 1;
    $errorText = '';
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if (file_exists($target_file)) {
        $errorText = "Sorry, file already exists.";
        $uploadOk = 0;
    }
    if ($_FILES["image"]["size"] > 2000000) {
        $errorText = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" &&
        $imageFileType != "pdf"
        && $imageFileType != "gif" && $imageFileType != "bmp"
    ) {
        $errorText = "Sorry, only PDF, JPG, JPEG, PNG, GIF & BMP files are allowed.";
        $uploadOk = 0;
    }
    if ($cidTaken) {
        $errorText = "Vault number already taken!";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $_SESSION['error'] = $errorText ?: 'Upload failed.';
        header('Location: create_user.php');
        exit();
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $path = $imgname;
        $rank2 = '';
        $insertStmt = $conn->prepare("INSERT INTO userlog (image, cid, name, rank, phone, type, rate, dur, coldate,
                paydate, status, remark, loc1, rank2, mail2, mail, phone2, paym, cdt, ctm, cdt2, password,
                amt, username) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $insertStmt->bind_param(
            str_repeat('s', 24),
            $path, $cid, $name, $rank, $phone, $type, $rate, $dur, $coldate,
            $paydate, $status, $remark, $loc1, $rank2, $mail2, $mail, $phone2, $paym, $cdt, $ctm, $cdt2,
            $password, $amt, $username
        );
        $insertStmt->execute();
        $insertStmt->close();
        $_SESSION['Success'] = 'Vault User successfully created!';
        header('Location: users.php');
        exit();
    }

    $_SESSION['error'] = 'Failed to upload the attached file. Check directory permissions.';
    header('Location: create_user.php');
    exit();
}

$pageTitle = 'Create Vault User';
$activeNav = 'vault';
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Create New Vault User</h1>
                    <div class="text-muted small">Add a customer account that can log in to check their vault.</div>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form class="admin-card" method="post" action="create_user.php" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="admin-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vault Serial Number</label>
                                <input type="text" name="cid" placeholder="Create Vault Serial Number"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PDF attachment (if any)</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Vault Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="remark" placeholder="Enter Name of Sender"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vault Content</label>
                                <input type="text" name="name" placeholder="Enter Content of vault"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="text" name="username" placeholder="Enter Email"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" placeholder="Enter Password"
                                    class="form-control" autocomplete="new-password" required>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Receipt Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Import Tax Charges</label>
                                <input type="text" name="rank" placeholder="Enter IMPORT TAX Charges"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Import Tax Remark</label>
                                <select name="phone" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cleared">Cleared</option>
                                    <option value="Not Cleared">Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">VAT Charges</label>
                                <input type="text" name="mail" placeholder="Enter VAT Charges"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">VAT Remark</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cleared">Cleared</option>
                                    <option value="Not Cleared">Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Inspection Fee Charges</label>
                                <input type="text" name="dur" placeholder="Inspection Fee Charges"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Inspection Fee Remarks</label>
                                <select name="paydate" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cleared">Cleared</option>
                                    <option value="Not Cleared">Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Handling Charges</label>
                                <input type="text" name="loc1" placeholder="Handling Charges"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Handling Remarks</label>
                                <select name="cdt" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cleared">Cleared</option>
                                    <option value="Not Cleared">Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Storage Fee Charges</label>
                                <input type="text" name="status" placeholder="Enter Storage Fee Charges"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Storage Fee Remarks</label>
                                <select name="mail2" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cleared">Cleared</option>
                                    <option value="Not Cleared">Not Cleared</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Insurance Fee Charges</label>
                                <input type="text" name="phone2" placeholder="Enter Insurance Fee Charges"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Insurance Fee Remarks</label>
                                <select name="paym" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cleared">Cleared</option>
                                    <option value="Not Cleared">Not Cleared</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="amt" value="user">
                        <input type="hidden" name="ctm" value="">
                        <input type="hidden" name="cdt2" value="">
                        <input type="hidden" name="rate" value="">
                        <input type="hidden" name="coldate" value="">
                    </div>
                    <div class="admin-card-header border-top border-bottom-0">
                        <button name="save" class="btn btn-primary" type="submit">
                            <i class="bi bi-check2-circle me-1"></i>Create Vault User
                        </button>
                    </div>
                </form>
<?php include 'partials/admin_end.php'; ?>
