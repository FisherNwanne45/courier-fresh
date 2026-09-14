<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php (reassigned below to the site settings row) */
/** @var string $login_session Logged-in username, set in session.php */

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}
include_once 'config.php';
require_once 'security.php';

// Fetch the row to edit
$sql = "SELECT * FROM site WHERE id = 20";  // Fetch the specific row with id = 20
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    // Get the form data
    $name = $_POST['name'];
    $addr = $_POST['addr'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $addr2 = $_POST['addr2'];
    $phone2 = $_POST['phone2'];
    $email2 = $_POST['email2'];
    $branch2_name = $_POST['branch2_name'];
    $addr3 = $_POST['addr3'];
    $phone3 = $_POST['phone3'];
    $email3 = $_POST['email3'];
    $branch3_name = $_POST['branch3_name'];
    $addr4 = $_POST['addr4'];
    $phone4 = $_POST['phone4'];
    $email4 = $_POST['email4'];
    $branch4_name = $_POST['branch4_name'];
    $tawk = $_POST['tawk'];
    $year = $_POST['year'];
    $custom1 = $_POST['custom1'];
    $custom2 = $_POST['custom2'];
    $custom3 = $_POST['custom3'];
    $custom4 = $_POST['custom4'];
    $custom5 = $_POST['custom5'];
    $url = $_POST['url'];

    // Handle file upload (image)
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target_dir = "img/"; // Directory to store uploaded files
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $row['image']; // If no new image is uploaded, keep the old one
    }


    // Handle file upload (image)
    if ($_FILES['image2']['name']) {
        $image2 = $_FILES['image2']['name'];
        $target_dir = "img/"; // Directory to store uploaded files
        $target_file = $target_dir . basename($image2);
        move_uploaded_file($_FILES["image2"]["tmp_name"], $target_file);
    } else {
        $image2 = $row['image2']; // If no new image is uploaded, keep the old one
    }

    // Handle file upload (favicon)
    if ($_FILES['favicon']['name']) {
        $favicon = $_FILES['favicon']['name'];
        $target_dir = "img/"; // Directory to store uploaded files
        $target_file = $target_dir . basename($favicon);
        move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file);
    } else {
        $favicon = $row['favicon']; // If no new favicon is uploaded, keep the old one
    }

    // Prepare the update query using a prepared statement
    $stmt = $conn->prepare("UPDATE site SET
            name = ?,
            addr = ?,
            phone = ?,
            email = ?,
            addr2 = ?,
            phone2 = ?,
            email2 = ?,
            branch2_name = ?,
            addr3 = ?,
            phone3 = ?,
            email3 = ?,
            branch3_name = ?,
            addr4 = ?,
            phone4 = ?,
            email4 = ?,
            branch4_name = ?,
            tawk = ?,
            year = ?,
            url = ?,
            image = ?,
            image2 = ?,
            favicon = ?,
            custom1 = ?,
            custom2 = ?,
            custom3 = ?,
            custom4 = ?,
            custom5 = ?
            WHERE id = ?");

    // Bind parameters to the statement
    $stmt->bind_param("sssssssssssssssssssssssssssi", $name, $addr, $phone, $email, $addr2, $phone2, $email2, $branch2_name, $addr3, $phone3, $email3, $branch3_name, $addr4, $phone4, $email4, $branch4_name, $tawk, $year, $url, $image, $image2, $favicon, $custom1, $custom2, $custom3, $custom4, $custom5, $row['id']);  // Use $row['id'] from the selected record

    // Execute the query
    if ($stmt->execute()) {
        $message = '<div class="alert alert-success">Record updated successfully!</div>';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $message = '<div class="alert alert-danger">Error updating record: ' . htmlspecialchars($stmt->error) . '</div>';
    }

    $stmt->close();  // Close the statement
}

