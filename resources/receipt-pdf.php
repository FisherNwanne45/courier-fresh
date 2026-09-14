<?php
/**
 * Generates the shipping receipt as a real PDF file (landscape, compact
 * page size) using Dompdf -- linked from the "Download Receipt (PDF)"
 * button on track-result.php, which used to just call window.print() and
 * rely on the visitor's browser "Save as PDF" destination.
 *
 * GET ?cid=<tracking number>  (same lookup track-result.php uses)
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once('config.php');
/** @var array $row Site settings row, set in config.php (SELECT * FROM site) */
$siteRow = $row;

use Dompdf\Dompdf;
use Dompdf\Options;

$cid = trim($_GET['cid'] ?? '');
if ($cid === '') {
    http_response_code(400);
    exit('Missing tracking number.');
}

$stmt = $conn->prepare("SELECT * FROM user WHERE cid = ?");
$stmt->bind_param('s', $cid);
$stmt->execute();
$trackingRows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($trackingRows)) {
    http_response_code(404);
    exit('No shipment found for that tracking number.');
}

/**
 * The 7 (date, status, location) history slots collapsed into a clean list,
 * skipping any slot that's entirely empty. Mirrors shipmentHistory() in
 * track-result.php -- duplicated rather than shared so this endpoint has
 * no dependency on that file's internals, only on config.php.
 */
function receiptHistory(array $t): array
{
    $slots = [
        [$t['cdt'], $t['status'], $t['loc1']],
        [$t['cdt2'], $t['status2'], $t['loc2']],
        [$t['cdt3'], $t['status3'], $t['loc3']],
        [$t['cdt4'], $t['status4'], $t['loc4']],
        [$t['cdt5'], $t['status5'], $t['loc5']],
        [$t['cdt6'], $t['status6'], $t['loc6']],
        [$t['cdt7'], $t['status7'], $t['loc7']],
    ];
    $rows = [];
    foreach ($slots as [$date, $status, $loc]) {
        if (trim((string) $date) === '' && trim((string) $status) === '' && trim((string) $loc) === '') {
            continue;
        }
        $rows[] = ['date' => $date, 'status' => $status, 'location' => $loc];
    }
    return $rows;
}

$scheme = getColorScheme($siteRow['track_color_scheme'] ?? 'red');
$schemeText = $scheme['text'] ?? '#fff';
$schemeTextRgb = $scheme['text_rgb'] ?? '255,255,255';

