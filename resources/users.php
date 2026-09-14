<?php
include('session.php');          // session.php should NOT include config.php
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */
include_once 'config.php';      // ensures config is loaded once
require_once 'security.php';

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}

$pageTitle = 'Vault Users';
$activeNav = 'vault';
include 'partials/admin_start.php';
?>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <div>
                        <h1 class="h4 mb-0">Vault Users</h1>
                        <div class="text-muted small">Customer accounts that can log in to check their vault.</div>
                    </div>
                    <a class="btn btn-primary" href="create_user.php">
                        <i class="bi bi-person-plus me-1"></i>Create New Vault User
                    </a>
                </div>

                <?php if (isset($_SESSION['Success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['Success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['Success']); ?>
                <?php endif; ?>

                <div class="admin-card">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Content</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>PDF</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM userlog WHERE amt != 'admin' ORDER BY id DESC";
                                $result = $conn->query($query);
                                if (!$result) {
                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">Query failed: ' . htmlspecialchars($conn->error) . '</td></tr>';
                                } elseif ($result->num_rows == 0) {
                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">No vault users yet.</td></tr>';
                                } else {
                                    while ($user = $result->fetch_assoc()) {
                                        $pdfLink = !empty($user['image']) ? 'img/' . htmlspecialchars($user['image']) : '#';
                                ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['remark']); ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                            <td class="text-muted">&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</td>
                                            <td>
                                                <?php if (!empty($user['image'])): ?>
                                                    <a href="<?php echo $pdfLink; ?>" target="_blank" class="text-decoration-none">
                                                        <i class="bi bi-file-earmark-pdf text-danger"></i> View
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">&mdash;</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-outline-secondary"
                                                    href="edit_user.php?id=<?php echo (int)$user['id']; ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this vault user?')"
                                                    href="deleteuser.php?id=<?php echo (int)$user['id']; ?>&csrf_token=<?php echo csrf_url_token(); ?>">
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
