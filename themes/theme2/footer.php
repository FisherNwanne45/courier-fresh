<?php
/** @var array $row Site settings row, set in config.php via header.php */
?>
    <footer class="footer">
        <div class="footer-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 width-23 mb-30">
                        <div class="mb-20"><img src="resources/img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:60px;"></div>
                        <p class="font-xs mb-20 color-white">
                            <?= htmlspecialchars($row['name']) ?> fuses a global network with deep expertise in air freight,
                            ocean freight, road transportation and secure logistics -- plus warehousing, e-commerce
                            fulfillment and value-added services including kitting, assembly and custom packaging.
                        </p>
                        <h6 class="color-brand-1">Follow Us</h6>
                        <div class="mt-15">
                            <a class="icon-socials icon-facebook" href="#" aria-hidden="true"></a>
                            <a class="icon-socials icon-instagram" href="#" aria-hidden="true"></a>
                            <a class="icon-socials icon-twitter" href="#" aria-hidden="true"></a>
                            <a class="icon-socials icon-youtube" href="#" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="col-lg-3 width-16 mb-30">
                        <h5 class="mb-10 color-brand-1">Company</h5>
                        <ul class="menu-footer">
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="workprocess.php">Work Process</a></li>
                            <li><a href="faqs.php">FAQ's</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 width-16 mb-30">
                        <h5 class="mb-10 color-brand-1">Industries</h5>
                        <ul class="menu-footer">
                            <li><a href="ecommerce.php">E-commerce Logistics</a></li>
                            <li><a href="medical.php">Medical Device Logistics</a></li>
                            <li><a href="retail.php">Retail Logistics</a></li>
                            <li><a href="auto.php">Automotive Supply Chain</a></li>
                            <li><a href="aviation.php">Aviation &amp; Aerospace</a></li>
                            <li><a href="tech.php">High Tech Logistics</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 width-20 mb-30">
                        <h5 class="mb-10 color-brand-1">Services</h5>
                        <ul class="menu-footer">
                            <li><a href="sea.php">Sea / Ocean Freight</a></li>
                            <li><a href="road.php">Road Transportation</a></li>
                            <li><a href="air.php">Air Freight</a></li>
                            <li><a href="warehouse.php">Warehousing</a></li>
                            <li><a href="store.php">Packaging &amp; Storage</a></li>
                            <li><a href="diplomatic-bag-and-secure-logistics.php">Diplomatic Bag &amp; Secure</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-2">
            <div class="container">
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 text-center text-lg-start">
                            <span class="color-grey-300 font-md">&copy; <?= htmlspecialchars($row['year']) ?> <?= htmlspecialchars($row['name']) ?>. All rights reserved.</span>
                        </div>
                        <div class="col-lg-6 col-md-12 text-center text-lg-end">
                            <ul class="menu-bottom">
                                <li><a class="font-sm color-grey-300" href="tracking.php">Track Shipment</a></li>
                                <li><a class="font-sm color-grey-300" href="resources">Client Area</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="themes/theme2/assets/js/vendors/modernizr-3.6.0.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/jquery-migrate-3.3.0.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/waypoints.js"></script>
    <script src="themes/theme2/assets/js/vendors/wow.js"></script>
    <script src="themes/theme2/assets/js/vendors/magnific-popup.js"></script>
    <script src="themes/theme2/assets/js/vendors/perfect-scrollbar.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/select2.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/isotope.js"></script>
    <script src="themes/theme2/assets/js/vendors/scrollup.js"></script>
    <script src="themes/theme2/assets/js/vendors/swiper-bundle.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/noUISlider.js"></script>
    <script src="themes/theme2/assets/js/vendors/slider.js"></script>
    <script src="themes/theme2/assets/js/vendors/counterup.js"></script>
    <script src="themes/theme2/assets/js/vendors/jquery.countdown.min.js"></script>
    <script src="themes/theme2/assets/js/vendors/jquery.elevatezoom.js"></script>
    <script src="themes/theme2/assets/js/vendors/slick.js"></script>
    <script src="themes/theme2/assets/js/main28b5.js?v=2.0.0"></script>
    <div class="d-print-none"><?= $row['tawk'] ?? '' ?></div>
</body>

</html>
