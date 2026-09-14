<?php
include('session.php');
/** @var array $row Logged-in user's row, set in session.php */
/** @var string $login_session Logged-in username, set in session.php */

// This is the client-facing vault -- admin accounts belong on the dashboard.
if (($row['amt'] ?? '') !== 'user') {
    header('Location: index.php');
    exit();
}

$vaultUser = $row;
$siteRow = $conn->query("SELECT * FROM site WHERE id = 20")->fetch_assoc() ?: [];
$scheme = getColorScheme($siteRow['track_color_scheme'] ?? 'red');
$schemeText = $scheme['text'] ?? '#fff';

// The 6 duty/fee line items shown below -- each pairs a free-text "charge"
// field with a Cleared / Not Cleared status field, plus an icon that just
// makes the list easier to scan. Labels match exactly what the admin sees
// when editing this account (see edit_user.php) so the two stay in sync.
$dutyLines = [
    ['label' => 'Import Tax', 'icon' => 'bi-bank', 'charge' => $vaultUser['rank'], 'status' => $vaultUser['phone']],
    ['label' => 'VAT', 'icon' => 'bi-receipt', 'charge' => $vaultUser['mail'], 'status' => $vaultUser['type']],
    ['label' => 'Inspection Fee', 'icon' => 'bi-search', 'charge' => $vaultUser['dur'], 'status' => $vaultUser['paydate']],
    ['label' => 'Handling / Disbursement Fee', 'icon' => 'bi-box-seam', 'charge' => $vaultUser['loc1'], 'status' => $vaultUser['cdt']],
    ['label' => 'Storage Fee', 'icon' => 'bi-archive', 'charge' => $vaultUser['status'], 'status' => $vaultUser['mail2']],
    ['label' => 'Insurance Fee', 'icon' => 'bi-shield-check', 'charge' => $vaultUser['phone2'], 'status' => $vaultUser['paym']],
];

$invoiceFile = trim($vaultUser['image'] ?? '');
$invoicePath = $invoiceFile !== '' ? __DIR__ . '/img/' . $invoiceFile : '';
$hasInvoice = $invoiceFile !== '' && is_file($invoicePath);
$invoiceExt = $hasInvoice ? strtoupper(pathinfo($invoiceFile, PATHINFO_EXTENSION)) : '';
$invoiceIsPdf = $invoiceExt === 'PDF';

