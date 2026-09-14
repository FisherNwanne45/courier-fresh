<?php
$pageTitle = "Contact Us";
$pageDescription = "Get in touch with our logistics team.";

// Needs $row (site settings) and sendMailSMTP() -- both come from config.php,
// which header.php requires below. Load it directly here too so this form
// can be processed before the page head is emitted.
require_once __DIR__ . '/../../resources/config.php';

$contactMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tname'])) {
    $cName = trim($_POST['tname'] ?? '');
    $cCompany = trim($_POST['tcompany'] ?? '');
    $cEmail = trim($_POST['temail'] ?? '');
    $cPhone = trim($_POST['tphone'] ?? '');
    $cMessage = trim($_POST['tmessage'] ?? '');

    // The freight-quote-request variant of this form (used on a few pages)
    // has no free-text message box, just goods/weight/dimensions fields --
    // fold those into the message body when present instead of requiring
    // a separate message.
    $extraFields = [
        'tgoods' => 'Type of Goods',
        'tweight' => 'Weight of Shipment',
        'tdimensions' => 'Dimensions',
    ];
    $extraLines = [];
    foreach ($extraFields as $field => $label) {
        $value = trim($_POST[$field] ?? '');
        if ($value !== '') {
            $extraLines[] = "{$label}: {$value}";
        }
    }
    if ($cMessage === '' && !empty($extraLines)) {
        $cMessage = implode("\n", $extraLines);
    }

    if ($cName === '' || !filter_var($cEmail, FILTER_VALIDATE_EMAIL) || $cMessage === '') {
        $contactMessage = '<div class="alert alert-danger">Please fill in your name, a valid email address, and a message.</div>';
    } else {
        $subjectLine = 'New website enquiry from ' . $cName;
        $htmlBody = '<p><strong>From:</strong> ' . htmlspecialchars($cName) . ' &lt;' . htmlspecialchars($cEmail) . '&gt;</p>'
            . ($cCompany !== '' ? '<p><strong>Company:</strong> ' . htmlspecialchars($cCompany) . '</p>' : '')
            . ($cPhone !== '' ? '<p><strong>Phone:</strong> ' . htmlspecialchars($cPhone) . '</p>' : '')
            . '<p><strong>Message:</strong></p><p>' . nl2br(htmlspecialchars($cMessage)) . '</p>';
        $textBody = "From: {$cName} <{$cEmail}>\n" . ($cCompany !== '' ? "Company: {$cCompany}\n" : '') . ($cPhone !== '' ? "Phone: {$cPhone}\n" : '') . "\nMessage:\n{$cMessage}";

        $result = sendMailSMTP($row['email'], $row['name'], $subjectLine, $htmlBody, $textBody);

        $contactMessage = $result['success']
            ? '<div class="alert alert-success">Thanks, ' . htmlspecialchars($cName) . ' -- your message has been sent. We\'ll get back to you soon.</div>'
            : '<div class="alert alert-danger">Sorry, your message could not be sent right now. Please try again later or email us directly at ' . htmlspecialchars($row['email']) . '.</div>';
    }
}

