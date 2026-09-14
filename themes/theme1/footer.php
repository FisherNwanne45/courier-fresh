<footer id="footer" class="wrapper clearfix">
    <div class="container">
        <div class="row">
            <div class="footer-wrap row">

                <div class="widget-footer col-md-4">
                    <div class="short-desc">
                        <div class="logo-footer">
                            <img src="resources/img/<?= htmlspecialchars($row['image2']) ?>" width="250px" alt="">
                        </div>

                        <h2 style="color: white;"><?php echo $row['name']; ?> - Providing Smart Logistics
                            Solution Across The World.</h2>

                    </div>
                </div>


                <div class="widget-footer col-md-5">
                    <div class="recent-post">
                        <h4 class="title">Information</h4>
                        <div class="footer-content">
                            <style>
                            .menu-footer-menu {
                                list-style-type: disc;
                                color: white;
                            }

                            .menu-footer-menu a {
                                color: white;
                            }

                            .menu-footer-menu a:hover {
                                color: #333;
                            }
                            </style>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="menu-footer-menu">
                                        <li><a href="index-2">Home</a></li>
                                        <li><a href="about">About Us</a></li>

                                        <li><a href="services">Our Services</a></li>
                                        <li><a href="contact">Contact Us</a></li>
                                        <li> <a href="tracking">Track & Trace</a></li>
                                        <li><a href="medical">Medical Device Logistics</a></li>
                                        <li><a href="auto">Automotive Supply Chain</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="menu-footer-menu">
                                        <li><a href="services">Sea/Ocean Freight</a></li>
                                        <li><a href="services">Road Transportation</a></li>
                                        <li><a href="services">Air Freight</a></li>
                                        <li><a href="services">Warehousing</a></li>
                                        <li><a href="services">Packaging & Storage</a></li>
                                        <li><a href="diplomatic-bag-and-secure-logistics">Diplomatic Bag and
                                                Secure Logistics</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="widget-footer col-md-3">
                    <div class="contact-footer">
                        <h4 class="title">Contact Us</h4>
                        <div class="footer-content">
                            <div class="contact-section" style="font-size: 15px;">
                                <h4><?php echo $row['name']; ?></h4>
                                <?php if (!empty($row['phone'])): ?>
                                <p class="pb-4"><strong>Phone :</strong> <?php echo $row['phone']; ?> </p>
                                <?php endif; ?>
                                <?php if (!empty($row['email'])): ?>
                                <p class="pb-4"><strong>Email : </strong> <?php echo $row['email']; ?> <a
                                        href="mailto:<?php echo $row['email']; ?>"> </a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="contact" class="button-normal white">CONTACT US</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="copyright text-center">
        <div class="container">
            <div class="social-icon">
                <ul>
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                </ul>
            </div>
            <p>
                Copyright &copy; <?php echo $row['year']; ?> <?php echo $row['name']; ?>. All rights
                reserved.
            </p>
        </div>
    </div>
    <div class="footer-menu">
        <a href="contact">Contact Us </a>
        <div class="divider"></div>
        <a href="tracking">Track Shipment </a>
    </div>



    <style>
    /* Back to Top Button */
    #back-to-top {
        position: fixed;
        bottom: 120px;
        right: 20px;
        background-color: #c42031;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 24px;
        text-align: center;
        line-height: 50px;
        cursor: pointer;
        display: none;
        z-index: 9999;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    #back-to-top:hover {
        background-color: #a31828;
    }
    </style>
</footer>
</div>



<script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script type="text/javascript" src="themes/theme1/js/plugin.js"></script>
<script type="text/javascript" src="themes/theme1/js/main.js"></script>
<script type="text/javascript" src="themes/theme1/js/formcalculations.js"></script>



<?php echo $row['tawk']; ?>
</body>
<button id="back-to-top">
    <i class="fa fa-arrow-up"></i>
</button>

<script>
// Show the button when scrolling down
window.onscroll = function() {
    let btn = document.getElementById("back-to-top");
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        btn.style.display = "block";
    } else {
        btn.style.display = "none";
    }
};

// Smooth scroll to top
document.getElementById("back-to-top").addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>

</html>