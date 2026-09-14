<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */
include_once 'config.php';
require_once 'security.php';

error_reporting(E_ALL);
ini_set('display_errors', 1); // Set to 0 in production after testing

// Fetch site settings (id = 20)
$siteStmt = $conn->prepare("SELECT * FROM site WHERE id = 20 LIMIT 1");
$siteStmt->execute();
$siteResult = $siteStmt->get_result();
$siteData = $siteResult->fetch_assoc();

$siteName   = $siteData['name'] ?? 'Tracking Portal';
$siteEmail  = $siteData['email'] ?? SMTP_USER;
$siteUrl    = $siteData['url'] ?? '';

// Access control (if user is 'user', redirect to vault)
if (isset($row['amt']) && $row['amt'] === 'user') {
    header('Location: vault.php');
    exit();
}

$message = '';

// Handle form submission
if (isset($_POST['save'])) {
    verify_csrf();
    // Collect all POST fields (same as before)
    $cid       = trim($_POST['cid'] ?? '');
    $name      = trim($_POST['name'] ?? '');
    $rank      = trim($_POST['rank'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $type      = trim($_POST['type'] ?? '');
    $rate      = trim($_POST['rate'] ?? '');
    $dur       = trim($_POST['dur'] ?? '');
    $coldate   = trim($_POST['coldate'] ?? '');
    $paydate   = trim($_POST['paydate'] ?? '');
    $status    = trim($_POST['status'] ?? '');
    $remark    = trim($_POST['remark'] ?? '');
    $loc1      = trim($_POST['loc1'] ?? '');
    $rank2     = trim($_POST['rank2'] ?? '');
    $mail2     = trim($_POST['mail2'] ?? '');
    $mail      = trim($_POST['mail'] ?? '');
    $phone2    = trim($_POST['phone2'] ?? '');
    $paym      = trim($_POST['paym'] ?? '');
    $shipm     = trim($_POST['shipm'] ?? '');
    $comment   = trim($_POST['comment'] ?? '');
    $cdt       = trim($_POST['cdt'] ?? '');
    $ctm       = trim($_POST['ctm'] ?? '');
    $car       = trim($_POST['car'] ?? '');
    $carref    = trim($_POST['carref'] ?? '');
    $prod      = trim($_POST['prod'] ?? '');
    $qty       = trim($_POST['qty'] ?? '');
    $frt       = trim($_POST['frt'] ?? '');
    $deptim    = trim($_POST['deptim'] ?? '');
    $pudate    = trim($_POST['pudate'] ?? '');
    $putm      = trim($_POST['putm'] ?? '');
    $pudes     = trim($_POST['pudes'] ?? '');
    $rmk       = trim($_POST['rmk'] ?? '');

    // File upload handling
    $uploadOk = 1;
    $imgname = '';
    $target_dir = "img/";

    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            $uploadOk = 0;
            $message = '<div class="alert alert-danger">Failed to create upload directory. Please check permissions.</div>';
        }
    } elseif (!is_writable($target_dir)) {
        $uploadOk = 0;
        $message = '<div class="alert alert-danger">Upload directory is not writable. Please set permissions to 755 or 777.</div>';
    }

    // Process uploaded file if directory is ok
    if ($uploadOk && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp  = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];

        // Get real MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $image_tmp);
        finfo_close($finfo);
        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
        if (!in_array($mime_type, $allowed_mimes)) {
            $uploadOk = 0;
            $message = '<div class="alert alert-danger">Only JPG, PNG, GIF, BMP images are allowed. Detected type: ' . htmlspecialchars($mime_type) . '</div>';
        } elseif ($image_size > 2000000) {
            $uploadOk = 0;
            $message = '<div class="alert alert-danger">File too large. Max 2MB.</div>';
        } else {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $imgname = time() . '.' . $ext;
            $target_file = $target_dir . $imgname;
            if (!move_uploaded_file($image_tmp, $target_file)) {
                $uploadOk = 0;
                $message = '<div class="alert alert-danger">Failed to move uploaded file. Check directory permissions.</div>';
            }
        }
    } else {
        $uploadOk = 0;
        $message = '<div class="alert alert-danger">No file uploaded or upload error. Please select an image.</div>';
    }

    // Check if tracking number already exists (only if upload succeeded)
    if ($uploadOk) {
        $checkStmt = $conn->prepare("SELECT id FROM user WHERE cid = ?");
        $checkStmt->bind_param("s", $cid);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            $uploadOk = 0;
            $message = '<div class="alert alert-danger">Tracking number already taken!</div>';
            // Delete uploaded file if exists
            if (!empty($imgname) && file_exists($target_dir . $imgname)) {
                unlink($target_dir . $imgname);
            }
        }
        $checkStmt->close();
    }

    // If all checks pass, insert record
    if ($uploadOk) {
        $insertSql = "INSERT INTO user (
            image, cid, name, rank, phone, type, rate, dur, coldate, paydate, 
            status, remark, loc1, rank2, mail2, mail, phone2, paym, shipm, comment, 
            cdt, ctm, car, carref, prod, qty, frt, deptim, pudate, putm, pudes, rmk
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insertSql);
        if (!$stmt) {
            $message = '<div class="alert alert-danger">Database prepare failed: ' . htmlspecialchars($conn->error) . '</div>';
            if (!empty($imgname) && file_exists($target_dir . $imgname)) {
                unlink($target_dir . $imgname);
            }
        } else {
            $stmt->bind_param(
                'ssssssssssssssssssssssssssssssss',
                $imgname,
                $cid,
                $name,
                $rank,
                $phone,
                $type,
                $rate,
                $dur,
                $coldate,
                $paydate,
                $status,
                $remark,
                $loc1,
                $rank2,
                $mail2,
                $mail,
                $phone2,
                $paym,
                $shipm,
                $comment,
                $cdt,
                $ctm,
                $car,
                $carref,
                $prod,
                $qty,
                $frt,
                $deptim,
                $pudate,
                $putm,
                $pudes,
                $rmk
            );

            if ($stmt->execute()) {
                // Build the email from the "New Parcel Created" template
                // (editable under Email Templates in the dashboard).
                $templateData = [
                    'receiver_name' => $name,
                    'site_name' => $siteName,
                    'parcel_type' => $type,
                    'tracking_number' => $cid,
                    'sender_name' => $remark,
                    'status' => $status,
                    'tracking_url' => $siteUrl,
                    'site_logo_url' => siteBaseUrl() . '/img/' . ($siteData['image'] ?? ''),
                    'site_address' => $siteData['addr'] ?? '',
                    'site_phone' => $siteData['phone'] ?? '',
                    'current_year' => date('Y'),
                ];
                $templateHtmlData = array_map('htmlspecialchars', $templateData);

                $template = getEmailTemplate('parcel_created');
                $rendered = $template
                    ? renderEmailTemplate($template, $templateData, $templateHtmlData)
                    : null;

                // Send email using sendMailSMTP function from config.php,
                // unless the admin has turned this notification off.
                $mailSettings = getMailSettings();
                if (empty($mailSettings['notify_on_create'])) {
                    $message = '<div class="alert alert-success">Tracking number successfully created! (Email notifications for new parcels are turned off in Email / SMTP Settings.)</div>';
                } elseif (!$rendered) {
                    $message = '<div class="alert alert-warning">Record created, but the "New Parcel Created" email template is missing.</div>';
                } elseif (!empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $mailResult = sendMailSMTP(
                        $mail,
                        $name,
                        $rendered['subject'],
                        $rendered['html'],
                        $rendered['text'],
                        $mailSettings['smtp_from_email'],
                        $mailSettings['smtp_from_name'] ?: $siteName
                    );

                    logEmailSend(
                        'parcel_created',
                        $mail,
                        $name,
                        $rendered['subject'],
                        $rendered['html'],
                        $rendered['text'],
                        $mailResult['success'],
                        $mailResult['success'] ? '' : $mailResult['message'],
                        $cid
                    );

                    if ($mailResult['success']) {
                        $message = '<div class="alert alert-success">Tracking number successfully created! Email sent to ' . htmlspecialchars($mail) . '</div>';
                    } else {
                        $message = '<div class="alert alert-warning">Record created, but email failed: ' . htmlspecialchars($mailResult['message']) . '</div>';
                    }
                } else {
                    $message = '<div class="alert alert-warning">Record created, but receiver email is invalid or empty.</div>';
                }
                $stmt->close();
                // Optionally redirect to clear form
                // header("Location: identity.php?success=1");
                // exit();
            } else {
                $message = '<div class="alert alert-danger">Database insert failed: ' . htmlspecialchars($stmt->error) . '</div>';
                // Delete uploaded file if insert fails
                if (!empty($imgname) && file_exists($target_dir . $imgname)) {
                    unlink($target_dir . $imgname);
                }
                $stmt->close();
            }
        }
    }
}
$pageTitle = 'Create New Tracking';
$activeNav = 'tracking';
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Create New Tracking</h1>
                    <div class="text-muted small">Add a new parcel and notify the receiver by email.</div>
                </div>

                <?php if (!empty($message)) echo $message; ?>

                <form class="admin-card" method="post" action="" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="admin-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tracking Number</label>
                                <input type="text" name="cid" placeholder="Create Tracking Number"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Parcel Image or Passport Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Sender Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Sender Name</label>
                                <input type="text" name="remark" placeholder="Enter Name of Sender"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sender Country</label>
                                <input type="text" name="rank2" placeholder="Enter Country of Sender"
                                    class="form-control" required>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Receiver Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Receiver Name</label>
                                <input type="text" name="name" placeholder="Enter Name of Receiver"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receiver Address</label>
                                <input type="text" name="rank" placeholder="Enter Address of Receiver"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receiver Phone</label>
                                <input type="text" name="phone" placeholder="Enter Phone Number"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receiver Email</label>
                                <input type="email" name="mail" placeholder="Enter Receiver Email"
                                    class="form-control" required>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Parcel Information</h2>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Parcel Content</label>
                                <input type="text" name="type"
                                    placeholder="Enter the parcel content to be shipped" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Weight (KG)</label>
                                <input type="text" name="dur" placeholder="Weight of Parcel"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duty Fees</label>
                                <input type="text" name="paydate" placeholder="Enter Duty Fees"
                                    class="form-control" required>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Current Information</h2>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Current Location</label>
                                <input type="text" name="loc1"
                                    placeholder="Place where the parcel currently is..." class="form-control"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Current Date</label>
                                <input type="date" name="cdt" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Current Location Remark</label>
                                <input type="text" name="status" placeholder="Enter Location Remark"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="rmk" class="form-select">
                                    <option value="Order Confirmed">Order Confirmed</option>
                                    <option value="Picked by Courier">Picked by Courier</option>
                                    <option value="On The Way">On The Way</option>
                                    <option value="Ready for Pickup">Ready for Pickup</option>
                                    <option value="Custom Hold">Custom Hold</option>
                                    <?php if (!empty($siteData['custom1'])): ?>
                                        <option value="<?= htmlspecialchars($siteData['custom1']) ?>">
                                            <?= htmlspecialchars($siteData['custom1']) ?></option>
                                    <?php endif; ?>
                                    <?php if (!empty($siteData['custom2'])): ?>
                                        <option value="<?= htmlspecialchars($siteData['custom2']) ?>">
                                            <?= htmlspecialchars($siteData['custom2']) ?></option>
                                    <?php endif; ?>
                                    <?php if (!empty($siteData['custom3'])): ?>
                                        <option value="<?= htmlspecialchars($siteData['custom3']) ?>">
                                            <?= htmlspecialchars($siteData['custom3']) ?></option>
                                    <?php endif; ?>
                                    <?php if (!empty($siteData['custom4'])): ?>
                                        <option value="<?= htmlspecialchars($siteData['custom4']) ?>">
                                            <?= htmlspecialchars($siteData['custom4']) ?></option>
                                    <?php endif; ?>
                                    <?php if (!empty($siteData['custom5'])): ?>
                                        <option value="<?= htmlspecialchars($siteData['custom5']) ?>">
                                            <?= htmlspecialchars($siteData['custom5']) ?></option>
                                    <?php endif; ?>
                                    <option value="Arrived">Arrived</option>
                                    <option value="Delivered">Delivered</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden fields to match the table structure -->
                        <input type="hidden" name="rate" value="">
                        <input type="hidden" name="coldate" value="">
                        <input type="hidden" name="mail2" value="">
                        <input type="hidden" name="phone2" value="">
                        <input type="hidden" name="paym" value="">
                        <input type="hidden" name="shipm" value="">
                        <input type="hidden" name="comment" value="">
                        <input type="hidden" name="ctm" value="">
                        <input type="hidden" name="car" value="">
                        <input type="hidden" name="carref" value="">
                        <input type="hidden" name="prod" value="">
                        <input type="hidden" name="qty" value="">
                        <input type="hidden" name="frt" value="">
                        <input type="hidden" name="deptim" value="">
                        <input type="hidden" name="pudate" value="">
                        <input type="hidden" name="putm" value="">
                        <input type="hidden" name="pudes" value="">
                    </div>
                    <div class="admin-card-header border-top border-bottom-0">
                        <button name="save" class="btn btn-primary" type="submit">
                            <i class="bi bi-check2-circle me-1"></i>Create Tracking
                        </button>
                    </div>
                </form>
<?php
$extraScripts = '<script>if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); }</script>';
include 'partials/admin_end.php';
?>