$logoPath = __DIR__ . '/img/' . ($siteRow['image'] ?? '');
$logoDataUri = '';
if (is_file($logoPath)) {
    $imgData = @file_get_contents($logoPath);
    if ($imgData !== false) {
        $mime = @mime_content_type($logoPath) ?: 'image/png';
        $logoDataUri = 'data:' . $mime . ';base64,' . base64_encode($imgData);
    }
}

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; }
    body {
        /* DejaVu Sans, not Helvetica/Arial -- those map to a base-14 PDF
           font with only Latin-1-ish coverage, so non-ASCII names/addresses
           would render as "?". DejaVu Sans is a full-Unicode TTF bundled
           with dompdf. */
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 13px;
        line-height: 1.45;
        color: #1a1a1a;
        margin: 0;
    }
    .receipt { padding: 10mm 12mm; }
    .receipt + .receipt { page-break-before: always; }

    .header-table { width: 100%; border-collapse: collapse; border-bottom: 3px solid #1a1a1a; padding-bottom: 12px; margin-bottom: 14px; }
    .header-table td { vertical-align: top; }
    .header-table img { max-height: 44px; }
    .title-cell { text-align: right; font-size: 18px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
    .title-cell small { display: block; font-size: 10.5px; font-weight: 400; text-transform: none; letter-spacing: 0; color: #666; }

    .idbar { width: 100%; border-collapse: collapse; background-color: <?= $scheme['brand_dark'] ?>; background-image: <?= $scheme['gradient'] ?>; border-radius: 4px; margin-bottom: 16px; }
    .idbar td { padding: 10px 16px; }
    .idlabel { font-size: 9.5px; text-transform: uppercase; letter-spacing: .06em; color: rgba(<?= $schemeTextRgb ?>,.75); margin-bottom: 2px; }
    .idvalue { font-size: 19px; font-weight: 700; letter-spacing: .03em; font-family: 'Courier New', monospace; color: <?= $schemeText ?>; }
    .status-pill { display: inline-block; border: 1.5px solid <?= $schemeText ?>; color: <?= $schemeText ?>; padding: 3px 12px; border-radius: 12px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: .03em; }

    .cols-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    .cols-table td { width: 50%; vertical-align: top; padding: 0 14px 14px 0; }
    .section { margin-bottom: 14px; }
    .section h4 { font-size: 10px; text-transform: uppercase; letter-spacing: .07em; color: #777; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin: 0 0 6px; }
    .section p { margin: 0 0 2px; font-size: 13px; }

    .meta-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
    .meta-table td { padding: 2px 0; }
    .meta-table td.label { color: #777; width: 80px; }
    .meta-table td.value { font-weight: 600; padding-right: 20px; }

    .history-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 4px; }
    .history-table th, .history-table td { border: 1px solid #ccc; padding: 7px 10px; text-align: left; }
    .history-table th { background: #f4f4f5; text-transform: uppercase; font-size: 10px; letter-spacing: .04em; color: #555; }

    .receipt-footer { margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; text-align: center; font-size: 10.5px; color: #888; }
</style>
</head>
<body>
<?php foreach ($trackingRows as $t): $history = receiptHistory($t); ?>
    <div class="receipt">
        <table class="header-table">
            <tr>
                <td>
                    <?php if ($logoDataUri !== ''): ?>
                        <img src="<?= $logoDataUri ?>" alt="<?= htmlspecialchars($siteRow['name'] ?? '') ?>">
                    <?php else: ?>
                        <strong><?= htmlspecialchars($siteRow['name'] ?? '') ?></strong>
                    <?php endif; ?>
                </td>
                <td class="title-cell">
                    Shipping Receipt
                    <small><?= htmlspecialchars($siteRow['addr'] ?? '') ?></small>
                    <small><?php
                        $contact = array_filter([$siteRow['phone'] ?? '', $siteRow['email'] ?? '']);
                        echo implode(' &middot; ', array_map('htmlspecialchars', $contact));
                    ?></small>
                </td>
            </tr>
        </table>

        <table class="idbar">
            <tr>
                <td>
                    <div class="idlabel">Tracking Number</div>
                    <div class="idvalue"><?= htmlspecialchars($t['cid']) ?></div>
                </td>
                <td style="text-align:right;">
                    <div class="idlabel">Status</div>
                    <span class="status-pill"><?= htmlspecialchars($t['rmk']) ?></span>
                </td>
            </tr>
        </table>

        <table class="cols-table">
            <tr>
                <td>
                    <div class="section">
                        <h4>Ship From</h4>
                        <p><strong><?= htmlspecialchars($t['remark']) ?></strong></p>
                        <p><?= htmlspecialchars($t['rank2']) ?></p>
                    </div>
                </td>
                <td>
                    <div class="section">
                        <h4>Ship To</h4>
                        <p><strong><?= htmlspecialchars($t['name']) ?></strong></p>
                        <p><?= htmlspecialchars($t['rank']) ?></p>
                        <p><?= htmlspecialchars($t['phone']) ?> &middot; <?= htmlspecialchars($t['mail']) ?></p>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section">
            <h4>Package Details</h4>
            <table class="meta-table">
                <tr><td class="label">Content</td><td class="value"><?= htmlspecialchars($t['type']) ?></td><td class="label">Weight</td><td class="value"><?= htmlspecialchars($t['dur']) ?></td></tr>
                <tr><td class="label">Duty Fees</td><td class="value"><?= htmlspecialchars($t['paydate']) ?></td><td class="label">Date Issued</td><td class="value"><?= htmlspecialchars($t['cdt'] ?: date('Y-m-d')) ?></td></tr>
            </table>
        </div>

        <div class="section">
            <h4>Shipment History</h4>
            <table class="history-table">
                <thead><tr><th>Date</th><th>Status</th><th>Location</th></tr></thead>
                <tbody>
                    <?php if (empty($history)): ?>
                        <tr><td colspan="3">No history recorded yet.</td></tr>
                    <?php else: foreach ($history as $h): ?>
                        <tr>
                            <td><?= htmlspecialchars($h['date']) ?></td>
                            <td><?= htmlspecialchars($h['status']) ?></td>
                            <td><?= htmlspecialchars($h['location']) ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="receipt-footer">
            Thank you for shipping with <?= htmlspecialchars($siteRow['name'] ?? '') ?>.
            This is a system-generated receipt &mdash; generated <?= date('F j, Y, g:i a') ?>.
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>
<?php
$html = ob_get_clean();

$options = new Options();
// Dompdf writes a font-metrics cache file the first time a non-core font
// (DejaVu Sans, below) is used -- vendor/ is not guaranteed writable by the
// web server user (it isn't here), so point that cache at a directory this
// app already controls and keeps writable, instead of vendor/dompdf's own
// lib/fonts/.
$fontCacheDir = __DIR__ . '/dompdf-cache';
if (!is_dir($fontCacheDir)) {
    // Self-healing: a fresh clone (or the installer, on an older version
    // that predates this directory) won't have this yet.
    @mkdir($fontCacheDir, 0775, true);
    @file_put_contents(
        $fontCacheDir . '/.htaccess',
        "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n"
        . "<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n"
    );
}
$options->set('fontCache', $fontCacheDir);
$options->set('tempDir', $fontCacheDir);
// Dompdf treats data: URI images as "remote" for the purposes of this flag
// even though nothing is actually fetched over the network -- it has to be
// true or the embedded logo silently fails to render. No genuinely remote
// URL is ever used here (the only image is our own base64-embedded logo).
$options->set('isRemoteEnabled', true);
// DejaVu Sans (bundled with dompdf), not Helvetica -- Helvetica is one of
// the 14 base PDF fonts with only Latin-1-ish coverage, so names/addresses
// with characters like ı, ş, ğ rendered as "?". DejaVu Sans is a full
// Unicode TTF.
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$filename = 'receipt-' . preg_replace('/[^A-Za-z0-9_-]/', '', $cid) . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);
