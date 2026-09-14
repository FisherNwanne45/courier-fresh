<?php
/**
 * Shared renderer for the 12 individual service / industry-expertise pages
 * (sea.php, road.php, air.php, warehouse.php, store.php,
 * diplomatic-bag-and-secure-logistics.php, ecommerce.php, medical.php,
 * retail.php, auto.php, aviation.php, tech.php). Each of those files just
 * sets $topicKey and includes this file, so the 12 pages share one layout
 * and one content table instead of duplicating markup twelve times.
 */

$topics = [
    // --- Services -----------------------------------------------------
    'sea' => [
        'group' => 'service', 'label' => 'Sea / Ocean Freight', 'tag' => 'Ocean Freight',
        'heading' => 'Sea &amp; Ocean Freight Forwarding',
        'intro' => 'Full container load (FCL) and less-than-container load (LCL) ocean freight, port to port or door to door. We work with a vetted network of carriers to move cargo of any size, on schedules that fit your supply chain.',
        'features' => [
            'FCL and LCL booking on major global trade lanes',
            'Port-to-port and door-to-door service',
            'Customs documentation and clearance handled for you',
            'Real-time tracking from origin port to destination',
        ],
        'image' => 'homepage3/service1.png',
    ],
    'road' => [
        'group' => 'service', 'label' => 'Road Transportation', 'tag' => 'Road Freight',
        'heading' => 'Road Transportation',
        'intro' => 'Domestic and cross-border road freight, from full truckload to last-mile delivery. Our road network covers dense urban delivery routes as well as long-haul inter-city and cross-border lanes.',
        'features' => [
            'Full truckload (FTL) and less-than-truckload (LTL) options',
            'Cross-border road freight with customs support',
            'Scheduled and same-day last-mile delivery',
            'Live GPS tracking on every route',
        ],
        'image' => 'homepage3/service3.png',
    ],
    'air' => [
        'group' => 'service', 'label' => 'Air Freight', 'tag' => 'Air Freight',
        'heading' => 'Air Freight Forwarding',
        'intro' => 'IATA-endorsed air forwarding for time-critical and high-value shipments, worldwide. When speed matters most, our air freight network gets your cargo airborne fast and delivered on schedule.',
        'features' => [
            'IATA-endorsed air cargo forwarding',
            'Express and time-definite delivery options',
            'Worldwide airport-to-airport and door-to-door service',
            'Priority handling for high-value and urgent cargo',
        ],
        'image' => 'homepage3/service2.png',
    ],
    'warehouse' => [
        'group' => 'service', 'label' => 'Warehousing', 'tag' => 'Warehousing',
        'heading' => 'Warehousing &amp; Distribution',
        'intro' => 'Secure storage, inventory management and distribution-center operations across our network. Whether you need short-term overflow storage or a long-term fulfillment partner, our facilities are built for it.',
        'features' => [
            'Secure, monitored storage facilities',
            'Inventory management and stock reporting',
            'Pick, pack and distribution-center operations',
            'Flexible short- and long-term storage terms',
        ],
        'image' => 'services/warehouse.png',
    ],
    'store' => [
        'group' => 'service', 'label' => 'Packaging & Storage', 'tag' => 'Packaging & Storage',
        'heading' => 'Packaging &amp; Storage',
        'intro' => 'Custom packaging, kitting and assembly, plus short- and long-term storage for your goods. We protect what you ship and keep it safe until it\'s ready to move.',
        'features' => [
            'Custom packaging built for your product and route',
            'Kitting, assembly and business-insert services',
            'Climate-appropriate storage options',
            'Damage-free handling from pack to pickup',
        ],
        'image' => 'services/train.png',
    ],
    'diplomatic-bag-and-secure-logistics' => [
        'group' => 'service', 'label' => 'Diplomatic Bag & Secure Logistics', 'tag' => 'Secure Logistics',
        'heading' => 'Diplomatic Bag &amp; Secure Logistics',
        'intro' => 'Chain-of-custody, high-security handling for diplomatic pouches and sensitive cargo. Every step is documented and controlled, from pickup to signed delivery.',
        'features' => [
            'Verified chain-of-custody on every movement',
            'Tamper-evident, high-security handling',
            'Dedicated couriers for sensitive and diplomatic cargo',
            'Signed proof of delivery at every handoff',
        ],
        'image' => 'services/ship.png',
    ],

    // --- Industry expertise --------------------------------------------
    'ecommerce' => [
        'group' => 'industry', 'label' => 'E-commerce Logistics', 'tag' => 'E-commerce',
        'heading' => 'E-commerce Logistics',
        'intro' => 'Order fulfillment, returns handling and last-mile delivery built for online retailers. We help e-commerce businesses ship reliably at any volume, from single parcels to full order-fulfillment programs.',
        'features' => [
            'Pick, pack and ship order fulfillment',
            'Returns handling and reverse logistics',
            'Last-mile delivery built for online orders',
            'Volume-based rates that scale with your store',
        ],
        'image' => 'homepage3/service4.png',
    ],
    'medical' => [
        'group' => 'industry', 'label' => 'Medical Device Logistics', 'tag' => 'Medical Device',
        'heading' => 'Medical Device Logistics',
        'intro' => 'Compliant, temperature-aware handling for medical devices and healthcare shipments. We understand the documentation and handling standards this industry requires.',
        'features' => [
            'Temperature-aware handling where required',
            'Careful, compliant documentation for healthcare shipments',
            'Priority and time-critical delivery options',
            'Secure chain-of-custody for sensitive equipment',
        ],
        'image' => 'services/warehouse.png',
    ],
    'retail' => [
        'group' => 'industry', 'label' => 'Retail Logistics', 'tag' => 'Retail',
        'heading' => 'Retail Logistics',
        'intro' => 'Store replenishment and distribution logistics timed to retail demand cycles. We help retailers keep shelves stocked without overcommitting warehouse space.',
        'features' => [
            'Scheduled store replenishment',
            'Distribution timed to seasonal demand',
            'Multi-location delivery coordination',
            'Inventory visibility across your retail network',
        ],
        'image' => 'homepage3/service1.png',
    ],
    'auto' => [
        'group' => 'industry', 'label' => 'Automotive Supply Chain', 'tag' => 'Automotive',
        'heading' => 'Automotive Supply Chain',
        'intro' => 'Just-in-time parts delivery and supply-chain logistics for automotive manufacturing. We keep production lines moving with dependable, scheduled deliveries.',
        'features' => [
            'Just-in-time parts delivery',
            'Scheduled supply-chain logistics for manufacturing',
            'Cross-border parts shipping and customs support',
            'Priority handling to avoid line-down delays',
        ],
        'image' => 'services/train.png',
    ],
    'aviation' => [
        'group' => 'industry', 'label' => 'Aviation & Aerospace Logistics', 'tag' => 'Aviation & Aerospace',
        'heading' => 'Aviation &amp; Aerospace Logistics',
        'intro' => 'AOG-ready, time-critical logistics for aircraft parts and aerospace components. When an aircraft is grounded, every hour counts -- our team is built for that urgency.',
        'features' => [
            'AOG (aircraft-on-ground) rapid response',
            'Time-critical parts and component delivery',
            'Specialized handling for aerospace cargo',
            'Worldwide reach for urgent aviation shipments',
        ],
        'image' => 'homepage3/service2.png',
    ],
    'tech' => [
        'group' => 'industry', 'label' => 'High Tech Logistics', 'tag' => 'High Tech',
        'heading' => 'High Tech Logistics',
        'intro' => 'Secure, insured handling for high-value electronics and technology equipment. From components to finished devices, we ship high-tech cargo with the care it needs.',
        'features' => [
            'Secure handling for high-value electronics',
            'Insured shipping for technology equipment',
            'Anti-static and damage-sensitive packaging options',
            'Tracked, signed delivery on every shipment',
        ],
        'image' => 'services/ship.png',
    ],
];

