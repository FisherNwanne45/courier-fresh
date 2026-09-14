<?php
// This file lives at themes/{theme}/header.php -- resources/ is two levels
// up, at the project root, regardless of which theme is active or how this
// page was reached (dispatcher, direct hit, etc.), so resolve it via __DIR__
// rather than a CWD-relative path.
require_once __DIR__ . '/../../resources/config.php';

// Set by the including page before this include; falls back to the site name.
$pageTitle = $pageTitle ?? $row['name'];
$pageDescription = $pageDescription ?? ($row['name'] . ' - global freight, courier and logistics services.');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($row['name']) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($row['url'] ?? '') ?>">
    <meta property="og:image" content="resources/img/<?= htmlspecialchars($row['image']) ?>">
    <link rel="shortcut icon" type="image/x-icon" href="resources/img/<?= htmlspecialchars($row['favicon'] ?? '') ?>">
    <link href="themes/theme2/assets/css/vendors/normalize.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/vendors/bootstrap.min.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/plugins/animate.min.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/plugins/swiper-bundle.min.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/plugins/magnific-popup.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/plugins/perfect-scrollbar.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/plugins/select2.min.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/plugins/slick.css" rel="stylesheet">
    <link href="themes/theme2/assets/css/style28b5.css?v=2.0.0" rel="stylesheet">
    <title><?= htmlspecialchars($pageTitle) ?> &middot; <?= htmlspecialchars($row['name']) ?></title>
    <style>
        /* Theme2's own look for the shared translator widget (see
           resources/translator.php) -- Google's real widget, styled in
           place, to match this dark topbar. Languages come from admin
           Appearance settings. */
        .site-translator .goog-te-gadget-simple,
        .site-translator .site-translator-trigger {
            background-color: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 13px;
            display: inline-block;
            cursor: pointer;
        }
        .site-translator .goog-te-gadget-simple:hover,
        .site-translator .site-translator-trigger:hover {
            border-color: #FEC201;
        }
        .site-translator .goog-te-gadget-simple a,
        .site-translator .goog-te-gadget-simple a span,
        .site-translator .site-translator-trigger a,
        .site-translator .site-translator-trigger a span {
            color: #fff !important;
            text-decoration: none !important;
        }
    </style>
</head>

