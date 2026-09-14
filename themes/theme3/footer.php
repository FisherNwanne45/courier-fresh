<?php
/** @var array $row Site settings row, set in config.php via header.php */
?>
    <footer class="footer-section style-3">
        <div class="container">
            <div class="company-logo-and-contact-area">
                <div class="row gy-5">
                    <div class="col-lg-4">
                        <div class="footer-logo-and-social">
                            <div class="logo-area">
                                <a href="index.php"><img src="resources/img/<?= htmlspecialchars($row['image2']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:60px;"></a>
                            </div>
                            <p><?= htmlspecialchars($row['addr']) ?></p>
                            <ul class="social-list">
                                <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                <li><a href="#"><i class="bx bxl-instagram-alt"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="contact-area">
                            <h2>We are <?= htmlspecialchars($row['name']) ?>.</h2>
                            <ul class="mail-and-call">
                                <li>
                                    <div class="icon">
                                        <img src="themes/theme3/assets/img/home1/icon/footer-mail.svg" alt="">
                                    </div>
                                    <div class="content">
                                        <p>Send Us Mail</p>
                                        <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <img src="themes/theme3/assets/img/home1/icon/footer-call-icon.svg" alt="">
                                    </div>
                                    <div class="content">
                                        <p>Collaborate!</p>
                                        <a href="tel:<?= htmlspecialchars($row['phone']) ?>"><?= htmlspecialchars($row['phone']) ?></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-menu">
            <div class="container">
                <div class="row gy-5 justify-content-between">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h3><?= htmlspecialchars($row['name']) ?></h3>
                            </div>
                            <p class="text-white-50 small mb-0"><?= htmlspecialchars($row['name']) ?> fuses a global network with deep expertise in air, ocean and road freight, plus secure logistics and warehousing.</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 d-flex justify-content-lg-start justify-content-md-center justify-content-sm-center">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h3>Company</h3>
                            </div>
                            <ul class="widget-list">
                                <li><a href="about.php">About Company</a></li>
                                <li><a href="history.php">Our History</a></li>
                                <li><a href="global-network.php">Global Network</a></li>
                                <li><a href="faqs.php">FAQ's</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-lg-center justify-content-md-end">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h3>Services</h3>
                            </div>
                            <ul class="widget-list">
                                <li><a href="services.php">Our Services</a></li>
                                <li><a href="shipment.php">Shipment</a></li>
                                <li><a href="global-network.php">Global Network</a></li>
                                <li><a href="tracking.php">Track &amp; Trace</a></li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="col-xl-2 col-lg-2 col-md-4 col-sm-6 d-flex justify-content-lg-end justify-content-md-start justify-content-sm-center">
                        <div class="footer-widget">
                            <div class="widget-title">
                                <h3>Support</h3>
                            </div>
                            <ul class="widget-list">
                                <li><a href="contact.php">Request a quote</a></li>
                                <li><a href="terms.php">Terms &amp; Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?= htmlspecialchars($row['year']) ?> <?= htmlspecialchars($row['name']) ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="themes/theme3/assets/js/jquery-3.7.1.min.js"></script>
    <script src="themes/theme3/assets/js/jquery-ui.js"></script>
    <script src="themes/theme3/assets/js/moment.min.js"></script>
    <script src="themes/theme3/assets/js/daterangepicker.min.js"></script>
    <script src="themes/theme3/assets/js/bootstrap.min.js"></script>
    <script src="themes/theme3/assets/js/popper.min.js"></script>
    <script src="themes/theme3/assets/js/swiper-bundle.min.js"></script>
    <script src="themes/theme3/assets/js/slick.js"></script>
    <script src="themes/theme3/assets/js/waypoints.min.js"></script>
    <script src="themes/theme3/assets/js/jquery.counterup.min.js"></script>
    <script src="themes/theme3/assets/js/wow.min.js"></script>
    <script src="themes/theme3/assets/js/gsap.min.js"></script>
    <script src="themes/theme3/assets/js/ScrollTrigger.min.js"></script>
    <script src="themes/theme3/assets/js/jquery.fancybox.min.js"></script>
    <script src="themes/theme3/assets/js/select-dropdown.js"></script>
    <script src="themes/theme3/assets/js/custom.js"></script>
    <div class="d-print-none"><?= $row['tawk'] ?? '' ?></div>
</body>

</html>