$topic = $topics[$topicKey] ?? null;
if (!$topic) {
    http_response_code(404);
    $pageTitle = 'Not Found';
    include __DIR__ . '/header.php';
    echo '<main class="main"><div class="container pt-100 pb-100 text-center"><h2>Page not found</h2></div></main>';
    include __DIR__ . '/footer.php';
    return;
}

$siblingKeys = array_keys(array_filter($topics, fn($t) => $t['group'] === $topic['group'] && $t !== $topic));
// Show up to 3 related topics from the same group (services <-> services, industries <-> industries).
$related = array_slice($siblingKeys, 0, 3);

$pageTitle = $topic['label'];
$pageDescription = strip_tags($topic['intro']);
include __DIR__ . '/header.php';
?>
<main class="main">
    <section class="section">
        <div class="container">
            <div class="box-pageheader-1 text-center">
                <span class="btn btn-tag wow animate__animated animate__fadeIn"><?= htmlspecialchars($topic['group'] === 'service' ? 'What we offer' : 'Who we serve') ?></span>
                <h2 class="color-brand-1 mt-15 mb-10 wow animate__animated animate__fadeIn"><?= $topic['heading'] ?></h2>
                <p class="font-md color-white wow animate__animated animate__fadeIn"><?= htmlspecialchars($topic['tag']) ?></p>
            </div>
        </div>
    </section>
    <section class="section mt-60 mb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-30">
                    <img class="w-100 wow animate__animated animate__fadeIn" style="border-radius:12px;" src="themes/theme2/assets/imgs/page/<?= htmlspecialchars($topic['image']) ?>" alt="<?= htmlspecialchars($topic['label']) ?>">
                </div>
                <div class="col-lg-6 mb-30">
                    <p class="font-md color-grey-900 mb-30 wow animate__animated animate__fadeIn"><?= $topic['intro'] ?></p>
                    <ul class="list-unstyled">
                        <?php foreach ($topic['features'] as $feature): ?>
                            <li class="d-flex align-items-start mb-15 wow animate__animated animate__fadeIn">
                                <svg class="icon-16 mr-10 mt-5 color-brand-1 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                </svg>
                                <span class="font-md color-grey-900"><?= htmlspecialchars($feature) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-30"><a class="btn btn-brand-1-big hover-up wow animate__animated animate__fadeIn" href="contact.php">Request a Quote</a></div>
                </div>
            </div>
        </div>
    </section>
    <?php if (!empty($related)): ?>
    <section class="section pt-20 pb-100 bg-grey-50">
        <div class="container">
            <h3 class="color-brand-2 mb-30 wow animate__animated animate__fadeIn"><?= $topic['group'] === 'service' ? 'Related Services' : 'Related Industries' ?></h3>
            <div class="row">
                <?php foreach ($related as $key): $t = $topics[$key]; ?>
                    <div class="col-lg-4 col-md-6 mb-30 wow animate__animated animate__fadeIn">
                        <div class="cardService">
                            <div class="cardImage"><a href="<?= htmlspecialchars($key) ?>.php"><img src="themes/theme2/assets/imgs/page/<?= htmlspecialchars($t['image']) ?>" alt="<?= htmlspecialchars($t['label']) ?>" style="height:220px; object-fit:cover;"></a></div>
                            <div class="cardInfo"><a href="<?= htmlspecialchars($key) ?>.php">
                                <h6 class="color-brand-2"><?= htmlspecialchars($t['label']) ?></h6>
                            </a></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/footer.php'; ?>