$pageTitle = 'Site Settings';
$activeNav = 'settings';
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Site Settings</h1>
                    <div class="text-muted small">Company info, branding, and status options shown across the app.</div>
                </div>

                <?= $message ?>

                <form class="admin-card" action="" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="admin-card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Header Logo</label>
                                <input type="file" name="image" id="image" class="form-control"
                                    onchange="previewImage(event)">
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <img src="img/<?= htmlspecialchars($row['image']) ?>" alt="Current header logo" width="70" class="rounded border p-1">
                                    <img id="imagePreview" width="70" class="rounded border p-1" style="display:none;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Footer Logo</label>
                                <input type="file" name="image2" id="image2" class="form-control"
                                    onchange="previewImage2(event)">
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <img src="img/<?= htmlspecialchars($row['image2']) ?>" alt="Current footer logo" width="70" class="rounded border p-1">
                                    <img id="imagePreview2" width="70" class="rounded border p-1" style="display:none;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Favicon</label>
                                <input type="file" name="favicon" id="favicon" class="form-control"
                                    onchange="previewFavicon(event)" accept="image/*">
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <?php if (!empty($row['favicon'])): ?>
                                        <img src="img/<?= htmlspecialchars($row['favicon']) ?>" alt="Current favicon" width="32" class="rounded border p-1">
                                    <?php else: ?>
                                        <span class="text-muted small">No favicon set</span>
                                    <?php endif; ?>
                                    <img id="faviconPreview" width="32" class="rounded border p-1" style="display:none;">
                                </div>
                                <div class="form-text">Shown in the browser tab across the admin, the public site, and every theme.</div>
                            </div>
                        </div>
                        <script>
                        function previewImage(event) {
                            const imagePreview = document.getElementById('imagePreview');
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    imagePreview.src = e.target.result;
                                    imagePreview.style.display = 'inline-block';
                                }
                                reader.readAsDataURL(file);
                            } else {
                                imagePreview.src = '';
                                imagePreview.style.display = 'none';
                            }
                        }
                        function previewImage2(event) {
                            const imagePreview2 = document.getElementById('imagePreview2');
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    imagePreview2.src = e.target.result;
                                    imagePreview2.style.display = 'inline-block';
                                }
                                reader.readAsDataURL(file);
                            } else {
                                imagePreview2.src = '';
                                imagePreview2.style.display = 'none';
                            }
                        }
                        function previewFavicon(event) {
                            const faviconPreview = document.getElementById('faviconPreview');
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    faviconPreview.src = e.target.result;
                                    faviconPreview.style.display = 'inline-block';
                                }
                                reader.readAsDataURL(file);
                            } else {
                                faviconPreview.src = '';
                                faviconPreview.style.display = 'none';
                            }
                        }
                        </script>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Main Office</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="addr" value="<?= htmlspecialchars($row['addr']) ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Branch Offices</h2>
                        <p class="text-muted small mb-3">Up to three additional branches. Leave a branch's fields blank to hide it from the public site.</p>
                        <?php foreach ([2, 3, 4] as $n): ?>
                        <div class="row g-3 mb-2">
                            <div class="col-12">
                                <label class="form-label small text-muted mb-0">Branch <?= $n - 1 ?></label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Branch Name</label>
                                <input type="text" name="branch<?= $n ?>_name" value="<?= htmlspecialchars($row['branch' . $n . '_name']) ?>" class="form-control" placeholder="e.g. Asia Pacific Office">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="addr<?= $n ?>" value="<?= htmlspecialchars($row['addr' . $n]) ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone<?= $n ?>" value="<?= htmlspecialchars($row['phone' . $n]) ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email<?= $n ?>" value="<?= htmlspecialchars($row['email' . $n]) ?>" class="form-control">
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Custom Status Options</h2>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Custom Field 1</label>
                                <input type="text" name="custom1" value="<?= htmlspecialchars($row['custom1']) ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Custom Field 2</label>
                                <input type="text" name="custom2" value="<?= htmlspecialchars($row['custom2']) ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Custom Field 3</label>
                                <input type="text" name="custom3" value="<?= htmlspecialchars($row['custom3']) ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Custom Field 4</label>
                                <input type="text" name="custom4" value="<?= htmlspecialchars($row['custom4']) ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Custom Field 5</label>
                                <input type="text" name="custom5" value="<?= htmlspecialchars($row['custom5']) ?>" class="form-control">
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-muted mt-4 mb-3 border-bottom pb-2">Other</h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Livechat Code</label>
                                <textarea rows="6" name="tawk" class="form-control code"><?= htmlspecialchars($row['tawk']) ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Year</label>
                                <input type="text" name="year" value="<?= htmlspecialchars($row['year']) ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Site URL</label>
                                <input type="text" name="url" value="<?= htmlspecialchars($row['url']) ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="admin-card-header border-top border-bottom-0">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Save Settings</button>
                    </div>
                </form>
<?php include 'partials/admin_end.php'; ?>
