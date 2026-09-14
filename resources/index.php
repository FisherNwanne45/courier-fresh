<?php
include('session.php');          // This should NOT include config.php itself
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */
include_once 'config.php';      // Ensures config is loaded only once
require_once 'security.php';

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}

// --- Dashboard stats ---
function countQuery(mysqli $conn, string $sql): int
{
    $result = $conn->query($sql);
    return $result ? (int) ($result->fetch_assoc()['c'] ?? 0) : 0;
}
$totalParcels = countQuery($conn, "SELECT COUNT(*) AS c FROM user");
$deliveredParcels = countQuery($conn, "SELECT COUNT(*) AS c FROM user WHERE rmk = 'Delivered'");
$vaultUsers = countQuery($conn, "SELECT COUNT(*) AS c FROM userlog WHERE amt != 'admin'");
$emailsSentToday = countQuery($conn, "SELECT COUNT(*) AS c FROM email_log WHERE status = 'sent' AND DATE(created_at) = CURDATE()");
$emailsFailedToday = countQuery($conn, "SELECT COUNT(*) AS c FROM email_log WHERE status = 'failed' AND DATE(created_at) = CURDATE()");

$pageTitle = 'Dashboard';
$activeNav = 'dashboard';
include 'partials/admin_start.php';
?>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <div>
                        <h1 class="h4 mb-0">Welcome back, <?= htmlspecialchars($login_session); ?></h1>
                        <div class="text-muted small">Here's what's happening with your shipments today.</div>
                    </div>
                    <a href="identity.php" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Create New Tracking</a>
                </div>

                <?php if (isset($_SESSION['Success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['Success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['Success']); ?>
                <?php endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-lg-3">
                        <a href="#parcel-list" class="stat-card">
                            <span class="stat-card-icon"><i class="bi bi-box-seam"></i></span>
                            <div>
                                <div class="stat-card-value"><?= $totalParcels; ?></div>
                                <div class="stat-card-label">Total Parcels</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a href="#parcel-list" class="stat-card">
                            <span class="stat-card-icon success"><i class="bi bi-check2-circle"></i></span>
                            <div>
                                <div class="stat-card-value"><?= $deliveredParcels; ?></div>
                                <div class="stat-card-label">Delivered</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a href="users.php" class="stat-card">
                            <span class="stat-card-icon info"><i class="bi bi-people"></i></span>
                            <div>
                                <div class="stat-card-value"><?= $vaultUsers; ?></div>
                                <div class="stat-card-label">Vault Users</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a href="email_log.php" class="stat-card">
                            <span class="stat-card-icon warning"><i class="bi bi-envelope-check"></i></span>
                            <div>
                                <div class="stat-card-value">
                                    <?= $emailsSentToday; ?>
                                    <?php if ($emailsFailedToday > 0): ?>
                                        <span class="badge bg-danger" style="font-size:.6rem; vertical-align:middle;"><?= $emailsFailedToday; ?> failed</span>
                                    <?php endif; ?>
                                </div>
                                <div class="stat-card-label">Emails Sent Today</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="admin-card" id="parcel-list">
                    <div class="admin-card-header">
                        <h2><i class="bi bi-box-seam me-2 text-primary"></i>All Parcels</h2>
                        <a class="btn btn-sm btn-outline-primary" href="identity.php">
                            <i class="bi bi-plus-lg me-1"></i>Create New Tracking
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Track No.</th>
                                    <th>Image</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT * FROM user ORDER BY id DESC");
                                if (!$result) {
                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">Query failed: ' . htmlspecialchars($conn->error) . '</td></tr>';
                                } elseif ($result->num_rows == 0) {
                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">No parcels yet. <a href="identity.php">Create your first tracking record</a>.</td></tr>';
                                } else {
                                    while ($parcelRow = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo htmlspecialchars($parcelRow['cid']); ?></td>
                                            <td>
                                                <img src="img/<?php echo htmlspecialchars($parcelRow['image']); ?>"
                                                    width="40" height="40" class="rounded" style="object-fit:cover;">
                                            </td>
                                            <td><?php echo htmlspecialchars($parcelRow['remark']); ?></td>
                                            <td><?php echo htmlspecialchars($parcelRow['name']); ?></td>
                                            <td><?php echo statusBadge($parcelRow['rmk']); ?></td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-outline-secondary"
                                                    href="edit.php?id=<?php echo (int)$parcelRow['id']; ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this parcel?')"
                                                    href="delete.php?id=<?php echo (int)$parcelRow['id']; ?>&csrf_token=<?php echo csrf_url_token(); ?>">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php include 'partials/admin_end.php'; ?>
