<?php
session_start();
require_once('config.php');
/** @var array $row Site settings row, set in config.php (SELECT * FROM site) */
$siteRow = $row;

// -----------------------------------------------------------------
// Look up the tracking record.
// The search form only ever sends dropdown=cid (a hidden field), so the
// lookup column is fixed rather than taken from user input -- the old
// version interpolated $_POST['dropdown'] directly into the SQL column
// position, which was a SQL-injection hole even though the value went
// through mysqli_real_escape_string() (escaping a value does not make it
// safe to use as an unquoted identifier).
// -----------------------------------------------------------------
$searched = isset($_POST['Submit']);
$search = trim($_POST['search'] ?? '');
$trackingRows = [];

if ($searched && $search !== '') {
    $stmt = $conn->prepare("SELECT * FROM user WHERE cid = ?");
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $trackingRows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

/**
 * Builds the 5-step progress tracker for a given status, matching the
 * original page's logic: the 4th step is whichever "hold" stage applies
 * (Ready for Pickup / Custom Hold / a site-defined custom status / Arrived),
 * and every step up to the current one is marked active.
 */
function trackerSteps(string $status, array $siteRow): array
{
    $fourth = ['label' => 'Ready for Pickup', 'icon' => 'bi-briefcase'];
    if ($status === 'Custom Hold') {
        $fourth = ['label' => 'Custom Hold', 'icon' => 'bi-exclamation-triangle'];
    } elseif ($status === 'Arrived') {
        $fourth = ['label' => 'Arrived', 'icon' => 'bi-flag'];
    } else {
        foreach (['custom1', 'custom2', 'custom3', 'custom4', 'custom5'] as $key) {
            if (!empty($siteRow[$key]) && $status === $siteRow[$key]) {
                $fourth = ['label' => $siteRow[$key], 'icon' => 'bi-exclamation-triangle'];
                break;
            }
        }
    }

    $steps = [
        ['label' => 'Order Confirmed', 'icon' => 'bi-check2'],
        ['label' => 'Picked by Courier', 'icon' => 'bi-person'],
        ['label' => 'On The Way', 'icon' => 'bi-truck'],
        ['label' => $fourth['label'], 'icon' => $fourth['icon']],
        ['label' => 'Delivered', 'icon' => 'bi-box-seam'],
    ];

    $order = ['Order Confirmed', 'Picked by Courier', 'On The Way', $fourth['label'], 'Delivered'];
    $activeIndex = array_search($status, $order, true);

    foreach ($steps as $i => &$step) {
        $step['active'] = $activeIndex !== false && $i <= $activeIndex;
    }
    unset($step);

    return $steps;
}

/**
 * The 7 (date, status, location) history slots collapsed into a clean list,
 * skipping any slot that's entirely empty. Shared by both the on-screen
 * table and the printable receipt so they never drift apart.
 */
function shipmentHistory(array $t): array
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
        if (trim((string)$date) === '' && trim((string)$status) === '' && trim((string)$loc) === '') {
            continue;
        }
        $rows[] = ['date' => $date, 'status' => $status, 'location' => $loc];
    }

    return $rows;
}

