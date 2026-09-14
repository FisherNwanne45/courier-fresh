<?php
/**
 * Shared renderer for the 9 individual industry pages linked from the
 * Services dropdown (renewable-energy.php, retail-ecommerce.php, etc).
 * Each of those files just sets $industryKey and includes this file, so
 * all 9 pages share one layout and one content table instead of
 * duplicating markup nine times.
 */

$industries = [
    'renewable-energy' => [
        'label' => 'Renewable Energy',
        'intro' => 'Time-sensitive logistics for wind, solar and hydro projects -- from oversized turbine components to sensitive electrical equipment.',
        'features' => [
            'Oversized and heavy-lift component transport',
            'Route surveys and permitting for abnormal loads',
            'Careful handling for sensitive electrical equipment',
        ],
    ],
    'retail-ecommerce' => [
        'label' => 'Retail & E-commerce',
        'intro' => 'Order fulfillment, returns handling and last-mile delivery built for online retailers and multi-location retail chains.',
        'features' => [
            'Pick, pack and ship order fulfillment',
            'Returns handling and reverse logistics',
            'Scheduled store replenishment across multiple locations',
        ],
    ],
    'energy-oil-gas' => [
        'label' => 'Energy and Oil & Gas',
        'intro' => 'Compliant transport of equipment and materials for energy projects, including hazardous-goods documentation and handling.',
        'features' => [
            'Hazardous-goods documentation and compliant handling',
            'Heavy equipment and drilling-component transport',
            'Remote-site delivery coordination',
        ],
    ],
    'healthcare-pharma' => [
        'label' => 'Healthcare & Pharmaceuticals',
        'intro' => 'Compliant, temperature-aware handling for medical devices, pharmaceuticals and healthcare shipments.',
        'features' => [
            'Temperature-controlled handling where required',
            'Compliant documentation for healthcare shipments',
            'Priority and time-critical delivery options',
        ],
    ],
    'fashion-textiles' => [
        'label' => 'Fashion and Textiles',
        'intro' => 'Seasonal, time-sensitive distribution for fashion and textile brands, from raw materials to finished goods.',
        'features' => [
            'Seasonal peak-capacity planning',
            'Careful handling for garments and delicate materials',
            'Multi-location distribution to stores and warehouses',
        ],
    ],
    'aerospace-defense' => [
        'label' => 'Aerospace and Defense',
        'intro' => 'Secure, precision logistics for aerospace components and defense-sector shipments, including AOG-ready response.',
        'features' => [
            'AOG (aircraft-on-ground) rapid response',
            'Secure chain-of-custody for sensitive cargo',
            'Specialized handling for precision components',
        ],
    ],
    'forestry-paper' => [
        'label' => 'Forestry and Paper',
        'intro' => 'Bulk and break-bulk transport for timber, pulp and paper products, from mill to port to final destination.',
        'features' => [
            'Bulk and break-bulk freight handling',
            'Weather-protected transport and storage',
            'Port-to-mill and mill-to-market coordination',
        ],
    ],
    'sports-entertainment' => [
        'label' => 'Sports and Entertainment',
        'intro' => 'Time-critical logistics for touring equipment, event production gear and sports merchandise.',
        'features' => [
            'Time-critical delivery for tour and event schedules',
            'Careful handling for production and staging equipment',
            'Coordinated multi-stop delivery routes',
        ],
    ],
    'agriculture' => [
        'label' => 'Agriculture',
        'intro' => 'Refrigerated and time-sensitive transport for agricultural goods, from farm to processor to retailer.',
        'features' => [
            'Refrigerated container handling',
            'Compliance with agricultural transport regulations',
            'Time-sensitive delivery to preserve freshness',
        ],
    ],
];

$industry = $industries[$industryKey] ?? null;
if (!$industry) {
    http_response_code(404);
    $pageTitle = 'Not Found';
    include __DIR__ . '/header.php';
    echo '<main class="container" style="padding:100px 0;text-align:center;"><h2>Page not found</h2></main>';
    include __DIR__ . '/footer.php';
    return;
}

$relatedKeys = array_slice(array_diff(array_keys($industries), [$industryKey]), 0, 3);

$pageTitle = $industry['label'];
$pageDescription = strip_tags($industry['intro']);
include __DIR__ . '/header.php';
?>
    <!-- header Section End-->

    <div class="breadcrumb-section mb-120">
        <div class="container">
            <div class="breadcrumb-content pb-60">
                <h1><?= htmlspecialchars($industry['label']) ?></h1>
                <ul class="breadcrumb-list">
                    <li>
                        <a href="index.php">Home</a>
                        <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M11.0636 6.58864L8.00264 12.8892C7.96567 12.9557 7.89913 13 7.8178 13H2.11415C1.96628 13 1.87017 12.8449 1.92931 12.7119L4.90894 6.58864C4.93851 6.52955 4.93851 6.47046 4.90894 6.41136L1.9441 0.288068C1.87756 0.155114 1.97368 0 2.12894 0H7.83259C7.90652 0 7.98046 0.0443182 8.01743 0.110795L11.0784 6.41136C11.0932 6.47046 11.0932 6.52955 11.0636 6.58864Z" />
                            </g>
                        </svg>
                    </li>
                    <li><a href="services.php">Services</a></li>
                    <li><?= htmlspecialchars($industry['label']) ?></li>
                </ul>
            </div>
        </div>
        <div class="breadcrumb-img">
            <img src="themes/theme3/assets/img/innerpages/industries1-breadcrumb-bg-img.jpg" alt="">
        </div>
    </div>

    <div class="container" style="padding:80px 0;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="font-md" style="font-size:18px; line-height:1.7; margin-bottom:30px;"><?= htmlspecialchars($industry['intro']) ?></p>
                <ul style="list-style:none; padding:0; margin:0 0 40px;">
                    <?php foreach ($industry['features'] as $feature): ?>
                        <li style="padding:12px 0; border-bottom:1px solid #eee; font-size:16px;">
                            <i class="bi bi-check2-circle" style="color:var(--primary-color1, #3655ff); margin-right:10px;"></i>
                            <?= htmlspecialchars($feature) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="primary-btn2 btn-hover" href="contact.php" style="margin-bottom:40px;">
                    Request a Quote
                    <span></span>
                </a>
            </div>
        </div>

        <?php if (!empty($relatedKeys)): ?>
        <div class="row justify-content-center mt-90">
            <div class="col-lg-10">
                <h3 class="mb-30">Other Industries We Serve</h3>
                <div class="row g-4">
                    <?php foreach ($relatedKeys as $key): $ind = $industries[$key]; ?>
                        <div class="col-md-4">
                            <a href="<?= htmlspecialchars($key) ?>.php" style="display:block; padding:24px; border:1px solid #eee; border-radius:12px; text-decoration:none; color:inherit;">
                                <strong style="font-size:16px;"><?= htmlspecialchars($ind['label']) ?></strong>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

<?php include __DIR__ . '/footer.php'; ?>
