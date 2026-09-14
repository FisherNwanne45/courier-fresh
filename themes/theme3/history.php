<?php
$pageTitle = "Our History";
$pageDescription = "The story behind our logistics company.";
include __DIR__ . '/header.php';
?>

    <!-- header Section End-->

    <!-- Breadcrumb Section Start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="breadcrumb-content pb-60">
                <h1>Our History</h1>
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
                    <li>Our History</li>
                </ul>
            </div>
        </div>
        <div class="breadcrumb-img">
            <img src="themes/theme3/assets/img/innerpages/history-breadcrumb-img.jpg" alt="">
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Quatation Start -->
    <div class="quatation-section mb-120 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
        <div class="container">
            <div class="quatation-wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="quatation-wrap">
                            <h2>For over <span>12 decades,</span> <?= htmlspecialchars($row['name']) ?> has remained committed to delivering
                                innovative, reliable, and sustainable logistics solutions.</h2>
                            <img src="themes/theme3/assets/img/innerpages/signature-img.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quatation End -->

    <!-- History Journey Start -->
    <div class="history-journey mb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="history-wrapper mb-70 wow animate fadeInDown" data-wow-delay="200ms"
                        data-wow-duration="1500ms">
                        <div class="century-btn">
                            <span>20th Century</span>
                        </div>
                        <ul class="history-content-list">
                            <li class="single-history">
                                <img src="themes/theme3/assets/img/innerpages/single-history-img1.png" alt="">
                                <div class="tag-and-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9129 11.8746L1.98177 9.16691C0.686154 8.81365 0.662863 8.20321 1.94489 7.79851L21.7168 1.55434C22.3341 1.35927 22.6757 1.7067 22.4816 2.32006L16.2384 22.091C15.8356 23.3663 15.2252 23.3585 14.87 22.0541L12.1613 12.124C12.143 12.0654 12.1107 12.0121 12.0673 11.9687C12.0238 11.9252 11.9715 11.893 11.9129 11.8746Z" />
                                    </svg>
                                    <h4>1980s – Established</h4>
                                </div>
                                <p>The expansion of trade agreements and supply chains leads to the dominance of
                                    maritime shipping in global commerce.</p>
                            </li>
                            <li class="single-history">
                                <img src="themes/theme3/assets/img/innerpages/single-history-img2.png" alt="">
                                <div class="tag-and-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9129 11.8746L1.98177 9.16691C0.686154 8.81365 0.662863 8.20321 1.94489 7.79851L21.7168 1.55434C22.3341 1.35927 22.6757 1.7067 22.4816 2.32006L16.2384 22.091C15.8356 23.3663 15.2252 23.3585 14.87 22.0541L12.1613 12.124C12.143 12.0654 12.1107 12.0121 12.0673 11.9687C12.0238 11.9252 11.9715 11.893 11.9129 11.8746Z" />
                                    </svg>
                                    <h4>1990s – Containerization</h4>
                                </div>
                                <p>Malcolm McLean invents the intermodal shipping container, standardizing cargo
                                    handling and revolutionizing logistics.</p>
                            </li>
                        </ul>
                    </div>
                    <div class="history-wrapper mb-70 wow animate fadeInUp" data-wow-delay="400ms"
                        data-wow-duration="1500ms">
                        <div class="century-btn">
                            <span>21st Century</span>
                        </div>
                        <ul class="history-content-list">
                            <li class="single-history">
                                <img src="themes/theme3/assets/img/innerpages/single-history-img3.png" alt="">
                                <div class="tag-and-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9129 11.8746L1.98177 9.16691C0.686154 8.81365 0.662863 8.20321 1.94489 7.79851L21.7168 1.55434C22.3341 1.35927 22.6757 1.7067 22.4816 2.32006L16.2384 22.091C15.8356 23.3663 15.2252 23.3585 14.87 22.0541L12.1613 12.124C12.143 12.0654 12.1107 12.0121 12.0673 11.9687C12.0238 11.9252 11.9715 11.893 11.9129 11.8746Z" />
                                    </svg>
                                    <h4>2000s – Megaships</h4>
                                </div>
                                <p>Ultra-large container vessels (ULCVs) are introduced, capable of carrying over 20,000
                                    TEUs (Twenty-foot Equivalent Units).</p>
                            </li>
                            <li class="single-history">
                                <img src="themes/theme3/assets/img/innerpages/single-history-img4.png" alt="">
                                <div class="tag-and-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9129 11.8746L1.98177 9.16691C0.686154 8.81365 0.662863 8.20321 1.94489 7.79851L21.7168 1.55434C22.3341 1.35927 22.6757 1.7067 22.4816 2.32006L16.2384 22.091C15.8356 23.3663 15.2252 23.3585 14.87 22.0541L12.1613 12.124C12.143 12.0654 12.1107 12.0121 12.0673 11.9687C12.0238 11.9252 11.9715 11.893 11.9129 11.8746Z" />
                                    </svg>
                                    <h4>2020s – Digital Transformation</h4>
                                </div>
                                <p>Adoption of blockchain, AI, and IoT in maritime logistics enhances efficiency,
                                    transparency, and security.</p>
                            </li>
                            <li class="single-history">
                                <img src="themes/theme3/assets/img/innerpages/single-history-img5.png" alt="">
                                <div class="tag-and-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.9129 11.8746L1.98177 9.16691C0.686154 8.81365 0.662863 8.20321 1.94489 7.79851L21.7168 1.55434C22.3341 1.35927 22.6757 1.7067 22.4816 2.32006L16.2384 22.091C15.8356 23.3663 15.2252 23.3585 14.87 22.0541L12.1613 12.124C12.143 12.0654 12.1107 12.0121 12.0673 11.9687C12.0238 11.9252 11.9715 11.893 11.9129 11.8746Z" />
                                    </svg>
                                    <h4>2023 – Global Supply Chain Recovery</h4>
                                </div>
                                <p>Post-pandemic adjustments drive innovation in resilience and sustainability within
                                    maritime logistics.</p>
                            </li>
                        </ul>
                    </div>
                    <a class="download-pdf wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms"
                        href="themes/theme3/assets/company-desk.pdf" download>
                        <span>Download History</span>
                        <img src="themes/theme3/assets/img/innerpages/icon/pdf-icon.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- History Journey End-->

    <!-- Img Section Start -->
    <div class="home2-company-banner-img seven mb-120"></div>
    <!-- Img Section End -->

    <!-- Faq Section Start -->
    <div class="home4-faq-section mb-120">
        <div class="container">
            <div class="row justify-content-center mb-65 wow animate fadeInDown" data-wow-delay="200ms"
                data-wow-duration="1500ms">
                <div class="col-xxl-6 col-lg-5 col-md-7">
                    <div class="section-title text-center">
                        <h2>Frequently Asked & Questions</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center g-lg-4 gy-5 mb-50">
                <div class="col-xl-8 col-lg-10">
                    <div class="faq-wrap">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms"
                                data-wow-duration="1500ms">
                                <h5 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">What types of cargo can be shipped?</button>
                                </h5>
                                <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        We handle a range of cargo, including <span>general goods, perishables,
                                            hazardous
                                            materials, oversized cargo, and more.</span> Please contact us for specific
                                        requirements.
                                        Email Us - <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow animate fadeInDown" data-wow-delay="400ms"
                                data-wow-duration="1500ms">
                                <h5 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">How long does international shipping
                                        take?</button>
                                </h5>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Shipping time depends on the destination, <span>shipping method (air, sea, or
                                            land),
                                            and customs procedures.</span> On average:
                                        <ul>
                                            <li><span>Air Freight:</span> 3-10 days</li>
                                            <li><span>Ocean Freight:</span> 20-45 days</li>
                                            <li>For an exact estimate, please contact our support team. Email Us - <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow animate fadeInDown" data-wow-delay="600ms"
                                data-wow-duration="1500ms">
                                <h5 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                        aria-controls="flush-collapseThree">What is the difference between FCL and LCL
                                        shipping?</button>
                                </h5>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>
                                            <li><span>FCL (Full Container Load):</span> A single shipper uses the entire
                                                container, ideal for large shipments.</li>
                                            <li><span>LCL (Less than Container Load):</span> Multiple shippers share
                                                space in one container, cost-effective for smaller shipments.</li>
                                            <li>Email Us - <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow animate fadeInDown" data-wow-delay="800ms"
                                data-wow-duration="1500ms">
                                <h5 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFour" aria-expanded="false"
                                        aria-controls="flush-collapseFour">What documents are needed for cargo
                                        shipping?</button>
                                </h5>
                                <div id="flush-collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Commonly required documents include:
                                        <ul>
                                            <li>Bill of Lading / Air Waybill</li>
                                            <li>Commercial Invoice</li>
                                            <li>Packing List</li>
                                            <li>Certificate of Origin</li>
                                            <li>Customs Declaration</li>
                                            <li>Email Us - <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow animate fadeInDown" data-wow-delay="800ms"
                                data-wow-duration="1500ms">
                                <h5 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFive" aria-expanded="false"
                                        aria-controls="flush-collapseFive">What is customs clearance, and how does it
                                        work?</button>
                                </h5>
                                <div id="flush-collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Customs clearance is the process of verifying and approving cargo for entry or
                                        exit in a country. It involves:
                                        <ul>
                                            <li>Submitting shipping documents</li>
                                            <li>Paying duties/taxes</li>
                                            <li>Inspection (if required)</li>
                                            <li>Email Us - <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow animate fadeInDown" data-wow-delay="800ms"
                                data-wow-duration="1500ms">
                                <h5 class="accordion-header" id="flush-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseSix" aria-expanded="false"
                                        aria-controls="flush-collapseSix">How do I update the mobile app to the latest
                                        version?</button>
                                </h5>
                                <div id="flush-collapseSix" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Simply visit your device’s app store (Google Play or Apple App Store), search
                                        for our app, and tap Update. Make sure you have a stable internet connection for
                                        a smooth update.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button-area mt-35 d-flex justify-content-end  wow animate fadeInUp"
                        data-wow-delay="200ms" data-wow-duration="1500ms">
                        <a class="enqiry-btn" href="contact.php">
                            Drop Your Question
                            <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                    stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq Section End -->

    <!-- Footer Section Start -->
    
<?php include __DIR__ . '/footer.php'; ?>
