<?php
$pageTitle = "Terms & Conditions";
$pageDescription = "Terms and conditions for using our services.";
include __DIR__ . '/header.php';
?>

    <!-- header Section End-->

    <!-- Breadcrumb Section Start -->
    <div class="breadcrumb-section mb-70">
        <div class="container">
            <div class="breadcrumb-content">
                <h1>Terms & Conditions</h1>
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
                    <li>Terms & Conditions</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Terms And Conditions Start -->
    <div class="terms-and-conditions-section mb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="terms-and-conditions-top-area text-center">
                        <div class="tag">
                            <h6>Last Updated</h6>
                            <svg width="28" height="6" viewBox="0 0 28 6" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM23 3.5L28 5.88675V0.113249L23 2.5V3.5ZM4.5 3.5H23.5V2.5H4.5V3.5Z" />
                            </svg>
                            <span>02 January, 2025</span>
                        </div>
                        <p>Below is a general template for the terms and conditions of a logistics and transportation
                            company. This document can be customized to suit specific company policies and legal
                            requirements:</p>
                    </div>
                </div>
            </div>
            <div class="line">
                <svg height="6" viewBox="0 0 1320 6" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM1315 3.5L1320 5.88675V0.113249L1315 2.5V3.5ZM4.5 3.5H1315.5V2.5H4.5V3.5Z" />
                </svg>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="terms-conditions-content-wrap">
                        <div class="single-conditions mb-60">
                            <h3>Introduction</h3>
                            <p>Welcome to <?= htmlspecialchars($row['name']) ?>. By using our logistics and transportation services, you agree to
                                abide
                                by the terms and conditions outlined below. Please read them carefully as they govern
                                your
                                use of our services.</p>
                        </div>
                        <div class="single-conditions mb-60">
                            <h3>Shipment Terms</h3>
                            <ul>
                                <li>
                                    <span>Packaging: </span> Customers must ensure that goods are appropriately packaged
                                    to prevent damage during transit.
                                </li>
                                <li>
                                    <span>Documentation: </span> Accurate and complete shipping documentation must be
                                    provided by the customer.
                                </li>
                                <li>
                                    <span>Prohibited Items: </span> Transportation of hazardous, illegal, or restricted
                                    goods is strictly prohibited.
                                </li>
                            </ul>
                        </div>
                        <div class="single-conditions mb-60">
                            <h3>Liability and Insurance</h3>
                            <ul>
                                <li>
                                    <span>Limited Liability: </span> <?= htmlspecialchars($row['name']) ?> is not liable for loss or damage caused by
                                    events beyond our control, such as natural disasters, strikes, or acts of terrorism.
                                </li>
                                <li>
                                    <span>Insurance: </span> Customers are responsible for securing insurance coverage
                                    for their goods unless explicitly agreed upon.
                                </li>
                                <li>
                                    <span>Claims: </span> All claims for loss or damage must be submitted in writing
                                    within specific timeframe, e.g., 14 days of delivery.
                                </li>
                            </ul>
                        </div>
                        <div class="single-conditions mb-60">
                            <h3>Cancellation and Changes</h3>
                            <ul>
                                <li>
                                    <span>Cancellations: </span> Cancellations must be made in writing and may be
                                    subject to cancellation fees.
                                </li>
                                <li>
                                    <span>Changes to Booking: </span> Any modifications to a booking must be approved in
                                    writing and may incur additional charges.
                                </li>
                            </ul>
                        </div>
                        <div class="single-conditions mb-60">
                            <h3>Contact Info</h3>
                            <span>For any questions or concerns regarding these terms and conditions, please contact us
                                at:</span>
                            <div class="contact">
                                <a href="mailto:<?= htmlspecialchars($row['email']) ?>">
                                    <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path
                                                d="M10.3681 8.28906L9.02809 9.63363C8.48469 10.1789 7.52856 10.1907 6.97341 9.63363L5.63331 8.28906L0.820312 13.1177C0.999469 13.2005 1.197 13.25 1.407 13.25H14.5945C14.8045 13.25 15.002 13.2006 15.1811 13.1177L10.3681 8.28906Z" />
                                            <path
                                                d="M14.5938 2H1.40625C1.19625 2 0.998719 2.04944 0.819625 2.13228L5.96266 7.29238C5.963 7.29272 5.96341 7.29278 5.96375 7.29313C5.96396 7.29335 5.9641 7.29363 5.96416 7.29394L7.63644 8.97175C7.81406 9.14938 8.186 9.14938 8.36362 8.97175L10.0356 7.29422C10.0356 7.29422 10.036 7.29347 10.0363 7.29313C10.0363 7.29313 10.0371 7.29272 10.0374 7.29238L15.1803 2.13225C15.0012 2.04938 14.8038 2 14.5938 2ZM0.149562 2.78787C0.056875 2.97531 0 3.18338 0 3.40625V11.8438C0 12.0666 0.0568125 12.2747 0.149531 12.4621L4.97087 7.62516L0.149562 2.78787ZM15.8504 2.78781L11.0292 7.62516L15.8504 12.4622C15.9431 12.2748 16 12.0667 16 11.8438V3.40625C16 3.18331 15.9431 2.97525 15.8504 2.78781Z" />
                                        </g>
                                    </svg>
                                    <span><?= htmlspecialchars($row['email']) ?></span>
                                </a>
                                <a href="tel:<?= htmlspecialchars($row['phone']) ?>">
                                    <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path
                                                d="M14.7161 10.5021C13.7365 10.5021 12.7747 10.3489 11.8633 10.0477C11.4166 9.89539 10.8676 10.0351 10.595 10.3151L8.79598 11.6732C6.70961 10.5595 5.42444 9.27472 4.32595 7.20402L5.64407 5.45186C5.98653 5.10986 6.10936 4.61028 5.96219 4.14153C5.65969 3.22528 5.50603 2.26391 5.50603 1.28391C5.50607 0.575957 4.93011 0 4.2222 0H1.28387C0.575957 0 0 0.575957 0 1.28387C0 9.39843 6.60157 16 14.7161 16C15.424 16 16 15.424 16 14.7161V11.786C16 11.0781 15.424 10.5021 14.7161 10.5021Z" />
                                        </g>
                                    </svg>
                                    <?= htmlspecialchars($row['phone']) ?>
                                </a>
                            </div>
                        </div>
                        <div class="notes-area">
                            <div class="tag-and-icon">
                                <img src="themes/theme3/assets/img/innerpages/icon/notes-area-icon.svg" alt="">
                                <h3>Important Note</h3>
                            </div>
                            <svg height="6" viewBox="0 0 752 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM747 3.5L752 5.88675V0.113249L747 2.5V3.5ZM4.5 3.5H747.5V2.5H4.5V3.5Z"/>
                            </svg>
                            <ul>
                                <li>
                                    Customers are encouraged to review these terms periodically.
                                </li>
                                <li>
                                    This document is a template and may require customization to meet local laws and regulations.
                                </li>
                                <li>
                                    For legal advice, consult a qualified attorney to ensure compliance with applicable laws.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Terms And Conditions End -->

    <!-- Footer Section Start -->
    
<?php include __DIR__ . '/footer.php'; ?>
