<?php
$pageTitle = "Track Your Parcel";
$pageDescription = "Track the status of your shipment.";
include __DIR__ . '/header.php';
?>

    <!-- header Section End-->

    <!-- Breadcrumb Section Start -->
    <div class="breadcrumb-section mb-70">
        <div class="container">
            <div class="breadcrumb-content">
                <h1>Track & Trace</h1>
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
                    <li>Track & Trace</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Tracking Shipment Start -->
    <div class="tracking-shipment mb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="tracking-shipment-wrapper">
                        <div class="tag-and-line">
                            <h4>Tracking Your Shipment</h4>
                            <svg height="6" viewBox="0 0 732 6" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM727 3.5L732 5.88675V0.113249L727 2.5V3.5ZM4.5 3.5H727.5V2.5H4.5V3.5Z" />
                            </svg>
                        </div>
                        <div class="form-inner">
                            <form action="resources/track-result.php" method="post" name="form" id="form">
                                <label>Your Tracking Id</label>
                                <div class="field-set">
                                    <input type="text" name="search" id="search" placeholder="7890123456" required>
                                    <input type="hidden" name="dropdown" value="cid">
                                    <button class="primary-btn2 two btn-hover" type="submit" name="Submit">
                                        Track Shipment
                                        <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path
                                                    d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                            </g>
                                        </svg>
                                        <span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tracking-list-wrapper">
                            <h5>How to Use Track & Trace:</h5>
                            <ul class="tracking-list">
                                <li class="single-tracking">
                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path
                                                d="M0 5.24991V12.2499C0 12.482 0.0921872 12.7045 0.256282 12.8686C0.420376 13.0327 0.642936 13.1249 0.875 13.1249H3.5V4.37491H0.875C0.642936 4.37491 0.420376 4.46709 0.256282 4.63119C0.0921872 4.79528 0 5.01784 0 5.24991ZM12.3839 5.24991H9.8C9.72375 5.25051 9.64871 5.23081 9.58259 5.19283C9.51646 5.15485 9.46164 5.09995 9.42375 5.03378C9.38438 4.96847 9.36307 4.89387 9.36199 4.81761C9.36091 4.74135 9.38011 4.66618 9.41762 4.59978L10.3285 2.95916C10.5289 2.59953 10.549 2.17691 10.3854 1.79978C10.3058 1.61457 10.1844 1.45036 10.0306 1.32008C9.87674 1.1898 9.69478 1.09702 9.499 1.04903L8.85675 0.888031C8.77971 0.868587 8.69882 0.870535 8.62281 0.893663C8.54679 0.916791 8.47853 0.960224 8.42537 1.01928L4.93675 4.89553C4.57518 5.29704 4.37506 5.81821 4.375 6.35853V10.9374C4.375 12.1432 5.35675 13.1249 6.5625 13.1249H10.9148C11.394 13.124 11.8598 12.966 12.2408 12.6753C12.6218 12.3845 12.897 11.9769 13.0244 11.5149L13.9589 7.22916C14.0132 6.99229 14.0134 6.74624 13.9595 6.50928C13.9057 6.27232 13.7992 6.05053 13.6478 5.86038C13.4965 5.67023 13.3043 5.51661 13.0855 5.41093C12.8667 5.30524 12.6269 5.25021 12.3839 5.24991Z"/>
                                        </g>
                                    </svg>
                                    <p><span>Courier Services:</span> Enter the tracking number on the courier’s website (e.g., FedEx, DHL, UPS, or local postal service).</p>
                                </li>
                                <li class="single-tracking">
                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path
                                                d="M0 5.24991V12.2499C0 12.482 0.0921872 12.7045 0.256282 12.8686C0.420376 13.0327 0.642936 13.1249 0.875 13.1249H3.5V4.37491H0.875C0.642936 4.37491 0.420376 4.46709 0.256282 4.63119C0.0921872 4.79528 0 5.01784 0 5.24991ZM12.3839 5.24991H9.8C9.72375 5.25051 9.64871 5.23081 9.58259 5.19283C9.51646 5.15485 9.46164 5.09995 9.42375 5.03378C9.38438 4.96847 9.36307 4.89387 9.36199 4.81761C9.36091 4.74135 9.38011 4.66618 9.41762 4.59978L10.3285 2.95916C10.5289 2.59953 10.549 2.17691 10.3854 1.79978C10.3058 1.61457 10.1844 1.45036 10.0306 1.32008C9.87674 1.1898 9.69478 1.09702 9.499 1.04903L8.85675 0.888031C8.77971 0.868587 8.69882 0.870535 8.62281 0.893663C8.54679 0.916791 8.47853 0.960224 8.42537 1.01928L4.93675 4.89553C4.57518 5.29704 4.37506 5.81821 4.375 6.35853V10.9374C4.375 12.1432 5.35675 13.1249 6.5625 13.1249H10.9148C11.394 13.124 11.8598 12.966 12.2408 12.6753C12.6218 12.3845 12.897 11.9769 13.0244 11.5149L13.9589 7.22916C14.0132 6.99229 14.0134 6.74624 13.9595 6.50928C13.9057 6.27232 13.7992 6.05053 13.6478 5.86038C13.4965 5.67023 13.3043 5.51661 13.0855 5.41093C12.8667 5.30524 12.6269 5.25021 12.3839 5.24991Z"/>
                                        </g>
                                    </svg>
                                    <p><span>E-commerce Platforms:</span> Check the order tracking page for delivery updates.</p>
                                </li>
                                <li class="single-tracking">
                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path
                                                d="M0 5.24991V12.2499C0 12.482 0.0921872 12.7045 0.256282 12.8686C0.420376 13.0327 0.642936 13.1249 0.875 13.1249H3.5V4.37491H0.875C0.642936 4.37491 0.420376 4.46709 0.256282 4.63119C0.0921872 4.79528 0 5.01784 0 5.24991ZM12.3839 5.24991H9.8C9.72375 5.25051 9.64871 5.23081 9.58259 5.19283C9.51646 5.15485 9.46164 5.09995 9.42375 5.03378C9.38438 4.96847 9.36307 4.89387 9.36199 4.81761C9.36091 4.74135 9.38011 4.66618 9.41762 4.59978L10.3285 2.95916C10.5289 2.59953 10.549 2.17691 10.3854 1.79978C10.3058 1.61457 10.1844 1.45036 10.0306 1.32008C9.87674 1.1898 9.69478 1.09702 9.499 1.04903L8.85675 0.888031C8.77971 0.868587 8.69882 0.870535 8.62281 0.893663C8.54679 0.916791 8.47853 0.960224 8.42537 1.01928L4.93675 4.89553C4.57518 5.29704 4.37506 5.81821 4.375 6.35853V10.9374C4.375 12.1432 5.35675 13.1249 6.5625 13.1249H10.9148C11.394 13.124 11.8598 12.966 12.2408 12.6753C12.6218 12.3845 12.897 11.9769 13.0244 11.5149L13.9589 7.22916C14.0132 6.99229 14.0134 6.74624 13.9595 6.50928C13.9057 6.27232 13.7992 6.05053 13.6478 5.86038C13.4965 5.67023 13.3043 5.51661 13.0855 5.41093C12.8667 5.30524 12.6269 5.25021 12.3839 5.24991Z"/>
                                        </g>
                                    </svg>
                                    <p><span>Logistics Systems:</span> Businesses use integrated software to track shipments.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tracking Shipment End -->

    <!-- Contact Map Section Start -->
    <div class="contact-map-section">
        <iframe src="https://www.google.com/maps?q=<?= urlencode($row['addr']) ?>&amp;output=embed"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- Contact Map Section End -->

    <!-- Footer Section Start -->
    
<?php include __DIR__ . '/footer.php'; ?>
