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
/** @var string $name Site name, set in config.php */
/** @var string $track Tracking URL, set in config.php */

$siteStmt = $conn->prepare("SELECT * FROM site WHERE id = 20 LIMIT 1");
$siteStmt->execute();
$siteData = $siteStmt->get_result()->fetch_assoc();

$commonPlaceholders = [
    'site_logo_url' => siteBaseUrl() . '/img/' . ($siteData['image'] ?? ''),
    'site_address' => $siteData['addr'] ?? '',
    'site_phone' => $siteData['phone'] ?? '',
    'current_year' => date('Y'),
];

// Placeholders available to each template, with sample values used for the
// live preview and the "Send test email" action.
$placeholderCatalog = [
    'parcel_created' => array_merge([
        'receiver_name' => 'Jane Doe',
        'site_name' => $name,
        'parcel_type' => 'Electronics',
        'tracking_number' => 'CN1234567890',
        'sender_name' => 'John Smith',
        'status' => 'Order Confirmed',
        'tracking_url' => $track,
    ], $commonPlaceholders),
    'status_updated' => array_merge([
        'receiver_name' => 'Jane Doe',
        'site_name' => $name,
        'status' => 'On The Way',
        'tracking_number' => 'CN1234567890',
        'parcel_type' => 'Electronics',
        'remarks' => "Package cleared customs.\nOut for delivery tomorrow.",
        'tracking_url' => $track,
        'shipment_history' => "\n<tr><td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3;'>Beijing Hub</td>"
            . "<td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3;'>2026-09-10</td>"
            . "<td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3; font-weight:600;'>Order Confirmed</td></tr>"
            . "\n<tr><td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3;'>Beijing Capital Airport</td>"
            . "<td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3;'>2026-09-11</td>"
            . "<td style='padding:10px 12px; font-size:13px; color:#374151; border-bottom:1px solid #eef0f3; font-weight:600;'>On The Way</td></tr>",
    ], $commonPlaceholders),
];

$message = '';
$testResultMessage = '';
$activeKey = $_GET['key'] ?? ($_POST['template_key'] ?? '');
$templates = listEmailTemplates();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $action = $_POST['action'] ?? 'save';
    $activeKey = $_POST['template_key'] ?? '';
    $template = getEmailTemplate($activeKey);

    if (!$template) {
        $message = '<div class="alert alert-danger">Unknown template.</div>';
    } else {
        $posted = [
            'subject' => trim($_POST['subject'] ?? ''),
            'html_body' => $_POST['html_body'] ?? '',
            'text_body' => $_POST['text_body'] ?? '',
        ];

        if ($posted['subject'] === '' || $posted['html_body'] === '') {
            $message = '<div class="alert alert-danger">Subject and HTML body cannot be empty.</div>';
        } elseif ($action === 'test') {
            $testRecipient = trim($_POST['test_recipient'] ?? '');
            if (!filter_var($testRecipient, FILTER_VALIDATE_EMAIL)) {
                $testResultMessage = '<div class="alert alert-danger">Enter a valid email address to send the test to.</div>';
            } else {
                $sample = $placeholderCatalog[$activeKey] ?? [];
                $sampleHtml = $sample;
                if (isset($sampleHtml['remarks'])) {
                    $sampleHtml['remarks'] = nl2br(htmlspecialchars($sample['remarks']));
                }
                foreach ($sampleHtml as $k => $v) {
                    if ($k !== 'remarks' && $k !== 'shipment_history') {
                        $sampleHtml[$k] = htmlspecialchars($v);
                    }
                }

                $rendered = renderEmailTemplate($posted, $sample, $sampleHtml);
                $mailSettings = getMailSettings();
                $result = sendMailSMTP(
                    $testRecipient,
                    $testRecipient,
                    '[TEST] ' . $rendered['subject'],
                    $rendered['html'],
                    $rendered['text'],
                    $mailSettings['smtp_from_email'],
                    $mailSettings['smtp_from_name']
                );

                $testResultMessage = $result['success']
                    ? '<div class="alert alert-success">Test email sent to ' . htmlspecialchars($testRecipient) . ' using sample data.</div>'
                    : '<div class="alert alert-danger">Test email failed: ' . htmlspecialchars($result['message']) . '</div>';
            }
            // Re-show what was in the form, not what's saved.
            $template = array_merge($template, $posted);
        } else {
            $stmt = $conn->prepare(
                "UPDATE email_templates SET subject = ?, html_body = ?, text_body = ?, updated_at = NOW() WHERE template_key = ?"
            );
            $stmt->bind_param('ssss', $posted['subject'], $posted['html_body'], $posted['text_body'], $activeKey);
            $stmt->execute();
            $stmt->close();

            $message = '<div class="alert alert-success">Template saved.</div>';
            $template = getEmailTemplate($activeKey);
        }
    }
    $templates = listEmailTemplates();
} else {
    $template = $activeKey ? getEmailTemplate($activeKey) : null;
}