include __DIR__ . '/header.php';
?>

    <!-- header Section End-->

    <!-- Breadcrumb Section Start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="breadcrumb-content pb-60">
                <h1>Get in Touch</h1>
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
                    <li>Get in Touch</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->


    <!-- Home2 Contact Section Start -->
    <div class="home2-contact-section mb-120">
        <div class="container">
            <div class="home2-contact-section-wrap">
                <div class="row gy-5 justify-content-between">
                    <div class="col-xl-5 col-lg-6 wow animate fadeInLeft" data-wow-delay="200ms"
                        data-wow-duration="1500ms">
                        <div class="section-title mb-50">
                            <h2>Get in Touch.</h2>
                        </div>
                        <?php
                        // Branches are admin-configurable in Site Settings -- the
                        // primary office is always shown; branches 2-4 only
                        // appear once an admin fills them in.
                        $officeList = [
                            ['label' => 'Head Office', 'addr' => $row['addr'], 'phone' => $row['phone'], 'email' => $row['email']],
                        ];
                        foreach ([2, 3, 4] as $n) {
                            if (!empty($row['addr' . $n])) {
                                $officeList[] = [
                                    'label' => !empty($row['branch' . $n . '_name']) ? $row['branch' . $n . '_name'] : ('Branch ' . ($n - 1)),
                                    'addr' => $row['addr' . $n],
                                    'phone' => $row['phone' . $n],
                                    'email' => $row['email' . $n],
                                ];
                            }
                        }
                        ?>
                        <ul class="contact-list">
                            <?php foreach ($officeList as $office): ?>
                                <li class="single-contact">
                                    <h3><?= htmlspecialchars($office['label']) ?></h3>
                                    <a href="#"><?= htmlspecialchars($office['addr']) ?></a>
                                    <?php if (!empty($office['phone'])): ?>
                                        <a href="tel:<?= htmlspecialchars($office['phone']) ?>"><?= htmlspecialchars($office['phone']) ?></a>
                                    <?php endif; ?>
                                    <?php if (!empty($office['email'])): ?>
                                        <a href="mailto:<?= htmlspecialchars($office['email']) ?>"><?= htmlspecialchars($office['email']) ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="contact-support">
                            <h6>Instant support</h6>
                            <svg class="line" height="6" viewBox="0 0 84 6" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM79 3.5L84 5.88675V0.113249L79 2.5V3.5ZM4.5 3V3.5H79.5V3V2.5H4.5V3Z" />
                            </svg>

                            <a class="call" href="tel:<?= htmlspecialchars($row['phone']) ?>">
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M14.7161 10.5021C13.7365 10.5021 12.7747 10.3489 11.8633 10.0477C11.4166 9.89539 10.8676 10.0351 10.595 10.3151L8.79598 11.6732C6.70961 10.5595 5.42444 9.27472 4.32595 7.20402L5.64407 5.45186C5.98653 5.10986 6.10936 4.61028 5.96219 4.14153C5.65969 3.22528 5.50603 2.26391 5.50603 1.28391C5.50607 0.575957 4.93011 0 4.2222 0H1.28387C0.575957 0 0 0.575957 0 1.28387C0 9.39843 6.60157 16 14.7161 16C15.424 16 16 15.424 16 14.7161V11.786C16 11.0781 15.424 10.5021 14.7161 10.5021Z" />
                                    </g>
                                </svg>
                                <span><?= htmlspecialchars($row['phone']) ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 wow animate fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="contact-form-wrapper">
                            <?= $contactMessage ?>
                            <form action="contact.php" method="post">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <label>Full Name</label>
                                            <input type="text" name="tname" placeholder="Mr. Daniel Scoot" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <label>Company Name</label>
                                            <input type="text" name="tcompany" placeholder="Your company">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <label>Your Email *</label>
                                            <input type="email" name="temail" placeholder="info@example.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <label>Phone Number</label>
                                            <input type="text" name="tphone" placeholder="+920- 5566 **** ****">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-inner">
                                            <label>Message</label>
                                            <textarea name="tmessage" placeholder="Write your message" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-inner2 two">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="contactCheck22">
                                                <label class="form-check-label" for="contactCheck22">
                                                    I consent to my data being processed according to the privacy policy
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <button class="primary-btn2 btn-hover" type="submit">
                                Request Callback
                                <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z">
                                        </path>
                                    </g>
                                </svg>
                                <span></span>
                            </button>
                            </form>
                        </div>
                    </div>
                    <img src="themes/theme3/assets/img/home2/home2-contact-bg.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Home2 Contact Section End -->

    <!-- Contact Map Section Start -->
    <div class="contact-map-section mb-120">
        <iframe src="https://www.google.com/maps?q=<?= urlencode($row['addr']) ?>&amp;output=embed"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- Contact Map Section End -->

    <!-- Footer Section Start -->

<?php include __DIR__ . '/footer.php'; ?>
