<?php
/**
 * The main <ul class="menu-list"> nav, shared by header.php (used on all
 * inner pages) AND included directly inside each homepage variant's own
 * distinct header markup -- so editing the nav (like the Services >
 * Industries dropdown) only has to happen in one place.
 */
?>
                    <ul class="menu-list">
                        <li><a href="index.php" class="drop-down">Home</a></li>
                        <li class="menu-item-has-children">
                            <a href="services.php" class="drop-down">
                                Services
                                <i class="bi bi-caret-down-fill"></i>
                            </a>
                            <i class="bi bi-plus dropdown-icon"></i>
                            <ul class="sub-menu">
                                <li><a href="renewable-energy.php">Renewable Energy</a></li>
                                <li><a href="retail-ecommerce.php">Retail &amp; E-commerce</a></li>
                                <li><a href="energy-oil-gas.php">Energy and Oil &amp; Gas</a></li>
                                <li><a href="healthcare-pharma.php">Healthcare &amp; Pharmaceuticals</a></li>
                                <li><a href="fashion-textiles.php">Fashion and Textiles</a></li>
                                <li><a href="aerospace-defense.php">Aerospace and Defense</a></li>
                                <li><a href="forestry-paper.php">Forestry and Paper</a></li>
                                <li><a href="sports-entertainment.php">Sports and Entertainment</a></li>
                                <li><a href="agriculture.php">Agriculture</a></li>
                            </ul>
                        </li>
                        <li><a href="shipment.php" class="drop-down">Shipment</a></li>
                        <li class="menu-item-has-children">
                            <a href="about.php" class="drop-down">
                                Company
                                <i class="bi bi-caret-down-fill"></i>
                            </a>
                            <i class="bi bi-plus dropdown-icon"></i>
                            <ul class="sub-menu">
                                <li><a href="about.php">About Company</a></li>
                                <li><a href="history.php">Our History</a></li>
                                <li><a href="faqs.php">FAQ's</a></li>
                                <li><a href="global-network.php">Global Network</a></li>
                                <li><a href="terms.php">Terms &amp; Conditions</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.php" class="drop-down">Get In Touch</a></li>
                    </ul>