$samplesJson = json_encode($placeholderCatalog, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
$activeKeyJson = json_encode($activeKey, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

$pageTitle = 'Email Templates';
$activeNav = 'email_templates';
$extraHead = <<<'HTML'
<style>
.placeholder-btn { margin: 2px 4px 2px 0; }
.preview-pane { border: 1px solid #e5e7eb; border-radius: .5rem; background: #fff; overflow: hidden; }
.preview-pane iframe { width: 100%; height: 420px; border: 0; }
.template-tab.active { background-color: var(--bs-primary); color: #fff; border-color: var(--bs-primary); }
textarea.code { font-family: Menlo, Consolas, monospace; font-size: 12px; }
</style>
HTML;
include 'partials/admin_start.php';
?>
                <div class="mb-4">
                    <h1 class="h4 mb-0">Email Templates</h1>
                    <div class="text-muted small">Edit the notification emails sent to receivers, with a live preview.</div>
                </div>

                <?= $message ?>
                <?= $testResultMessage ?>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php foreach ($templates as $t): ?>
                        <a class="btn btn-sm template-tab <?= $t['template_key'] === $activeKey ? 'active btn-primary' : 'btn-outline-secondary' ?>"
                            href="email_templates.php?key=<?= urlencode($t['template_key']) ?>">
                            <?= htmlspecialchars($t['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?php if (!$template): ?>
                    <div class="admin-card admin-card-body text-muted">
                        Choose a template above to edit its subject, content, and preview it.
                    </div>
                <?php else: ?>
                    <p class="text-muted"><?= htmlspecialchars($template['description']) ?></p>

                    <div class="mb-3">
                        <div class="small fw-semibold text-muted mb-1">Placeholders <span class="fw-normal">(click to insert)</span></div>
                        <?php foreach (($placeholderCatalog[$activeKey] ?? []) as $ph => $sampleVal): ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary placeholder-btn"
                                data-placeholder="{{<?= htmlspecialchars($ph) ?>}}">{{<?= htmlspecialchars($ph) ?>}}</button>
                        <?php endforeach; ?>
                    </div>

                    <form action="email_templates.php?key=<?= urlencode($activeKey) ?>" method="post" id="templateForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" id="formAction" value="save">
                        <input type="hidden" name="template_key" value="<?= htmlspecialchars($activeKey) ?>">

                        <div class="admin-card mb-3">
                            <div class="admin-card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        value="<?= htmlspecialchars($template['subject']) ?>">
                                </div>

                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="html_body">HTML Body</label>
                                        <textarea name="html_body" id="html_body" rows="18"
                                            class="form-control code"><?= htmlspecialchars($template['html_body']) ?></textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Live Preview</label>
                                        <div class="preview-pane">
                                            <iframe id="htmlPreview" title="HTML preview"></iframe>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label" for="text_body">Plain-Text Body</label>
                                    <textarea name="text_body" id="text_body" rows="6"
                                        class="form-control code"><?= htmlspecialchars($template['text_body']) ?></textarea>
                                </div>
                            </div>
                            <div class="admin-card-header border-top border-bottom-0">
                                <button type="submit" class="btn btn-primary" onclick="document.getElementById('formAction').value='save';">
                                    <i class="bi bi-check2-circle me-1"></i>Save Template
                                </button>
                            </div>
                        </div>

                        <div class="admin-card">
                            <div class="admin-card-header">
                                <h2><i class="bi bi-send me-2 text-primary"></i>Send a Test Email</h2>
                            </div>
                            <div class="admin-card-body">
                                <p class="text-muted small mb-3">Sends using sample data, from whatever is currently typed above.</p>
                                <div class="row g-2 align-items-end">
                                    <div class="col-sm-8 col-md-6">
                                        <input type="email" name="test_recipient" placeholder="you@example.com" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-outline-primary" onclick="document.getElementById('formAction').value='test';">
                                            <i class="bi bi-send me-1"></i>Send Test Email
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
<?php
$extraScripts = '';
if ($template) {
    $extraScripts = <<<HTML
<script>
(function () {
    var samples = {$samplesJson};
    var activeKey = {$activeKeyJson};
    var sample = samples[activeKey] || {};

    function renderWithSample(str) {
        return str.replace(/\\{\\{(\\w+)\\}\\}/g, function (match, key) {
            return Object.prototype.hasOwnProperty.call(sample, key) ? sample[key] : match;
        });
    }

    function updatePreview() {
        var html = document.getElementById('html_body').value;
        var rendered = renderWithSample(html);
        var iframe = document.getElementById('htmlPreview');
        var doc = iframe.contentDocument || iframe.contentWindow.document;
        doc.open();
        doc.write(rendered);
        doc.close();
    }

    document.getElementById('html_body').addEventListener('input', updatePreview);
    document.querySelectorAll('.placeholder-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.activeElement;
            if (target !== document.getElementById('html_body') && target !== document.getElementById('text_body') && target !== document.getElementById('subject')) {
                target = document.getElementById('html_body');
            }
            var token = btn.getAttribute('data-placeholder');
            var start = target.selectionStart || 0;
            var end = target.selectionEnd || 0;
            target.value = target.value.slice(0, start) + token + target.value.slice(end);
            target.focus();
            target.selectionStart = target.selectionEnd = start + token.length;
            updatePreview();
        });
    });

    updatePreview();
})();
</script>
HTML;
}
include 'partials/admin_end.php';
?>