function h(?string $v): string
{
    return htmlspecialchars($v ?? '', ENT_QUOTES);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Vault &middot; <?= h($siteRow['name'] ?? 'Client Portal') ?></title>
    <link href="img/<?= h($siteRow['favicon'] ?? '') ?>" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">
    <style>
        :root {
            --brand: <?= $scheme['brand'] ?>;
            --brand-dark: <?= $scheme['brand_dark'] ?>;
        }
        body {
            background: #f4f4f7;
            font-family: 'Open Sans', Arial, sans-serif;
            color: #2d2d2d;
        }

        /* --- Topbar -- matches resources/track-result.php's .tr-topbar
               exactly, per request, so the vault and the public tracking
               page read as the same product. --- */
        .tr-topbar { background: #fff; border-bottom: 1px solid #e9e9ec; padding: 18px 0; }
        .tr-topbar img { max-height: 46px; max-width: 100%; }
        .tr-back-btn {
            display: inline-flex; align-items: center; gap: 10px;
            background: #f4f4f7; border: 1px solid transparent; color: #444;
            border-radius: 30px; padding: 6px 18px 6px 6px; font-weight: 600; font-size: 14px;
            transition: background .2s, color .2s;
        }
        .tr-back-btn .tr-back-icon {
            width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
            background: #fff; display: inline-flex; align-items: center; justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,.1); color: var(--brand);
            transition: transform .2s;
        }
        .tr-back-btn:hover { background: #f7f7f7; color: var(--brand); }
        .tr-translator .site-translator .goog-te-gadget-simple,
        .tr-translator .site-translator .site-translator-trigger {
            background: #f4f4f7; border: 1px solid transparent;
            border-radius: 30px; padding: 6px 14px; font-size: 13px; display: inline-block; cursor: pointer;
        }
        .tr-translator .site-translator .goog-te-gadget-simple:hover,
        .tr-translator .site-translator .site-translator-trigger:hover { background: #f7f7f7; }
        .tr-translator .site-translator .goog-te-gadget-simple a,
        .tr-translator .site-translator .goog-te-gadget-simple a span,
        .tr-translator .site-translator .site-translator-trigger a,
        .tr-translator .site-translator .site-translator-trigger a span { color: #444 !important; text-decoration: none !important; }

        /* --- Hero (gradient welcome banner) --------------------------- */
        .vault-hero {
            background: <?= $scheme['gradient'] ?>;
            border-radius: 16px;
            padding: 28px 30px;
            color: <?= $schemeText ?>;
            box-shadow: 0 14px 30px -12px <?= $scheme['shadow'] ?>;
            position: relative;
            overflow: hidden;
        }
        .vault-hero::before {
            content: ""; position: absolute; top: -60px; right: -60px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .vault-hero h1 { position: relative; z-index: 1; font-size: 1.6rem; font-weight: 800; margin-bottom: 2px; }
        .vault-hero p { position: relative; z-index: 1; opacity: .85; margin-bottom: 0; }

        /* --- Cards -- matches track-result.php's .tr-bento ------------- */
        .tr-bento { background: #fff; border-radius: 12px; border: 1px solid #ececec; box-shadow: 0 1px 3px rgba(0,0,0,.04); padding: 22px; }
        .tr-card-header { padding: 18px 22px; border-bottom: 1px solid #f0f0f0; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .tr-icon-badge {
            width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            background: #f7f7f7; color: var(--brand); font-size: 17px;
        }
        .tr-stat-tile { display: flex; align-items: center; gap: 14px; }
        .tr-stat-value { font-size: 16px; font-weight: 700; color: #1a1a1a; overflow-wrap: anywhere; }
        .tr-stat-label { font-size: 11.5px; color: #9a9a9a; text-transform: uppercase; letter-spacing: .05em; }

        .duty-row { display: flex; align-items: center; gap: 16px; padding: 14px 22px; border-bottom: 1px solid #f5f5f5; }
        .duty-row:last-child { border-bottom: 0; }
        .duty-label { font-weight: 600; font-size: 14.5px; }
        .duty-charge { font-size: 13.5px; color: #777; }
        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .78rem; font-weight: 700; padding: 5px 13px; border-radius: 20px;
        }
        .status-cleared { background: #e7f8ee; color: #15803d; }
        .status-pending { background: #fef3c7; color: #b45309; }

        .tr-print-btn { background: var(--brand); border-color: var(--brand); }
        .tr-print-btn:hover { background: var(--brand-dark); border-color: var(--brand-dark); }
        .tr-print-btn.text-white, .tr-print-btn.text-white:hover { color: <?= $schemeText ?> !important; }
    </style>
</head>

<body>
    <div class="tr-topbar">
        <div class="container">
            <div class="row align-items-center gy-2">
                <div class="col-12 col-md-auto">
                    <a href="../index.php">
                        <?php if (!empty($siteRow['image'])): ?>
                            <img src="img/<?= h($siteRow['image']) ?>" alt="<?= h($siteRow['name'] ?? '') ?>">
                        <?php else: ?>
                            <strong><?= h($siteRow['name'] ?? '') ?></strong>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="col-12 col-md-auto ms-md-auto d-flex align-items-center gap-3 flex-wrap">
                    <div class="tr-translator">
                        <?php $row = $siteRow; include __DIR__ . '/translator.php'; $row = $vaultUser; ?>
                    </div>
                    <a href="logout.php" class="btn tr-back-btn">
                        <span class="tr-back-icon"><i class="bi bi-box-arrow-right"></i></span>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="max-width:1000px; margin-top:36px; margin-bottom:160px;">

        <div class="vault-hero mb-4">
            <h1>Welcome, <?= h($vaultUser['remark']) ?></h1>
            <p>Here's the current status of your vault contents.</p>
        </div>

        <div class="tr-bento mb-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="tr-stat-tile">
                        <span class="tr-icon-badge"><i class="bi bi-upc-scan"></i></span>
                        <div>
                            <div class="tr-stat-value"><?= h($vaultUser['cid']) ?></div>
                            <div class="tr-stat-label">Vault Serial No.</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tr-stat-tile">
                        <span class="tr-icon-badge"><i class="bi bi-box-seam"></i></span>
                        <div>
                            <div class="tr-stat-value"><?= h($vaultUser['name']) ?></div>
                            <div class="tr-stat-label">Content of Vault</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tr-stat-tile">
                        <span class="tr-icon-badge"><i class="bi bi-envelope"></i></span>
                        <div>
                            <div class="tr-stat-value" style="font-size:15px;"><?= h($vaultUser['username']) ?></div>
                            <div class="tr-stat-label">Email</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tr-bento mb-4" style="padding:0;">
            <div class="tr-card-header">
                <span class="tr-icon-badge" style="margin-bottom:0;"><i class="bi bi-receipt-cutoff"></i></span>
                Duties &amp; Charges
            </div>
            <?php foreach ($dutyLines as $line): $cleared = trim((string) $line['status']) === 'Cleared'; ?>
                <div class="duty-row">
                    <span class="tr-icon-badge" style="margin-bottom:0;"><i class="bi <?= h($line['icon']) ?>"></i></span>
                    <div class="flex-grow-1">
                        <div class="duty-label"><?= h($line['label']) ?></div>
                        <div class="duty-charge"><?= h($line['charge']) !== '' ? h($line['charge']) : 'No charge on record' ?></div>
                    </div>
                    <?php if (trim((string) $line['status']) !== ''): ?>
                        <span class="status-badge <?= $cleared ? 'status-cleared' : 'status-pending' ?>">
                            <i class="bi <?= $cleared ? 'bi-check-circle-fill' : 'bi-hourglass-split' ?>"></i>
                            <?= h($line['status']) ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($hasInvoice): ?>
            <div class="tr-bento mb-5 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="tr-stat-tile">
                    <span class="tr-icon-badge" style="margin-bottom:0;">
                        <i class="bi <?= $invoiceIsPdf ? 'bi-file-earmark-pdf' : 'bi-file-earmark-image' ?>"></i>
                    </span>
                    <div>
                        <div class="tr-stat-value">Invoice Document</div>
                        <div class="tr-stat-label"><?= h($invoiceExt) ?> file attached to your vault record</div>
                    </div>
                </div>
                <a class="btn tr-print-btn text-white px-4" href="img/<?= h($invoiceFile) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-download me-1"></i>View / Download
                </a>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>