$pageTitle = htmlspecialchars($siteRow['name'] ?? 'Track Result');
$scheme = getColorScheme($siteRow['track_color_scheme'] ?? 'red');
// Text sitting directly on the brand-colored gradient/solid backgrounds
// below: white for every scheme except yellow, which is too light for
// white text to read on -- see colorSchemes() in config.php.
$schemeText = $scheme['text'] ?? '#fff';
$schemeTextRgb = $scheme['text_rgb'] ?? '255,255,255';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?> - Track Result</title>
    <link href="img/<?= htmlspecialchars($siteRow['favicon'] ?? '') ?>" rel="shortcut icon">
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
            overflow-x: hidden;
        }
        .tr-value, .text-muted.small { overflow-wrap: break-word; }
        .tr-topbar {
            background: #fff;
            border-bottom: 1px solid #e9e9ec;
            padding: 18px 0;
        }
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
        .tr-back-btn:hover .tr-back-icon { transform: translateX(-3px); }

        /* Tracking page's own look for the shared translator widget (see
           resources/translator.php) -- Google's real widget, styled in
           place, to match the pill/back-button style used here. Languages
           come from admin Appearance settings. */
        .tr-translator .site-translator .goog-te-gadget-simple,
        .tr-translator .site-translator .site-translator-trigger {
            background: #f4f4f7;
            border: 1px solid transparent;
            border-radius: 30px;
            padding: 6px 14px;
            font-size: 13px;
            display: inline-block;
            cursor: pointer;
        }
        .tr-translator .site-translator .goog-te-gadget-simple:hover,
        .tr-translator .site-translator .site-translator-trigger:hover {
            background: #f7f7f7;
        }
        .tr-translator .site-translator .goog-te-gadget-simple a,
        .tr-translator .site-translator .goog-te-gadget-simple a span,
        .tr-translator .site-translator .site-translator-trigger a,
        .tr-translator .site-translator .site-translator-trigger a span {
            color: #444 !important;
            text-decoration: none !important;
        }
        .tr-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .tr-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid #f0f0f0;
        }
        .tr-card-body { padding: 28px; }
        .tr-status-badge {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            background: #f7f7f7;
            color: var(--brand);
        }
        .tr-label { font-size: 12px; text-transform: uppercase; letter-spacing: .04em; color: #9a9a9a; margin-bottom: 4px; }
        .tr-value { font-size: 15px; color: #262626; }

        /* --- Hero (gradient) -------------------------------------------- */
        .tr-hero {
            background: <?= $scheme['gradient'] ?>;
            border-radius: 16px;
            padding: 30px 30px 26px;
            color: <?= $schemeText ?>;
            box-shadow: 0 14px 30px -12px <?= $scheme['shadow'] ?>;
            position: relative;
            overflow: hidden;
        }
        .tr-hero::before {
            content: ""; position: absolute; top: -60px; right: -60px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .tr-hero::after {
            content: ""; position: absolute; bottom: -85px; left: -40px;
            width: 190px; height: 190px; border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .tr-hero-top { position: relative; z-index: 1; }
        .tr-hero-label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: rgba(<?= $schemeTextRgb ?>,.75); margin-bottom: 4px; }
        .tr-hero-cid { font-size: 2rem; font-weight: 800; letter-spacing: .02em; }
        .tr-hero-status {
            display: inline-block; padding: 6px 16px; border-radius: 20px;
            background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.35);
            font-weight: 700; font-size: 13px;
        }

        .tr-hero-track { position: relative; display: flex; margin: 40px 0 2px; z-index: 1; }
        .tr-hero-track .step { flex: 1; text-align: center; position: relative; }
        .tr-hero-track .step::before {
            content: ""; position: absolute; height: 3px; width: 100%; left: 0; top: 19px;
            background: rgba(255,255,255,.3);
        }
        .tr-hero-track .step:first-child::before { left: 50%; width: 50%; }
        .tr-hero-track .step:last-child::before { width: 50%; }
        .tr-hero-track .step.active::before { background: rgba(255,255,255,.95); }
        .tr-hero-track .icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 50%;
            background: rgba(255,255,255,.18); border: 2px solid rgba(255,255,255,.35);
            color: rgba(<?= $schemeTextRgb ?>,.75); position: relative; z-index: 1; font-size: 17px;
        }
        .tr-hero-track .step.active .icon { background: #fff; color: var(--brand); border-color: #fff; }
        .tr-hero-track .text { display: block; margin-top: 9px; font-size: 11.5px; color: rgba(<?= $schemeTextRgb ?>,.65); }
        .tr-hero-track .step.active .text { color: <?= $schemeText ?>; font-weight: 700; }

        /* --- Cards (single uniform style -- no per-card color coding) ---- */
        .tr-bento {
            background: #fff; border-radius: 12px; border: 1px solid #ececec;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
            padding: 22px;
        }
        .tr-icon-badge {
            width: 38px; height: 38px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            background: #f7f7f7; color: var(--brand); font-size: 17px; margin-bottom: 12px;
        }
        .tr-bento-label { font-size: 11px; text-transform: uppercase; letter-spacing: .06em; color: #9a9a9a; margin-bottom: 4px; font-weight: 700; }

        .tr-stat-tile { display: flex; align-items: center; gap: 14px; }
        .tr-stat-tile .tr-icon-badge { margin-bottom: 0; flex-shrink: 0; }
        .tr-stat-value { font-size: 16px; font-weight: 700; color: #1a1a1a; }
        .tr-stat-label { font-size: 11.5px; color: #9a9a9a; text-transform: uppercase; letter-spacing: .05em; }

        /* --- 40/60 split (stacks to one column below lg) ------------------ */
        .tr-split { display: flex; flex-wrap: wrap; gap: 24px; }
        .tr-col-40, .tr-col-60 { flex: 1 1 100%; min-width: 0; }
        @media (min-width: 992px) {
            .tr-col-40 { flex: 0 0 40%; }
            .tr-col-60 { flex: 0 0 calc(60% - 24px); }
        }
        .tr-info-section { padding-bottom: 16px; margin-bottom: 16px; border-bottom: 1px solid #f0f0f0; }
        .tr-info-section:last-child { padding-bottom: 0; margin-bottom: 0; border-bottom: 0; }

        /* --- Preloader ------------------------------------------------- */
        .tr-preloader {
            background: <?= $scheme['gradient'] ?>;
            border-radius: 16px;
            padding: 64px 24px;
            text-align: center;
            color: <?= $schemeText ?>;
            box-shadow: 0 14px 30px -12px <?= $scheme['shadow'] ?>;
            position: relative;
            overflow: hidden;
        }
        .tr-preloader::before {
            content: ""; position: absolute; top: -60px; right: -60px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .tr-preloader::after {
            content: ""; position: absolute; bottom: -85px; left: -40px;
            width: 190px; height: 190px; border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .tr-preloader-ring {
            position: relative; z-index: 1;
            width: 76px; height: 76px; margin: 0 auto;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,.16); border-radius: 50%;
            font-size: 26px;
        }
        .tr-preloader-pulse {
            position: absolute; inset: 0; border-radius: 50%;
            border: 2px solid rgba(255,255,255,.6);
            animation: tr-pulse 1.8s ease-out infinite;
        }
        .tr-preloader-pulse.delay { animation-delay: .9s; }
        @keyframes tr-pulse {
            0% { transform: scale(1); opacity: .8; }
            100% { transform: scale(1.9); opacity: 0; }
        }
        .tr-preloader h5 { position: relative; z-index: 1; margin-top: 22px; }
        .tr-preloader-steps { position: relative; z-index: 1; margin-top: 18px; font-size: 13.5px; color: rgba(<?= $schemeTextRgb ?>,.9); }
        .tr-preloader-steps .step {
            opacity: 0; transform: translateY(6px);
            animation: tr-step-in .45s ease forwards;
            margin-bottom: 6px;
        }
        .tr-preloader-steps .step i { margin-right: 6px; }
        .tr-preloader-steps .step:nth-child(1) { animation-delay: .15s; }
        .tr-preloader-steps .step:nth-child(2) { animation-delay: 1.1s; }
        .tr-preloader-steps .step:nth-child(3) { animation-delay: 2.05s; }
        @keyframes tr-step-in { to { opacity: 1; transform: none; } }

        .tr-track { position: relative; display: flex; margin: 46px 0 10px; }
        .tr-track .step { flex: 1; text-align: center; position: relative; }
        .tr-track .step::before {
            content: "";
            position: absolute;
            height: 4px;
            width: 100%;
            left: 0;
            top: 20px;
            background: #e2e2e2;
        }
        .tr-track .step:first-child::before { left: 50%; width: 50%; }
        .tr-track .step:last-child::before { width: 50%; }
        .tr-track .step.active::before { background: var(--brand); }
        .tr-track .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e2e2e2;
            color: #9a9a9a;
            position: relative;
            z-index: 1;
            font-size: 18px;
        }
        .tr-track .step.active .icon { background: var(--brand); color: <?= $schemeText ?>; }
        .tr-track .text { display: block; margin-top: 10px; font-size: 12px; color: #9a9a9a; }
        .tr-track .step.active .text { color: #262626; font-weight: 700; }

        .tr-parcel-img { width: 100%; max-width: 160px; border-radius: 6px; border: 1px solid #ececec; }
        .tr-history th { font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #9a9a9a; background: #fafafa; border-bottom: 0; padding: 10px 14px; }
        .tr-history td { padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
        .tr-history tbody tr:hover { background: #fafafa; }
        .tr-print-btn { background: var(--brand); border-color: var(--brand); }
        /* Markup applies Bootstrap's .text-white utility to this button;
           override it here (matching specificity + !important) so yellow's
           dark text wins instead of always-white. */
        .tr-print-btn.text-white,
        .tr-print-btn.text-white:hover { color: <?= $schemeText ?> !important; }
        .tr-print-btn:hover { background: var(--brand-dark); border-color: var(--brand-dark); }

        /* --- Printable receipt (hidden on screen, shown only when
               printing / saving as PDF via the browser print dialog).
               Laid out like a standard courier shipping receipt. --- */
        .tr-receipt { display: none; }
        @media print {
            /* Landscape, and noticeably smaller than a full A4 sheet -- a
               shipping receipt doesn't need a whole page. Browsers honor
               an explicit @page size when "Save as PDF" is the selected
               destination, which is how this receipt is actually used. */
            @page { size: 200mm 140mm; margin: 10mm; }
            body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .tr-receipt {
                display: block !important;
                color: #1a1a1a;
                font-family: 'Helvetica Neue', Arial, sans-serif;
                font-size: 12px;
                line-height: 1.4;
            }
            .tr-receipt-frame { width: 100%; border-collapse: collapse; }

            .tr-receipt-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                border-bottom: 3px solid #1a1a1a;
                padding-bottom: 12px;
                margin-bottom: 14px;
            }
            .tr-receipt-header img { max-height: 44px; }
            .tr-receipt-title {
                text-align: right;
                font-size: 18px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .04em;
            }
            .tr-receipt-title small { display: block; font-size: 10.5px; font-weight: 400; text-transform: none; letter-spacing: 0; color: #666; }

            .tr-receipt-idbar {
                width: 100%;
                border-collapse: collapse;
                background: <?= $scheme['gradient'] ?>;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border: none;
                border-radius: 4px;
                margin-bottom: 16px;
            }
            .tr-receipt-idbar td { padding: 10px 16px; }
            .tr-receipt-idbar .tr-receipt-idlabel { color: rgba(<?= $schemeTextRgb ?>,.75); }
            .tr-receipt-idbar .tr-receipt-idvalue { color: <?= $schemeText ?>; }
            .tr-receipt-idlabel { font-size: 9.5px; text-transform: uppercase; letter-spacing: .06em; color: #777; margin-bottom: 2px; }
            .tr-receipt-idvalue { font-size: 19px; font-weight: 700; letter-spacing: .03em; font-family: 'Courier New', monospace; }
            .tr-receipt-idbar .tr-receipt-status { border-color: <?= $schemeText ?>; color: <?= $schemeText ?>; }
            .tr-receipt-status {
                display: inline-block;
                border: 1.5px solid #1a1a1a;
                padding: 3px 12px;
                border-radius: 12px;
                font-weight: 700;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .03em;
            }

            .tr-receipt-cols { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
            .tr-receipt-cols td { width: 50%; vertical-align: top; padding: 0 14px 14px 0; }
            .tr-receipt-section { margin-bottom: 14px; }
            .tr-receipt-section h4 {
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: .07em;
                color: #777;
                border-bottom: 1px solid #ccc;
                padding-bottom: 5px;
                margin: 0 0 6px;
            }
            .tr-receipt-section p { margin: 0 0 2px; font-size: 13px; }

            .tr-receipt-meta { width: 100%; border-collapse: collapse; font-size: 12.5px; }
            .tr-receipt-meta td { padding: 3px 0; }
            .tr-receipt-meta td:nth-child(odd) { color: #777; width: 90px; }
            .tr-receipt-meta td:nth-child(even) { font-weight: 600; padding-right: 20px; }

            .tr-receipt-history { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 4px; }
            .tr-receipt-history th, .tr-receipt-history td { border: 1px solid #ccc; padding: 7px 10px; text-align: left; }
            .tr-receipt-history th { background: #f4f4f5; text-transform: uppercase; font-size: 10px; letter-spacing: .04em; color: #555; }

            .tr-receipt-footer {
                margin-top: 20px;
                border-top: 1px solid #ccc;
                padding-top: 10px;
                text-align: center;
                font-size: 10.5px;
                color: #888;
            }

            .tr-receipt + .tr-receipt { page-break-before: always; }
        }
    </style>
</head>

<body>
    <div class="tr-topbar d-print-none">
        <div class="container">
            <div class="row align-items-center gy-2">
                <div class="col-12 col-md-auto">
                    <a href="../index.php">
                        <img src="img/<?= htmlspecialchars($siteRow['image'] ?? '') ?>" alt="<?= $pageTitle ?>">
                    </a>
                </div>
                <div class="col-12 col-md-auto ms-md-auto d-flex align-items-center gap-3 flex-wrap">
                    <div class="tr-translator">
                        <?php $row = $siteRow; include __DIR__ . '/translator.php'; ?>
                    </div>
                    <a href="../index.php" class="btn tr-back-btn">
                        <span class="tr-back-icon"><i class="bi bi-arrow-left"></i></span>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="max-width:1200px; margin-top:40px; margin-bottom:60px;">

        <?php if (!$searched): ?>

            <div class="tr-card tr-card-body text-center py-5 d-print-none">
                <i class="bi bi-search" style="font-size:2.5rem;color:#d5d5d5;"></i>
                <h4 class="mt-3">No search performed</h4>
                <p class="text-muted">Enter a tracking number on the tracking page to see results here.</p>
                <a href="../tracking.php" class="btn tr-print-btn text-white mt-2">Go to Tracking Page</a>
            </div>

        <?php elseif (empty($trackingRows)): ?>

            <div class="tr-card tr-card-body text-center py-5 d-print-none">
                <i class="bi bi-exclamation-circle" style="font-size:2.5rem;color:#d5d5d5;"></i>
                <h4 class="mt-3">No results found</h4>
                <p class="text-muted">We couldn't find a parcel matching "<?= htmlspecialchars($search) ?>".
                    Please double-check the tracking number and try again.</p>
                <a href="../tracking.php" class="btn tr-print-btn text-white mt-2">
                    <i class="bi bi-search me-1"></i>Try a New Search
                </a>
            </div>

        <?php else: $primary = $trackingRows[0]; ?>

            <div id="tracking-loading" class="tr-preloader d-print-none">
                <div class="tr-preloader-ring">
                    <span class="tr-preloader-pulse"></span>
                    <span class="tr-preloader-pulse delay"></span>
                    <i class="bi bi-box-seam"></i>
                </div>
                <h5 class="mb-0">Fetching shipment details&hellip;</h5>
                <div class="tr-preloader-steps">
                    <div class="step"><i class="bi bi-check2"></i>Connecting to courier network</div>
                    <div class="step"><i class="bi bi-check2"></i>Verifying tracking number <?= htmlspecialchars($primary['cid']) ?></div>
                    <div class="step"><i class="bi bi-check2"></i>Loading records for <strong><?= htmlspecialchars($primary['name']) ?></strong></div>
                </div>
            </div>

            <div id="tracking-result" style="display:none;">
                <?php foreach ($trackingRows as $t): $history = shipmentHistory($t); ?>

                    <!-- On-screen interactive view -->
                    <div class="d-print-none">

                        <div class="tr-hero mb-4">
                            <div class="tr-hero-top row align-items-start gy-3">
                                <div class="col-12 col-sm">
                                    <div class="tr-hero-label">Tracking Number</div>
                                    <div class="tr-hero-cid"><?= htmlspecialchars($t['cid']) ?></div>
                                </div>
                                <div class="col-12 col-sm-auto">
                                    <span class="tr-hero-status"><?= htmlspecialchars($t['rmk']) ?></span>
                                </div>
                            </div>

                            <div class="tr-hero-track">
                                <?php foreach (trackerSteps($t['rmk'], $siteRow) as $step): ?>
                                    <div class="step <?= $step['active'] ? 'active' : '' ?>">
                                        <span class="icon"><i class="bi <?= $step['icon'] ?>"></i></span>
                                        <span class="text"><?= htmlspecialchars($step['label']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="tr-split mb-4">
                            <div class="tr-col-40">
                                <div class="tr-bento">
                                    <div class="tr-info-section">
                                        <span class="tr-icon-badge"><i class="bi bi-send"></i></span>
                                        <div class="tr-bento-label">Sender</div>
                                        <div class="tr-value"><?= htmlspecialchars($t['remark']) ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($t['rank2']) ?></div>
                                    </div>
                                    <div class="tr-info-section">
                                        <span class="tr-icon-badge"><i class="bi bi-person-check"></i></span>
                                        <div class="tr-bento-label">Receiver</div>
                                        <div class="tr-value"><?= htmlspecialchars($t['name']) ?></div>
                                        <div class="text-muted small"><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($t['phone']) ?></div>
                                        <div class="text-muted small"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($t['mail']) ?></div>
                                    </div>
                                    <div class="tr-info-section">
                                        <span class="tr-icon-badge"><i class="bi bi-geo-alt"></i></span>
                                        <div class="tr-bento-label">Destination</div>
                                        <div class="tr-value"><?= htmlspecialchars($t['rank']) ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="tr-col-60">
                                <div class="tr-bento mb-3">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-12 col-md-3">
                                            <img src="img/<?= htmlspecialchars($t['image']) ?>" class="tr-parcel-img" alt="Parcel">
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <div class="tr-bento-label mb-3">Parcel Details</div>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="tr-stat-tile">
                                                        <span class="tr-icon-badge"><i class="bi bi-box-seam"></i></span>
                                                        <div>
                                                            <div class="tr-stat-value"><?= htmlspecialchars($t['type']) ?></div>
                                                            <div class="tr-stat-label">Content</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="tr-stat-tile">
                                                        <span class="tr-icon-badge"><i class="bi bi-speedometer2"></i></span>
                                                        <div>
                                                            <div class="tr-stat-value"><?= htmlspecialchars($t['dur']) ?></div>
                                                            <div class="tr-stat-label">Weight</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="tr-stat-tile">
                                                        <span class="tr-icon-badge"><i class="bi bi-receipt"></i></span>
                                                        <div>
                                                            <div class="tr-stat-value"><?= htmlspecialchars($t['paydate']) ?></div>
                                                            <div class="tr-stat-label">Duty Fees</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tr-bento" style="padding:0; overflow:hidden;">
                                    <div class="d-flex align-items-center gap-2" style="padding:20px 22px 12px;">
                                        <span class="tr-icon-badge" style="margin-bottom:0;"><i class="bi bi-clock-history"></i></span>
                                        <strong>Shipment History</strong>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table tr-history mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($history)): ?>
                                                    <tr><td colspan="3" class="text-center text-muted py-3">No history recorded yet.</td></tr>
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
                        </div>
                            </div>
                            <!-- /.tr-col-60 -->
                        </div>
                        <!-- /.tr-split -->

                        <div class="text-center pb-4">
                            <a href="receipt-pdf.php?cid=<?= urlencode($primary['cid']) ?>" class="btn tr-print-btn text-white px-4">
                                <i class="bi bi-file-earmark-pdf me-1"></i>Download Receipt (PDF)
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <!-- Print-only receipts: independent of the on-screen preloader/reveal above so
                 printing still works even before the JS timer fires (or if JS fails). -->
            <?php foreach ($trackingRows as $t): $history = shipmentHistory($t); ?>
                <div class="tr-receipt">
                    <table class="tr-receipt-frame">
                        <tr>
                            <td>
                                <div class="tr-receipt-header">
                                    <img src="img/<?= htmlspecialchars($siteRow['image'] ?? '') ?>" alt="<?= $pageTitle ?>">
                                    <div class="tr-receipt-title">
                                        Shipping Receipt
                                        <small><?= htmlspecialchars($siteRow['addr'] ?? '') ?></small>
                                        <small><?php
                                            $contact = array_filter([$siteRow['phone'] ?? '', $siteRow['email'] ?? '']);
                                            echo implode(' &middot; ', array_map('htmlspecialchars', $contact));
                                        ?></small>
                                    </div>
                                </div>

                                <table class="tr-receipt-idbar">
                                    <tr>
                                        <td>
                                            <div class="tr-receipt-idlabel">Tracking Number</div>
                                            <div class="tr-receipt-idvalue"><?= htmlspecialchars($t['cid']) ?></div>
                                        </td>
                                        <td class="text-end">
                                            <div class="tr-receipt-idlabel">Status</div>
                                            <span class="tr-receipt-status"><?= htmlspecialchars($t['rmk']) ?></span>
                                        </td>
                                    </tr>
                                </table>

                                <table class="tr-receipt-cols">
                                    <tr>
                                        <td>
                                            <div class="tr-receipt-section">
                                                <h4>Ship From</h4>
                                                <p><strong><?= htmlspecialchars($t['remark']) ?></strong></p>
                                                <p><?= htmlspecialchars($t['rank2']) ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="tr-receipt-section">
                                                <h4>Ship To</h4>
                                                <p><strong><?= htmlspecialchars($t['name']) ?></strong></p>
                                                <p><?= htmlspecialchars($t['rank']) ?></p>
                                                <p><?= htmlspecialchars($t['phone']) ?> &middot; <?= htmlspecialchars($t['mail']) ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <div class="tr-receipt-section">
                                    <h4>Package Details</h4>
                                    <table class="tr-receipt-meta">
                                        <tr><td>Content</td><td><?= htmlspecialchars($t['type']) ?></td><td>Weight</td><td><?= htmlspecialchars($t['dur']) ?></td></tr>
                                        <tr><td>Duty Fees</td><td><?= htmlspecialchars($t['paydate']) ?></td><td>Date Issued</td><td><?= htmlspecialchars($t['cdt'] ?: date('Y-m-d')) ?></td></tr>
                                    </table>
                                </div>

                                <div class="tr-receipt-section">
                                    <h4>Shipment History</h4>
                                    <table class="tr-receipt-history">
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

                                <div class="tr-receipt-footer">
                                    Thank you for shipping with <?= htmlspecialchars($siteRow['name'] ?? '') ?>.
                                    This is a system-generated receipt &mdash; printed <?= date('F j, Y, g:i a') ?>.
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
                var loading = document.getElementById('tracking-loading');
                var result = document.getElementById('tracking-result');
                if (!loading || !result) return;
                setTimeout(function () {
                    loading.style.transition = 'opacity .3s';
                    loading.style.opacity = '0';
                    setTimeout(function () {
                        loading.style.display = 'none';
                        result.style.display = 'block';
                        result.style.opacity = '0';
                        result.style.transition = 'opacity .4s';
                        requestAnimationFrame(function () { result.style.opacity = '1'; });
                    }, 300);
                }, 3000);
            });
            </script>

        <?php endif; ?>

    </div>

    <div class="d-print-none"><?= $siteRow['tawk'] ?? '' ?></div>
</body>

</html>