<body>
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="flip-square"></div>
            </div>
        </div>
    </div>
    <div class="box-bar bg-grey-900">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-8 col-sm-5 col-4">
                    <a class="phone-icon mr-45" href="tel:<?= htmlspecialchars($row['phone']) ?>">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path>
                        </svg>Call Us: <?= htmlspecialchars($row['phone']) ?>
                    </a>
                    <a class="email-icon" href="mailto:<?= htmlspecialchars($row['email']) ?>">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
                        </svg><?= htmlspecialchars($row['email']) ?>
                    </a>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-7 col-8 text-end">
                    <span class="site-translator-wrap d-inline-block align-middle me-3">
                        <?php include __DIR__ . '/../../resources/translator.php'; ?>
                    </span>
                    <a class="icon-socials icon-twitter2" href="#" aria-hidden="true">
                        <svg class="bi bi-twitter" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 16 16"><path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path></svg>
                    </a>
                    <a class="icon-socials icon-facebook2" href="#" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg>
                    </a>
                    <a class="icon-socials icon-instagram2" href="#" aria-hidden="true">
                        <svg class="bi bi-instagram" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <header class="header sticky-bar">
        <div class="container">
            <div class="main-header">
                <div class="header-left">
                    <div class="header-logo">
                        <a class="d-flex" href="index.php">
                            <img alt="<?= htmlspecialchars($row['name']) ?>" src="resources/img/<?= htmlspecialchars($row['image']) ?>" style="max-height:46px;">
                        </a>
                    </div>
                    <div class="header-nav">
                        <nav class="nav-main-menu d-none d-xl-block">
                            <ul class="main-menu">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about.php">About Us</a></li>
                                <li class="has-children"><a href="services.php">Services</a>
                                    <ul class="sub-menu">
                                        <li><a href="sea.php">Sea / Ocean Freight</a></li>
                                        <li><a href="road.php">Road Transportation</a></li>
                                        <li><a href="air.php">Air Freight</a></li>
                                        <li><a href="warehouse.php">Warehousing</a></li>
                                        <li><a href="store.php">Packaging &amp; Storage</a></li>
                                        <li><a href="diplomatic-bag-and-secure-logistics.php">Diplomatic Bag &amp; Secure Logistics</a></li>
                                    </ul>
                                </li>
                                <li class="has-children"><a href="#">Industry Expertise</a>
                                    <ul class="sub-menu">
                                        <li><a href="ecommerce.php">E-commerce Logistics</a></li>
                                        <li><a href="medical.php">Medical Device Logistics</a></li>
                                        <li><a href="retail.php">Retail Logistics</a></li>
                                        <li><a href="auto.php">Automotive Supply Chain</a></li>
                                        <li><a href="aviation.php">Aviation &amp; Aerospace Logistics</a></li>
                                        <li><a href="tech.php">High Tech Logistics</a></li>
                                    </ul>
                                </li>
                                <li class="has-children"><a href="#">Resources</a>
                                    <ul class="sub-menu">
                                        <li><a href="workprocess.php">Work Process</a></li>
                                        <li><a href="faqs.php">FAQ's</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.php">Contact</a></li>
                            </ul>
                        </nav>
                        <div class="burger-icon"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                    </div>
                    <div class="header-right">
                        <div class="d-none d-sm-inline-block">
                            <a class="btn btn-default mr-10 hover-up" href="resources">Client Area</a>
                            <a class="btn btn-brand-1 d-none d-xl-inline-block hover-up" href="tracking.php">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                </svg>Track Shipment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-content-area">
                <div class="mobile-logo">
                    <a class="btn btn-brand-1 hover-up" href="tracking.php">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>Track Shipment</a>
                </div>
                <div class="burger-icon"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                <div class="perfect-scroll">
                    <div class="mobile-menu-wrap mobile-header-border">
                        <nav class="mt-15">
                            <ul class="mobile-menu font-heading">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about.php">About</a></li>
                                <li class="has-children"><a href="services.php">Services</a>
                                    <ul class="sub-menu">
                                        <li><a href="sea.php">Sea / Ocean Freight</a></li>
                                        <li><a href="road.php">Road Transportation</a></li>
                                        <li><a href="air.php">Air Freight</a></li>
                                        <li><a href="warehouse.php">Warehousing</a></li>
                                        <li><a href="store.php">Packaging &amp; Storage</a></li>
                                        <li><a href="diplomatic-bag-and-secure-logistics.php">Diplomatic Bag &amp; Secure Logistics</a></li>
                                    </ul>
                                </li>
                                <li class="has-children"><a href="#">Industry Expertise</a>
                                    <ul class="sub-menu">
                                        <li><a href="ecommerce.php">E-commerce Logistics</a></li>
                                        <li><a href="medical.php">Medical Device Logistics</a></li>
                                        <li><a href="retail.php">Retail Logistics</a></li>
                                        <li><a href="auto.php">Automotive Supply Chain</a></li>
                                        <li><a href="aviation.php">Aviation &amp; Aerospace Logistics</a></li>
                                        <li><a href="tech.php">High Tech Logistics</a></li>
                                    </ul>
                                </li>
                                <li class="has-children"><a href="#">Resources</a>
                                    <ul class="sub-menu">
                                        <li><a href="tracking.php">Track Your Parcel</a></li>
                                        <li><a href="workprocess.php">Work Process</a></li>
                                        <li><a href="faqs.php">FAQ's</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.php">Contact</a></li>
                                <li><a href="resources">Client Area</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="site-copyright color-grey-400 mt-0">
                        <div class="mb-0"><span class="font-xs color-grey-500">&copy; <?= htmlspecialchars($row['year']) ?> <?= htmlspecialchars($row['name']) ?>. All rights reserved.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
