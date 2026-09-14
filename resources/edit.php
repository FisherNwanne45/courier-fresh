<?php
include('session.php');
/** @var string $login_session Logged-in username, set in session.php */
include_once 'config.php';
require_once 'security.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = '';

// -----------------------------
// Fetch site settings
// -----------------------------
$siteStmt = $conn->prepare("SELECT * FROM site WHERE id = 20 LIMIT 1");
$siteStmt->execute();
$siteResult = $siteStmt->get_result();
$siteData = $siteResult->fetch_assoc();

$site = $siteData['name'] ?? 'Tracking Portal';
$siteEmail = $siteData['email'] ?? SMTP_USER;
$url = $siteData['url'] ?? '';

// -----------------------------
// Access control (safe)
// -----------------------------
if (isset($row['amt']) && $row['amt'] === 'user') {
    header('Location: vault.php');
    exit();
}

// -----------------------------
// Handle form submission
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    verify_csrf();

    // Basic fields
    $id = (int)($_POST['id'] ?? 0);
    $cid = trim($_POST['cid'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $rank = trim($_POST['rank'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $recipientEmail = trim($_POST['mail'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $dur = trim($_POST['dur'] ?? '');
    $paydate = trim($_POST['paydate'] ?? '');
    $remark = trim($_POST['remark'] ?? '');
    $rank2 = trim($_POST['rank2'] ?? '');
    $rmk = trim($_POST['rmk'] ?? '');
    $rrr = trim($_POST['rrr'] ?? '');

    // History / status fields
    $loc1 = trim($_POST['loc1'] ?? '');
    $cdt = trim($_POST['cdt'] ?? '');
    $status = trim($_POST['status'] ?? '');

    $loc2 = trim($_POST['loc2'] ?? '');
    $cdt2 = trim($_POST['cdt2'] ?? '');
    $status2 = trim($_POST['status2'] ?? '');

    $loc3 = trim($_POST['loc3'] ?? '');
    $cdt3 = trim($_POST['cdt3'] ?? '');
    $status3 = trim($_POST['status3'] ?? '');

    $loc4 = trim($_POST['loc4'] ?? '');
    $cdt4 = trim($_POST['cdt4'] ?? '');
    $status4 = trim($_POST['status4'] ?? '');

    $loc5 = trim($_POST['loc5'] ?? '');
    $cdt5 = trim($_POST['cdt5'] ?? '');
    $status5 = trim($_POST['status5'] ?? '');

    $loc6 = trim($_POST['loc6'] ?? '');
    $cdt6 = trim($_POST['cdt6'] ?? '');
    $status6 = trim($_POST['status6'] ?? '');

    $loc7 = trim($_POST['loc7'] ?? '');
    $cdt7 = trim($_POST['cdt7'] ?? '');
    $status7 = trim($_POST['status7'] ?? '');

    // Extra fields preserved from your old script
    $car = trim($_POST['car'] ?? '');
    $carref = trim($_POST['carref'] ?? '');
    $prod = trim($_POST['prod'] ?? '');
    $qty = trim($_POST['qty'] ?? '');
    $frt = trim($_POST['frt'] ?? '');
    $deptim = trim($_POST['deptim'] ?? '');
    $pudate = trim($_POST['pudate'] ?? '');
    $putm = trim($_POST['putm'] ?? '');
    $pudes = trim($_POST['pudes'] ?? '');
    $rmk2 = trim($_POST['rmk2'] ?? '');
    $rmk3 = trim($_POST['rmk3'] ?? '');
    $rmk4 = trim($_POST['rmk4'] ?? '');
    $rmk5 = trim($_POST['rmk5'] ?? '');
    $rmk6 = trim($_POST['rmk6'] ?? '');
    $rmk7 = trim($_POST['rmk7'] ?? '');
    $ctm = trim($_POST['ctm'] ?? '');
    $ctm2 = trim($_POST['ctm2'] ?? '');
    $ctm3 = trim($_POST['ctm3'] ?? '');
    $ctm4 = trim($_POST['ctm4'] ?? '');
    $ctm5 = trim($_POST['ctm5'] ?? '');
    $ctm6 = trim($_POST['ctm6'] ?? '');
    $ctm7 = trim($_POST['ctm7'] ?? '');
    $mail2 = trim($_POST['mail2'] ?? '');
    $phone2 = trim($_POST['phone2'] ?? '');
    $paym = trim($_POST['paym'] ?? '');
    $shipm = trim($_POST['shipm'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $coldate = trim($_POST['coldate'] ?? '');
    $amt = trim($_POST['amt'] ?? '');
    $rate = trim($_POST['rate'] ?? '');

    // -----------------------------
    // Update database safely
    // -----------------------------
    $sql = "UPDATE user SET
        car=?, carref=?, prod=?, qty=?, frt=?, deptim=?, pudate=?, putm=?, pudes=?,
        rmk=?, rmk2=?, rmk3=?, rmk4=?, rmk5=?, rmk6=?, rmk7=?,
        cdt3=?, cdt4=?, cdt5=?, cdt6=?, cdt7=?,
        ctm3=?, ctm4=?, ctm5=?, ctm6=?, ctm7=?,
        loc3=?, loc4=?, loc5=?, loc6=?, loc7=?,
        status3=?, status4=?, status5=?, status6=?, status7=?,
        rank2=?, mail2=?, mail=?, phone2=?, paym=?, shipm=?, comment=?,
        status2=?, cdt=?, ctm=?, cdt2=?, ctm2=?, coldate=?,
        loc1=?, loc2=?, amt=?, type=?, dur=?, rate=?, phone=?, name=?, rank=?, cid=?,
        status=?, rrr=?, remark=?, paydate=?
        WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        str_repeat('s', 63) . 'i',
        $car,
        $carref,
        $prod,
        $qty,
        $frt,
        $deptim,
        $pudate,
        $putm,
        $pudes,
        $rmk,
        $rmk2,
        $rmk3,
        $rmk4,
        $rmk5,
        $rmk6,
        $rmk7,
        $cdt3,
        $cdt4,
        $cdt5,
        $cdt6,
        $cdt7,
        $ctm3,
        $ctm4,
        $ctm5,
        $ctm6,
        $ctm7,
        $loc3,
        $loc4,
        $loc5,
        $loc6,
        $loc7,
        $status3,
        $status4,
        $status5,
        $status6,
        $status7,
        $rank2,
        $mail2,
        $recipientEmail,
        $phone2,
        $paym,
        $shipm,
        $comment,
        $status2,
        $cdt,
        $ctm,
        $cdt2,
        $ctm2,
        $coldate,
        $loc1,
        $loc2,
        $amt,
        $type,
        $dur,
        $rate,
        $phone,
        $name,
        $rank,
        $cid,
        $status,
        $rrr,
        $remark,
        $paydate,
        $id
    );

    if ($stmt->execute()) {

        // -----------------------------
        // Build shipment history rows
        // -----------------------------
        function buildHistoryRow($loc, $date, $statusText)
        {
            if (trim($loc) === '' && trim($date) === '' && trim($statusText) === '') {
                return '';
            }

            return "
            <tr>
                <td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3;'>" . htmlspecialchars($loc) . "</td>
                <td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3;'>" . htmlspecialchars($date) . "</td>
                <td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3; font-weight:600;'>" . htmlspecialchars($statusText) . "</td>
            </tr>";
        }

        $historyRows =
            buildHistoryRow($loc1, $cdt, $status) .
            buildHistoryRow($loc2, $cdt2, $status2) .
            buildHistoryRow($loc3, $cdt3, $status3) .
            buildHistoryRow($loc4, $cdt4, $status4) .
            buildHistoryRow($loc5, $cdt5, $status5) .
            buildHistoryRow($loc6, $cdt6, $status6) .
            buildHistoryRow($loc7, $cdt7, $status7);

        // -----------------------------
        // Build email content from the "Shipment Status Updated" template
        // (editable under Email Templates in the dashboard).
        // -----------------------------
        $templateData = [
            'receiver_name' => $name,
            'site_name' => $site,
            'status' => $rmk,
            'tracking_number' => $cid,
            'parcel_type' => $type,
            'remarks' => $rrr,
            'tracking_url' => $url,
            'site_logo_url' => siteBaseUrl() . '/img/' . ($siteData['image'] ?? ''),
            'site_address' => $siteData['addr'] ?? '',
            'site_phone' => $siteData['phone'] ?? '',
            'current_year' => date('Y'),
        ];
        $templateHtmlData = array_merge(
            array_map('htmlspecialchars', $templateData),
            [
                'remarks' => nl2br(htmlspecialchars($rrr)),
                'shipment_history' => $historyRows, // already-escaped HTML fragment
            ]
        );

        $template = getEmailTemplate('status_updated');
        $rendered = $template ? renderEmailTemplate($template, $templateData, $templateHtmlData) : null;

        // -----------------------------
        // Send email via mailer.php, unless the admin has turned this
        // notification off in Email / SMTP Settings.
        // -----------------------------
        $mailSettings = getMailSettings();
        if (empty($mailSettings['notify_on_status_update'])) {
            $message = '<div class="alert alert-success alert-dismissible fade show">
                <strong>Well done!</strong> Record modified successfully. (Status-update emails are turned off in Email / SMTP Settings.)
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        } elseif (!$rendered) {
            $message = '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Record updated, but the "Shipment Status Updated" email template is missing.</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        } elseif (!empty($recipientEmail) && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            $mailResult = sendMailSMTP(
                $recipientEmail,
                $name,
                $rendered['subject'],
                $rendered['html'],
                $rendered['text'],
                $mailSettings['smtp_from_email'],
                $mailSettings['smtp_from_name'] ?: $site
            );

            logEmailSend(
                'status_updated',
                $recipientEmail,
                $name,
                $rendered['subject'],
                $rendered['html'],
                $rendered['text'],
                $mailResult['success'],
                $mailResult['success'] ? '' : $mailResult['message'],
                $cid
            );

            if ($mailResult['success']) {
                $message = '<div class="alert alert-success alert-dismissible fade show">
                    <strong>Well done!</strong> Record modified successfully and email sent!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
            } else {
                $message = '<div class="alert alert-warning alert-dismissible fade show">
                    <strong>Record updated, but email failed:</strong> ' . htmlspecialchars($mailResult['message']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
            }
        } else {
            $message = '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Record updated, but recipient email is invalid or empty.</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        }

        // Prevent form resubmission
        $_SESSION['edit_message'] = $message;
        header("Location: edit.php?id=" . $id);
        exit();
    } else {
        $message = '<div class="alert alert-danger alert-dismissible fade show">
            <strong>Database update failed:</strong> ' . htmlspecialchars($stmt->error) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    }
}

// -----------------------------
// Show flash message after redirect
// -----------------------------
if (isset($_SESSION['edit_message'])) {
    $message = $_SESSION['edit_message'];
    unset($_SESSION['edit_message']);
}

// -----------------------------
// Fetch tracking record
// -----------------------------
$trackingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$userStmt = $conn->prepare("SELECT * FROM user WHERE id = ? LIMIT 1");
$userStmt->bind_param("i", $trackingId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$row = $userResult->fetch_assoc();

if (!$row) {
    die("Tracking record not found.");
}

$pageTitle = 'Edit Tracking';
$activeNav = 'dashboard';
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Edit Tracking &mdash; <?php echo htmlspecialchars($row['name']); ?></h1>
                    <div class="text-muted small">Tracking Number: <strong><?php echo htmlspecialchars($row['cid']); ?></strong></div>
                </div>

                <?php if (!empty($message)) echo $message; ?>

                <form class="admin-card" method="post" action="">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">

                    <div class="admin-card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tracking Number</label>
                                <input type="text" name="cid"
                                    value="<?php echo htmlspecialchars($row['cid']); ?>" class="form-control">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Sender Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Sender Name</label>
                                <input type="text" name="remark"
                                    value="<?php echo htmlspecialchars($row['remark']); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sender Address</label>
                                <input type="text" name="rank2"
                                    value="<?php echo htmlspecialchars($row['rank2']); ?>" class="form-control">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Receiver Information</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Receiver Name</label>
                                <input type="text" name="name"
                                    value="<?php echo htmlspecialchars($row['name']); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receiver Address</label>
                                <input type="text" name="rank"
                                    value="<?php echo htmlspecialchars($row['rank']); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receiver Phone</label>
                                <input type="text" name="phone"
                                    value="<?php echo htmlspecialchars($row['phone']); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receiver Email</label>
                                <input type="text" name="mail"
                                    value="<?php echo htmlspecialchars($row['mail']); ?>" class="form-control">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Parcel Information</h2>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Parcel Content</label>
                                <input type="text" name="type"
                                    value="<?php echo htmlspecialchars($row['type']); ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Weight (KG)</label>
                                <input type="text" name="dur"
                                    value="<?php echo htmlspecialchars($row['dur']); ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duty Fees</label>
                                <input type="text" name="paydate"
                                    value="<?php echo htmlspecialchars($row['paydate']); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="rmk" class="form-select">
                                    <?php
                                    $statusOptions = [
                                        'Order Confirmed',
                                        'Picked by Courier',
                                        'On The Way',
                                        'Ready for Pickup',
                                        'Custom Hold',
                                        $siteData['custom1'] ?? '',
                                        $siteData['custom2'] ?? '',
                                        $siteData['custom3'] ?? '',
                                        $siteData['custom4'] ?? '',
                                        $siteData['custom5'] ?? '',
                                        'Arrived',
                                        'Delivered'
                                    ];

                                    foreach ($statusOptions as $option) {
                                        if (trim($option) === '') continue;
                                        $selected = ($row['rmk'] === $option) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Shipping History</h2>

                        <?php
                        $historyFields = [
                            ['loc1', 'cdt', 'status', 'Current', 'danger'],
                            ['loc2', 'cdt2', 'status2', 'Update 1', 'primary'],
                            ['loc3', 'cdt3', 'status3', 'Update 2', 'success'],
                            ['loc4', 'cdt4', 'status4', 'Update 3', 'warning'],
                            ['loc5', 'cdt5', 'status5', 'Update 4', 'primary'],
                            ['loc6', 'cdt6', 'status6', 'Update 5', 'success'],
                            ['loc7', 'cdt7', 'status7', 'Update 6', 'danger'],
                        ];

                        foreach ($historyFields as $fields):
                            [$locField, $dateField, $statusField, $label, $color] = $fields;
                        ?>
                            <div class="row g-3 align-items-end mb-2 pb-2 border-bottom border-<?php echo $color; ?> border-opacity-25">
                                <div class="col-md-1 pt-2">
                                    <span class="badge bg-<?php echo $color; ?>"><?php echo htmlspecialchars($label); ?></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small mb-1">Location</label>
                                    <input type="text" name="<?php echo $locField; ?>"
                                        value="<?php echo htmlspecialchars($row[$locField] ?? ''); ?>"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Date</label>
                                    <input type="text" name="<?php echo $dateField; ?>"
                                        value="<?php echo htmlspecialchars($row[$dateField] ?? ''); ?>"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small mb-1">Status</label>
                                    <input type="text" name="<?php echo $statusField; ?>"
                                        value="<?php echo htmlspecialchars($row[$statusField] ?? ''); ?>"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="row g-3 mt-1">
                            <div class="col-12">
                                <label class="form-label">Remarks / Comment</label>
                                <textarea name="rrr" class="form-control" rows="3"
                                    placeholder="Enter Remarks"><?php echo htmlspecialchars($row['rrr']); ?></textarea>
                            </div>
                        </div>

                        <!-- Hidden legacy fields to preserve old DB structure -->
                        <?php
                        $legacyFields = [
                            'car', 'carref', 'prod', 'qty', 'frt', 'deptim', 'pudate', 'putm', 'pudes',
                            'rmk2', 'rmk3', 'rmk4', 'rmk5', 'rmk6', 'rmk7',
                            'ctm', 'ctm2', 'ctm3', 'ctm4', 'ctm5', 'ctm6', 'ctm7',
                            'mail2', 'phone2', 'paym', 'shipm', 'comment', 'coldate', 'amt', 'rate',
                        ];

                        foreach ($legacyFields as $field) {
                            echo '<input type="hidden" name="' . htmlspecialchars($field) . '" value="' . htmlspecialchars($row[$field] ?? '') . '">';
                        }
                        ?>
                    </div>
                    <div class="admin-card-header border-top border-bottom-0">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Save Changes</button>
                    </div>
                </form>
<?php
$extraScripts = '<script>if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); }</script>';
include 'partials/admin_end.php';
?>
