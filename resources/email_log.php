<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */

if ($row['amt'] == 'user') {
    header('Location: vault.php');
    exit();
}
include_once 'config.php';
require_once 'security.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resend_id'])) {
    verify_csrf();

    $resendId = (int) $_POST['resend_id'];
    $stmt = $conn->prepare("SELECT * FROM email_log WHERE id = ?");
    $stmt->bind_param('i', $resendId);
    $stmt->execute();
    $original = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$original) {
        $message = '<div class="alert alert-danger">That log entry no longer exists.</div>';
    } else {
        $result = sendMailSMTP(
            $original['recipient_email'],
            $original['recipient_name'],
            $original['subject'],
            $original['html_body'],
            $original['text_body']
        );

        logEmailSend(
            $original['template_key'],
            $original['recipient_email'],
            $original['recipient_name'],
            $original['subject'],
            $original['html_body'],
            $original['text_body'],
            $result['success'],
            $result['success'] ? '' : $result['message'],
            $original['tracking_number']
        );

        $message = $result['success']
            ? '<div class="alert alert-success">Resent to ' . htmlspecialchars($original['recipient_email']) . '.</div>'
            : '<div class="alert alert-danger">Resend failed: ' . htmlspecialchars($result['message']) . '</div>';
    }
}

$statusFilter = $_GET['status'] ?? '';
$where = '';
if (in_array($statusFilter, ['sent', 'failed'], true)) {
    $where = "WHERE status = '" . $conn->real_escape_string($statusFilter) . "'";
}
$logs = $conn->query("SELECT * FROM email_log $where ORDER BY created_at DESC LIMIT 200")->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Notification Log';
$activeNav = 'email_log';
include 'partials/admin_start.php';
?>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <div>
                        <h1 class="h4 mb-0">Notification Log</h1>
                        <div class="text-muted small">Every tracking notification the app has attempted to send.</div>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-sm <?= $statusFilter === '' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="email_log.php">All</a>
                        <a class="btn btn-sm <?= $statusFilter === 'sent' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="email_log.php?status=sent">Sent</a>
                        <a class="btn btn-sm <?= $statusFilter === 'failed' ? 'btn-primary' : 'btn-outline-secondary' ?>" href="email_log.php?status=failed">Failed</a>
                    </div>
                </div>

                <?= $message ?>

                <div class="admin-card">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Sent At</th>
                                    <th>Template</th>
                                    <th>Tracking #</th>
                                    <th>Recipient</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($logs)): ?>
                                    <tr><td colspan="7" class="text-center text-muted py-4">No notifications sent yet.</td></tr>
                                <?php else: foreach ($logs as $log): ?>
                                    <tr>
                                        <td class="text-nowrap"><?= htmlspecialchars($log['created_at']) ?></td>
                                        <td><?= htmlspecialchars($log['template_key']) ?></td>
                                        <td><?= htmlspecialchars($log['tracking_number']) ?></td>
                                        <td><?= htmlspecialchars($log['recipient_email']) ?></td>
                                        <td class="text-truncate" style="max-width:220px;"><?= htmlspecialchars($log['subject']) ?></td>
                                        <td>
                                            <?php if ($log['status'] === 'sent'): ?>
                                                <span class="badge bg-success">Sent</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger" title="<?= htmlspecialchars($log['error_message']) ?>">Failed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <form method="post" action="email_log.php<?= $statusFilter ? '?status=' . urlencode($statusFilter) : '' ?>" class="m-0">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="resend_id" value="<?= (int) $log['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                    onclick="return confirm('Resend this email to <?= htmlspecialchars($log['recipient_email'], ENT_QUOTES) ?>?')">
                                                    <i class="bi bi-arrow-repeat"></i> Resend
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php include 'partials/admin_end.php'; ?>
