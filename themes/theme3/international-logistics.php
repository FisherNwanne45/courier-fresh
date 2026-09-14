<?php
$pageTitle = "International Logistics";
$pageDescription = "Flexible international cargo shipping.";
require_once __DIR__ . '/head.php';
?>
    <!-- header Section Start-->
    <div class="topbar-area d-lg-block d-none">
        <div class="container">
            <div class="topbar-wrap">
                <div class="logo-and-search-area">
                    <a href="index.php" class="header-logo">
                        <img src="resources/img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:32px;">
                    </a>
                </div>
                <div class="topbar-right">
                    <a class="call" href="tel:<?= htmlspecialchars($row['phone']) ?>">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M14.7161 10.5021C13.7365 10.5021 12.7747 10.3489 11.8633 10.0477C11.4166 9.89539 10.8676 10.0351 10.595 10.3151L8.79598 11.6732C6.70961 10.5595 5.42444 9.27472 4.32595 7.20402L5.64407 5.45186C5.98653 5.10986 6.10936 4.61028 5.96219 4.14153C5.65969 3.22528 5.50603 2.26391 5.50603 1.28391C5.50607 0.575957 4.93011 0 4.2222 0H1.28387C0.575957 0 0 0.575957 0 1.28387C0 9.39843 6.60157 16 14.7161 16C15.424 16 16 15.424 16 14.7161V11.786C16 11.0781 15.424 10.5021 14.7161 10.5021Z" />
                            </g>
                        </svg>
                        <?= htmlspecialchars($row['phone']) ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <header class="header-area style-3">
        <div class="container d-flex flex-nowrap align-items-center justify-content-between">
            <div class="header-logo d-lg-none d-block">
                <a href="index.php">
                    <img src="resources/img/<?= htmlspecialchars($row['image2'] ?: $row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:32px;">
                </a>
            </div>
            <div class="logo-and-menu-area">
                <div class="main-menu">
                    <div class="mobile-logo-area d-lg-none d-flex align-items-center justify-content-between">
                        <a href="index.php" class="mobile-logo-wrap">
                            <img src="resources/img/<?= htmlspecialchars($row['image2'] ?: $row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:32px;">
                        </a>
                        <div class="menu-close-btn">
                            <i class="bi bi-x"></i>
                        </div>
                    </div>
                    <?php include __DIR__ . '/nav.php'; ?>
                </div>
            </div>
            <div class="nav-right">
                <div class="translator-area">
                    <?php include __DIR__ . '/../../resources/translator.php'; ?>
                </div>
                <div class="contact-area">
                    <a class="primary-btn2 btn-hover d-xl-flex d-none" href="tracking.php">
                        Track &amp; Trace
                        <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                            </g>
                        </svg>
                        <span></span>
                    </a>
                </div>
                <div class="sidebar-button mobile-menu-btn">
                    <svg width="20" height="18" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.29445 2.8421H10.5237C11.2389 2.8421 11.8182 2.2062 11.8182 1.42105C11.8182 0.635903 11.2389 0 10.5237 0H1.29445C0.579249 0 0 0.635903 0 1.42105C0 2.2062 0.579249 2.8421 1.29445 2.8421Z">
                        </path>
                        <path
                            d="M1.23002 10.421H18.77C19.4496 10.421 20 9.78506 20 8.99991C20 8.21476 19.4496 7.57886 18.77 7.57886H1.23002C0.550421 7.57886 0 8.21476 0 8.99991C0 9.78506 0.550421 10.421 1.23002 10.421Z">
                        </path>
                        <path
                            d="M18.8052 15.1579H10.2858C9.62563 15.1579 9.09094 15.7938 9.09094 16.5789C9.09094 17.3641 9.62563 18 10.2858 18H18.8052C19.4653 18 20 17.3641 20 16.5789C20 15.7938 19.4653 15.1579 18.8052 15.1579Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </header>
    <!-- header Section End-->

    <!-- header Section End-->

    <!-- home1 Banner Section Start-->
    <div class="home3-banner-section mb-120">
        <div class="swiper home1-banner-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="banner-wrapper">
                        <div class="banner-img-area">
                            <img src="themes/theme3/assets/img/home3/home3-banner-img-1.jpg" alt="">
                        </div>
                        <div class="banner-content-wrap">
                            <div class="container">
                                <div class="banner-content-wrapper">
                                    <div class="banner-content">
                                        <p>Freight . Transit . Carriers</p>
                                        <h1>Flexible International Cargo Shipping.</h1>
                                        <a class="primary-btn2 two btn-hover" href="contact.php">
                                            Request A Quote
                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                                </g>
                                            </svg>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-wrapper">
                        <div class="banner-img-area">
                            <img src="themes/theme3/assets/img/home3/home3-banner-img-2.jpg" alt="Banner-img2">
                        </div>
                        <div class="banner-content-wrap">
                            <div class="container">
                                <div class="banner-content-wrapper">
                                    <div class="banner-content">
                                        <p>Freight . Transit . Carriers</p>
                                        <h1>Flexible International Cargo Shipping.</h1>
                                        <a class="primary-btn2 two btn-hover" href="contact.php">
                                            Request A Quote
                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                                </g>
                                            </svg>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-wrapper">
                        <div class="banner-img-area">
                            <img src="themes/theme3/assets/img/home3/home3-banner-img-3.jpg" alt="Banner-img2">
                        </div>
                        <div class="banner-content-wrap">
                            <div class="container">
                                <div class="banner-content-wrapper">
                                    <div class="banner-content">
                                        <p>Freight . Transit . Carriers</p>
                                        <h1>Flexible International Cargo Shipping.</h1>
                                        <a class="primary-btn2 two btn-hover" href="contact.php">
                                            Request A Quote
                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                                </g>
                                            </svg>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-wrapper">
                        <div class="banner-img-area">
                            <img src="themes/theme3/assets/img/home3/home3-banner-img-4.jpg" alt="">
                        </div>
                        <div class="banner-content-wrap">
                            <div class="container">
                                <div class="banner-content-wrapper">
                                    <div class="banner-content">
                                        <p>Freight . Transit . Carriers</p>
                                        <h1>Flexible International Cargo Shipping.</h1>
                                        <a class="primary-btn2 two btn-hover" href="contact.php">
                                            Request A Quote
                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                                </g>
                                            </svg>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-wrapper">
                        <div class="banner-img-area">
                            <img src="themes/theme3/assets/img/home3/home3-banner-img-5.jpg" alt="">
                        </div>
                        <div class="banner-content-wrap">
                            <div class="container">
                                <div class="banner-content-wrapper">
                                    <div class="banner-content">
                                        <p>Freight . Transit . Carriers</p>
                                        <h1>Flexible International Cargo Shipping.</h1>
                                        <a class="primary-btn2 two btn-hover" href="contact.php">
                                            Request A Quote
                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                                </g>
                                            </svg>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="history-wrapper">
            <ul class="history-list">
                <li class="single-history">
                    <div class="history">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="16" rx="5" />
                            <g>
                                <path
                                    d="M10.7565 5.22317C10.8947 5.07845 11.0787 4.99844 11.2695 5.00002C11.4604 5.00161 11.6433 5.08467 11.7795 5.23169C11.9157 5.3787 11.9947 5.57816 11.9997 5.78798C12.0048 5.9978 11.9355 6.20157 11.8065 6.3563L7.89085 11.7413C7.82352 11.8211 7.74226 11.8851 7.65192 11.9295C7.56158 11.9739 7.46403 11.9978 7.36509 11.9999C7.26614 12.0019 7.16785 11.9819 7.07608 11.9412C6.98431 11.9005 6.90094 11.8399 6.83097 11.7629L4.23426 8.90744C4.16195 8.83334 4.10395 8.74398 4.06372 8.6447C4.02349 8.54542 4.00186 8.43824 4.00011 8.32957C3.99837 8.22089 4.01655 8.11295 4.05357 8.01217C4.09059 7.91138 4.14569 7.81984 4.21558 7.74298C4.28547 7.66612 4.36872 7.60553 4.46037 7.56483C4.55202 7.52412 4.65019 7.50413 4.74901 7.50604C4.84784 7.50796 4.9453 7.53175 5.03559 7.57599C5.12588 7.62022 5.20713 7.684 5.27452 7.76352L7.32951 10.0222L10.7378 5.24692C10.744 5.23861 10.7495 5.23068 10.7565 5.22317Z" />
                            </g>
                        </svg>
                        <div class="content">
                            <span>Journey Begin</span>
                            <h2>1996</h2>
                        </div>
                    </div>
                    <svg width="222" height="6" viewBox="0 0 222 6" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM217 3.5L222 5.88675V0.113249L217 2.5V3.5ZM4.5 3V3.5H217.5V3V2.5H4.5V3Z" />
                    </svg>
                </li>
                <li class="single-history">
                    <div class="history">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="16" rx="5" />
                            <g>
                                <path
                                    d="M10.7565 5.22317C10.8947 5.07845 11.0787 4.99844 11.2695 5.00002C11.4604 5.00161 11.6433 5.08467 11.7795 5.23169C11.9157 5.3787 11.9947 5.57816 11.9997 5.78798C12.0048 5.9978 11.9355 6.20157 11.8065 6.3563L7.89085 11.7413C7.82352 11.8211 7.74226 11.8851 7.65192 11.9295C7.56158 11.9739 7.46403 11.9978 7.36509 11.9999C7.26614 12.0019 7.16785 11.9819 7.07608 11.9412C6.98431 11.9005 6.90094 11.8399 6.83097 11.7629L4.23426 8.90744C4.16195 8.83334 4.10395 8.74398 4.06372 8.6447C4.02349 8.54542 4.00186 8.43824 4.00011 8.32957C3.99837 8.22089 4.01655 8.11295 4.05357 8.01217C4.09059 7.91138 4.14569 7.81984 4.21558 7.74298C4.28547 7.66612 4.36872 7.60553 4.46037 7.56483C4.55202 7.52412 4.65019 7.50413 4.74901 7.50604C4.84784 7.50796 4.9453 7.53175 5.03559 7.57599C5.12588 7.62022 5.20713 7.684 5.27452 7.76352L7.32951 10.0222L10.7378 5.24692C10.744 5.23861 10.7495 5.23068 10.7565 5.22317Z" />
                            </g>
                        </svg>
                        <div class="content">
                            <span>Globalization Boom</span>
                            <h2>2002</h2>
                        </div>
                    </div>
                    <svg width="222" height="6" viewBox="0 0 222 6" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM217 3.5L222 5.88675V0.113249L217 2.5V3.5ZM4.5 3V3.5H217.5V3V2.5H4.5V3Z" />
                    </svg>
                </li>
                <li class="single-history">
                    <div class="history">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="16" rx="5" />
                            <g>
                                <path
                                    d="M10.7565 5.22317C10.8947 5.07845 11.0787 4.99844 11.2695 5.00002C11.4604 5.00161 11.6433 5.08467 11.7795 5.23169C11.9157 5.3787 11.9947 5.57816 11.9997 5.78798C12.0048 5.9978 11.9355 6.20157 11.8065 6.3563L7.89085 11.7413C7.82352 11.8211 7.74226 11.8851 7.65192 11.9295C7.56158 11.9739 7.46403 11.9978 7.36509 11.9999C7.26614 12.0019 7.16785 11.9819 7.07608 11.9412C6.98431 11.9005 6.90094 11.8399 6.83097 11.7629L4.23426 8.90744C4.16195 8.83334 4.10395 8.74398 4.06372 8.6447C4.02349 8.54542 4.00186 8.43824 4.00011 8.32957C3.99837 8.22089 4.01655 8.11295 4.05357 8.01217C4.09059 7.91138 4.14569 7.81984 4.21558 7.74298C4.28547 7.66612 4.36872 7.60553 4.46037 7.56483C4.55202 7.52412 4.65019 7.50413 4.74901 7.50604C4.84784 7.50796 4.9453 7.53175 5.03559 7.57599C5.12588 7.62022 5.20713 7.684 5.27452 7.76352L7.32951 10.0222L10.7378 5.24692C10.744 5.23861 10.7495 5.23068 10.7565 5.22317Z" />
                            </g>
                        </svg>
                        <div class="content">
                            <span>Global Brand</span>
                            <h2>2018</h2>
                        </div>
                    </div>
                    <svg width="222" height="6" viewBox="0 0 222 6" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM217 3.5L222 5.88675V0.113249L217 2.5V3.5ZM4.5 3V3.5H217.5V3V2.5H4.5V3Z" />
                    </svg>
                </li>
                <li class="single-history">
                    <div class="history">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="16" rx="5" />
                            <g>
                                <path
                                    d="M10.7565 5.22317C10.8947 5.07845 11.0787 4.99844 11.2695 5.00002C11.4604 5.00161 11.6433 5.08467 11.7795 5.23169C11.9157 5.3787 11.9947 5.57816 11.9997 5.78798C12.0048 5.9978 11.9355 6.20157 11.8065 6.3563L7.89085 11.7413C7.82352 11.8211 7.74226 11.8851 7.65192 11.9295C7.56158 11.9739 7.46403 11.9978 7.36509 11.9999C7.26614 12.0019 7.16785 11.9819 7.07608 11.9412C6.98431 11.9005 6.90094 11.8399 6.83097 11.7629L4.23426 8.90744C4.16195 8.83334 4.10395 8.74398 4.06372 8.6447C4.02349 8.54542 4.00186 8.43824 4.00011 8.32957C3.99837 8.22089 4.01655 8.11295 4.05357 8.01217C4.09059 7.91138 4.14569 7.81984 4.21558 7.74298C4.28547 7.66612 4.36872 7.60553 4.46037 7.56483C4.55202 7.52412 4.65019 7.50413 4.74901 7.50604C4.84784 7.50796 4.9453 7.53175 5.03559 7.57599C5.12588 7.62022 5.20713 7.684 5.27452 7.76352L7.32951 10.0222L10.7378 5.24692C10.744 5.23861 10.7495 5.23068 10.7565 5.22317Z" />
                            </g>
                        </svg>
                        <div class="content">
                            <span>Digital Expansion</span>
                            <h2>2021</h2>
                        </div>
                    </div>
                    <svg width="222" height="6" viewBox="0 0 222 6" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM217 3.5L222 5.88675V0.113249L217 2.5V3.5ZM4.5 3V3.5H217.5V3V2.5H4.5V3Z" />
                    </svg>
                </li>
                <li class="single-history">
                    <div class="history">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="16" rx="5" />
                            <g>
                                <path
                                    d="M10.7565 5.22317C10.8947 5.07845 11.0787 4.99844 11.2695 5.00002C11.4604 5.00161 11.6433 5.08467 11.7795 5.23169C11.9157 5.3787 11.9947 5.57816 11.9997 5.78798C12.0048 5.9978 11.9355 6.20157 11.8065 6.3563L7.89085 11.7413C7.82352 11.8211 7.74226 11.8851 7.65192 11.9295C7.56158 11.9739 7.46403 11.9978 7.36509 11.9999C7.26614 12.0019 7.16785 11.9819 7.07608 11.9412C6.98431 11.9005 6.90094 11.8399 6.83097 11.7629L4.23426 8.90744C4.16195 8.83334 4.10395 8.74398 4.06372 8.6447C4.02349 8.54542 4.00186 8.43824 4.00011 8.32957C3.99837 8.22089 4.01655 8.11295 4.05357 8.01217C4.09059 7.91138 4.14569 7.81984 4.21558 7.74298C4.28547 7.66612 4.36872 7.60553 4.46037 7.56483C4.55202 7.52412 4.65019 7.50413 4.74901 7.50604C4.84784 7.50796 4.9453 7.53175 5.03559 7.57599C5.12588 7.62022 5.20713 7.684 5.27452 7.76352L7.32951 10.0222L10.7378 5.24692C10.744 5.23861 10.7495 5.23068 10.7565 5.22317Z" />
                            </g>
                        </svg>
                        <div class="content">
                            <span>Future Innovation</span>
                            <h2>2025</h2>
                        </div>
                    </div>
                    <svg width="222" height="6" viewBox="0 0 222 6" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM217 3.5L222 5.88675V0.113249L217 2.5V3.5ZM4.5 3V3.5H217.5V3V2.5H4.5V3Z" />
                    </svg>
                </li>
            </ul>
            <img class="vector-img" src="themes/theme3/assets/img/home3/vector/history-shape-color.png" alt="">
            <img class="vector-img2" src="themes/theme3/assets/img/home3/vector/history-shape-color2.png" alt="">
        </div>
    </div>
    <!-- home1 Banner Section End-->

    <!-- Home3 Service Section Start -->
    <div class="home3-service-section mb-120">
        <div class="container">
            <div class="row gy-5 align-items-center justify-content-between">
                <div class="col-xl-5 col-lg-6 wow animate fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <div class="service-img-wrap">
                        <img src="themes/theme3/assets/img/home3/home3-about-img.png" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 wow animate fadeInRight" data-wow-delay="200ms"
                    data-wow-duration="1500ms">
                    <div class="section-title mb-50">
                        <h2>Leaders in International Shipping.</h2>
                        <p>We specialize in connecting businesses and individuals worldwide with efficient, reliable,
                            and affordable cargo shipping solutions.</p>
                    </div>
                    <h5>With decades of experience, we specialize in delivering seamless, <span>reliable,and
                            cost-effective shipping solutions.</span></h5>
                    <ul class="service-list">
                        <li>
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="11" fill="#D9DFFF"></circle>
                                <g>
                                    <path
                                        d="M15.2718 6.16237C13.6878 7.42573 11.6424 10.2128 10.4994 12.6792L10.1852 13.3706C10.1099 13.5364 9.87621 13.5413 9.79401 13.3789L9.21609 12.2381C8.45409 10.7341 8.41413 10.694 7.99305 10.9747C7.75245 11.1352 7.07049 11.5562 6.50913 11.8972C5.92773 12.2581 5.44641 12.5789 5.44641 12.6191C5.44641 12.6593 5.88753 12.9599 6.40881 13.3008C6.95025 13.6416 8.01297 14.5841 8.79501 15.3862L10.0271 16.6354C10.05 16.6586 10.0779 16.6764 10.1086 16.6873C10.1394 16.6983 10.1722 16.7022 10.2047 16.6987C10.2372 16.6952 10.2684 16.6845 10.2961 16.6672C10.3239 16.65 10.3474 16.6267 10.3649 16.5991L10.9808 15.6266C12.5249 13.2606 14.8709 10.6538 16.1141 9.99217C16.6153 9.73141 16.6353 9.67129 16.4349 9.08977C16.3146 8.70877 16.2745 7.82653 16.3346 6.88417C16.4148 6.00181 16.4349 5.30005 16.4148 5.30005C16.3947 5.30005 15.8733 5.68117 15.2718 6.16237Z"
                                        fill="#3655FF"></path>
                                </g>
                            </svg>
                            Global Coverage
                        </li>
                        <li>
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="11" fill="#D9DFFF"></circle>
                                <g>
                                    <path
                                        d="M15.2718 6.16237C13.6878 7.42573 11.6424 10.2128 10.4994 12.6792L10.1852 13.3706C10.1099 13.5364 9.87621 13.5413 9.79401 13.3789L9.21609 12.2381C8.45409 10.7341 8.41413 10.694 7.99305 10.9747C7.75245 11.1352 7.07049 11.5562 6.50913 11.8972C5.92773 12.2581 5.44641 12.5789 5.44641 12.6191C5.44641 12.6593 5.88753 12.9599 6.40881 13.3008C6.95025 13.6416 8.01297 14.5841 8.79501 15.3862L10.0271 16.6354C10.05 16.6586 10.0779 16.6764 10.1086 16.6873C10.1394 16.6983 10.1722 16.7022 10.2047 16.6987C10.2372 16.6952 10.2684 16.6845 10.2961 16.6672C10.3239 16.65 10.3474 16.6267 10.3649 16.5991L10.9808 15.6266C12.5249 13.2606 14.8709 10.6538 16.1141 9.99217C16.6153 9.73141 16.6353 9.67129 16.4349 9.08977C16.3146 8.70877 16.2745 7.82653 16.3346 6.88417C16.4148 6.00181 16.4349 5.30005 16.4148 5.30005C16.3947 5.30005 15.8733 5.68117 15.2718 6.16237Z"
                                        fill="#3655FF"></path>
                                </g>
                            </svg>
                            Advanced Tracking
                        </li>
                        <li>
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="11" fill="#D9DFFF"></circle>
                                <g>
                                    <path
                                        d="M15.2718 6.16237C13.6878 7.42573 11.6424 10.2128 10.4994 12.6792L10.1852 13.3706C10.1099 13.5364 9.87621 13.5413 9.79401 13.3789L9.21609 12.2381C8.45409 10.7341 8.41413 10.694 7.99305 10.9747C7.75245 11.1352 7.07049 11.5562 6.50913 11.8972C5.92773 12.2581 5.44641 12.5789 5.44641 12.6191C5.44641 12.6593 5.88753 12.9599 6.40881 13.3008C6.95025 13.6416 8.01297 14.5841 8.79501 15.3862L10.0271 16.6354C10.05 16.6586 10.0779 16.6764 10.1086 16.6873C10.1394 16.6983 10.1722 16.7022 10.2047 16.6987C10.2372 16.6952 10.2684 16.6845 10.2961 16.6672C10.3239 16.65 10.3474 16.6267 10.3649 16.5991L10.9808 15.6266C12.5249 13.2606 14.8709 10.6538 16.1141 9.99217C16.6153 9.73141 16.6353 9.67129 16.4349 9.08977C16.3146 8.70877 16.2745 7.82653 16.3346 6.88417C16.4148 6.00181 16.4349 5.30005 16.4148 5.30005C16.3947 5.30005 15.8733 5.68117 15.2718 6.16237Z"
                                        fill="#3655FF"></path>
                                </g>
                            </svg>
                            Expert Support
                        </li>
                        <li>
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="11" fill="#D9DFFF"></circle>
                                <g>
                                    <path
                                        d="M15.2718 6.16237C13.6878 7.42573 11.6424 10.2128 10.4994 12.6792L10.1852 13.3706C10.1099 13.5364 9.87621 13.5413 9.79401 13.3789L9.21609 12.2381C8.45409 10.7341 8.41413 10.694 7.99305 10.9747C7.75245 11.1352 7.07049 11.5562 6.50913 11.8972C5.92773 12.2581 5.44641 12.5789 5.44641 12.6191C5.44641 12.6593 5.88753 12.9599 6.40881 13.3008C6.95025 13.6416 8.01297 14.5841 8.79501 15.3862L10.0271 16.6354C10.05 16.6586 10.0779 16.6764 10.1086 16.6873C10.1394 16.6983 10.1722 16.7022 10.2047 16.6987C10.2372 16.6952 10.2684 16.6845 10.2961 16.6672C10.3239 16.65 10.3474 16.6267 10.3649 16.5991L10.9808 15.6266C12.5249 13.2606 14.8709 10.6538 16.1141 9.99217C16.6153 9.73141 16.6353 9.67129 16.4349 9.08977C16.3146 8.70877 16.2745 7.82653 16.3346 6.88417C16.4148 6.00181 16.4349 5.30005 16.4148 5.30005C16.3947 5.30005 15.8733 5.68117 15.2718 6.16237Z"
                                        fill="#3655FF"></path>
                                </g>
                            </svg>
                            Comprehensive Solutions
                        </li>
                    </ul>
                    <div class="btn-and-rating-area">
                        <a class="primary-btn2 two black-bg btn-hover" href="services.php">
                            Discover More
                            <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z">
                                    </path>
                                </g>
                            </svg>
                            <span></span>
                        </a>
                        <a href="#" class="rating-area">
                            <div class="review">
                                <span>REVIEWED</span>
                                <svg width="74" height="21" viewBox="0 0 74 21" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M54.5739 16.1797C55.9137 16.1797 56.9998 15.0923 56.9998 13.751C56.9998 12.4096 55.9137 11.3223 54.5739 11.3223C53.2341 11.3223 52.148 12.4096 52.148 13.751C52.148 15.0923 53.2341 16.1797 54.5739 16.1797Z"
                                            fill="#E62415"></path>
                                        <path
                                            d="M19.2615 0H22.4718V20.7261H19.2615V0ZM34.1637 14.3348C34.1637 17.5487 31.5371 17.8043 30.7345 17.8043C28.7281 17.8043 28.4363 15.9235 28.4363 14.7913V6.77478H25.2078V14.773C25.1896 16.7635 25.755 18.407 26.8494 19.5026C27.8433 20.3896 29.1096 20.911 30.4393 20.9807C31.7689 21.0504 33.0826 20.6643 34.1637 19.8861V20.7261H37.3922V6.77478H34.1637V14.3348ZM44.3599 2.08174H41.1314V6.77478H38.8879V9.82435H41.1314V20.7261H44.3599V9.82435H47.0047V6.77478H44.3599V2.08174ZM57.4563 16.7635C56.7267 17.4209 55.7599 17.7861 54.702 17.7861C54.1646 17.8013 53.6297 17.7063 53.1303 17.5068C52.6309 17.3073 52.1776 17.0076 51.7983 16.6261C51.419 16.2446 51.1216 15.7895 50.9246 15.2886C50.7276 14.7878 50.6351 14.2519 50.6527 13.7139C50.6527 11.3583 52.3126 9.71478 54.702 9.71478C55.7417 9.71478 56.7267 10.0617 57.4745 10.7191L57.9852 11.1574L60.247 8.89304L59.6816 8.38174C58.3119 7.15868 56.5373 6.4884 54.702 6.50087C50.5068 6.50087 47.4607 9.53217 47.4607 13.6957C47.4384 14.6555 47.6102 15.6099 47.9657 16.5016C48.3213 17.3933 48.8533 18.2038 49.5297 18.8843C50.2061 19.5649 51.013 20.1016 51.9018 20.462C52.7907 20.8224 53.7432 20.9992 54.702 20.9817C56.6172 20.9817 58.4047 20.3061 59.718 19.0826L60.2652 18.5713L57.967 16.307L57.4563 16.7635ZM72.3584 7.99826C71.3645 7.11125 70.0982 6.58989 68.7686 6.52017C67.4389 6.45046 66.1252 6.83656 65.0441 7.61478V0H61.8156V20.7261H65.0441V13.1843C65.0441 9.97043 67.6707 9.71478 68.4733 9.71478C70.4797 9.71478 70.7715 11.5957 70.7715 12.7278V20.7443H74V12.7278C74.0974 10.9962 73.5074 9.29627 72.3584 7.99826ZM14.5009 15.7591C13.8728 16.4051 13.121 16.9175 12.2904 17.2658C11.4599 17.6141 10.5677 17.7911 9.66724 17.7861C5.92803 17.7861 3.21025 14.8461 3.21025 10.8104C3.21025 6.75652 5.92803 3.81652 9.66724 3.81652C11.473 3.81652 13.1876 4.5287 14.4826 5.82522L14.9933 6.33652L17.2369 4.09043L16.7444 3.57913C15.8189 2.63675 14.7142 1.88948 13.4956 1.38141C12.277 0.873327 10.9691 0.61473 9.649 0.62087C4.15874 0.62087 0 5.00348 0 10.8287C0 16.6174 4.15874 21 9.649 21C12.3668 21 14.8839 19.9409 16.7444 18.0235L17.2369 17.5122L15.0116 15.2296L14.5009 15.7591Z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div class="rating">
                                <ul class="star">
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-half"></i></li>
                                </ul>
                                <span>50 REVIEWS</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="2000ms">
                <div class="col-lg-12 d-flex align-items-center justify-content-center">
                    <div class="service-btn mt-60">
                        <span>
                            Do you want to connecting the world one mile at a time!
                            <a href="services.php">
                                View All Services
                                <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                        stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <img class="shape-img" src="themes/theme3/assets/img/home3/home3-about-shape-img.svg" alt="">
    </div>
    <!--Home3 About Section End -->

    <!-- Home3 Contact Section Start -->
    <div class="home1-contact-section two ">
        <div class="container">
            <div class="section-title mb-60 white text-center wow animate fadeInDown" data-wow-delay="200ms"
                data-wow-duration="2000ms">
                <h2>Trusted.<span>Secure</span>.Transit</h2>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-wrapper">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-requestQuote-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-requestQuote" type="button" role="tab"
                                    aria-controls="pills-requestQuote" aria-selected="true">Request A Quote</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-trackingShipment-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-trackingShipment" type="button" role="tab"
                                    aria-controls="pills-trackingShipment" aria-selected="false" tabindex="-1">Tracking
                                    Shipment</button>
                            </li>
                        </ul>
                        <svg class="line" height="6" viewBox="0 0 956 6" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM951 3.5L956 5.88675V0.113249L951 2.5V3.5ZM4.5 3V3.5H951.5V3V2.5H4.5V3Z">
                            </path>
                        </svg>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="pills-requestQuote" role="tabpanel"
                                aria-labelledby="pills-requestQuote-tab">
                                <div class="service-type-nav-area">
                                    <h6>Select Your Service Type*</h6>
                                    <div class="check-area">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <svg width="25" height="25" viewBox="0 0 25 25"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path
                                                            d="M24.2952 2.50919C24.374 1.99932 24.2114 1.49932 23.8469 1.13721C23.4823 0.775154 22.9823 0.615047 22.4724 0.698787C21.2753 0.893367 20.4773 1.18155 20.1053 1.55596L15.45 6.20885L10.9376 4.82457L11.8095 3.95504C12.2267 3.53282 12.2394 2.85333 11.8095 2.41309C11.3834 1.98946 10.6913 1.98946 10.2651 2.41309L8.58037 4.10284L7.59019 3.79742L8.46704 2.92545C8.88975 2.50274 8.89863 1.81265 8.46704 1.38106C8.03032 0.949519 7.35025 0.958553 6.92266 1.38106L5.23047 3.07325L3.40777 2.51412C3.32154 2.48702 3.22549 2.51168 3.16143 2.57569L1.18604 4.55357C1.13184 4.60528 1.10718 4.67921 1.1146 4.75308C1.12197 4.82701 1.16387 4.89347 1.22544 4.93536L10.6741 10.9873L6.21821 15.4431L2.14912 14.9554C2.11227 14.9515 2.075 14.9559 2.04006 14.9683C2.00512 14.9807 1.97338 15.0007 1.94717 15.0269L0.757473 16.2166C0.643313 16.3257 0.665334 16.5283 0.819045 16.6107L3.78955 18.123C3.41099 19.0413 3.64287 20.1222 4.42256 20.798C5.08438 21.3766 6.0314 21.5187 6.86353 21.1748L8.3981 24.1897C8.47847 24.3398 8.67661 24.3669 8.79214 24.2513L9.98184 23.0616C10.036 23.0074 10.0607 22.9335 10.0533 22.8571L9.56065 18.7462L14.0017 14.3051L20.0733 23.7808C20.1152 23.8448 20.1817 23.8867 20.2556 23.8941H20.2803C20.3468 23.8941 20.4083 23.8695 20.4551 23.8227L22.4331 21.8472C22.4971 21.7807 22.5217 21.6871 22.4946 21.6009L21.9231 19.7387L23.603 18.0613C24.0267 17.6352 24.0267 16.9431 23.603 16.517C23.3961 16.3101 23.1227 16.1967 22.832 16.1967C22.6884 16.1964 22.5461 16.2246 22.4133 16.2795C22.2806 16.3345 22.16 16.4152 22.0586 16.517L21.199 17.3791L20.896 16.3913L22.5709 14.7189V14.7164C22.9922 14.2927 22.9922 13.6006 22.5685 13.1744C22.3616 12.97 22.0881 12.8567 21.7975 12.8567C21.5143 12.8567 21.2334 12.9725 21.0266 13.1744L20.1719 14.0316L18.7876 9.51915L23.4281 4.87857C23.8198 4.48707 24.1105 3.69146 24.2952 2.50919ZM5.76499 3.23829L7.27241 1.73087C7.49902 1.50426 7.89068 1.50426 8.11724 1.73087C8.35254 1.96114 8.35508 2.3379 8.11724 2.57574L7.05811 3.63487C6.6542 3.51095 5.70381 3.21949 5.76499 3.23829ZM22.4084 16.8669C22.635 16.6402 23.0242 16.6378 23.2533 16.8669C23.4873 17.0984 23.4873 17.4802 23.2533 17.7117L21.7606 19.2068L21.3616 17.9112L22.4084 16.8669ZM21.3739 13.5244C21.603 13.3002 21.9971 13.3027 22.2212 13.5219C22.4528 13.7559 22.4528 14.1377 22.2212 14.3692L20.7335 15.8594L20.3345 14.5638L21.3739 13.5244ZM10.4055 4.66197L9.11236 4.26539L10.6149 2.7629C10.8464 2.52891 11.2282 2.52891 11.4597 2.76046C11.6971 3.00294 11.6886 3.37887 11.4597 3.60777L10.4055 4.66197ZM7.31924 20.2906C6.60742 21.0025 5.47681 21.0615 4.74527 20.426C3.9833 19.7651 3.83394 18.5493 4.66148 17.7215C4.68755 17.6953 18.3436 4.00738 20.4527 1.90323C20.7433 1.61505 21.4896 1.35889 22.5538 1.18399C22.8889 1.12818 23.2419 1.22926 23.4996 1.48697C23.7508 1.73575 23.8642 2.08057 23.8075 2.43282C23.6006 3.77276 23.2977 4.31221 23.0809 4.5314L7.31924 20.2906Z">
                                                        </path>
                                                        <path
                                                            d="M7.4749 17.1607C7.45201 17.1836 7.43386 17.2107 7.42147 17.2406C7.40909 17.2705 7.40271 17.3025 7.40271 17.3349C7.40271 17.3672 7.40909 17.3993 7.42147 17.4291C7.43386 17.459 7.45201 17.4862 7.4749 17.509C7.49776 17.5319 7.52491 17.5501 7.55479 17.5624C7.58467 17.5748 7.6167 17.5812 7.64905 17.5812C7.68139 17.5812 7.71342 17.5748 7.7433 17.5624C7.77318 17.5501 7.80033 17.5319 7.82319 17.509L20.6716 4.66069C20.7678 4.56445 20.7678 4.40859 20.6716 4.3124C20.5753 4.2162 20.4195 4.21616 20.3233 4.3124L7.4749 17.1607Z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                Air Freight
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <svg width="25" height="25" viewBox="0 0 25 25"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.21801 21.5604C6.36176 22.2836 7.8511 22.6505 9.64448 22.6505H10.1754C10.2485 22.6505 10.3186 22.6215 10.3703 22.5697C10.4221 22.518 10.4511 22.4479 10.4511 22.3748C10.4511 22.3016 10.4221 22.2315 10.3703 22.1798C10.3186 22.1281 10.2485 22.099 10.1754 22.099H9.64412C7.95698 22.099 6.56691 21.7608 5.5125 21.0943C5.48195 21.0748 5.44785 21.0616 5.41217 21.0554C5.37649 21.0491 5.33993 21.05 5.3046 21.058C5.26927 21.0659 5.23586 21.0808 5.2063 21.1017C5.17673 21.1227 5.1516 21.1492 5.13235 21.1799C5.11293 21.2105 5.09975 21.2446 5.09354 21.2803C5.08734 21.316 5.08824 21.3526 5.0962 21.388C5.10416 21.4233 5.11902 21.4567 5.13992 21.4863C5.16082 21.5159 5.18736 21.5411 5.21801 21.5604ZM11.2467 22.6509H11.3691C11.4422 22.6509 11.5124 22.6218 11.5641 22.5701C11.6158 22.5184 11.6449 22.4483 11.6449 22.3751C11.6449 22.302 11.6158 22.2319 11.5641 22.1802C11.5124 22.1285 11.4422 22.0994 11.3691 22.0994H11.2467C11.1736 22.0994 11.1034 22.1285 11.0517 22.1802C11 22.2319 10.971 22.302 10.971 22.3751C10.971 22.4483 11 22.5184 11.0517 22.5701C11.1034 22.6218 11.1736 22.6509 11.2467 22.6509Z">
                                                    </path>
                                                    <path
                                                        d="M23.9426 17.3784C23.9992 16.8203 23.5551 16.3335 22.9952 16.3335H14.043V14.11C16.2478 13.0012 18.5915 13.346 21.2033 15.167C21.3893 15.2975 21.6518 15.1556 21.636 14.9225C20.9713 4.96771 15.2437 2.74565 14.0434 2.38829V1.98572C14.0428 1.65415 13.9107 1.33634 13.6762 1.10196C13.4417 0.867577 13.1238 0.73574 12.7923 0.735352C12.4604 0.735448 12.1421 0.867195 11.9073 1.10168C11.6725 1.33616 11.5403 1.65423 11.5397 1.98609V2.92469C10.3298 3.30815 4.25953 5.61587 3.57939 13.4508C3.57516 13.4985 3.58344 13.5464 3.60341 13.5899C3.62338 13.6334 3.65436 13.6709 3.69327 13.6987C3.73218 13.7266 3.77768 13.7438 3.82528 13.7487C3.87288 13.7535 3.92093 13.7459 3.96468 13.7265C6.72681 12.5155 9.06762 13.1339 11.5397 15.7251V16.3339H2.00659C1.87176 16.3341 1.73851 16.3628 1.61559 16.4182C1.49267 16.4736 1.38288 16.5544 1.29345 16.6553C1.20401 16.7562 1.13696 16.8749 1.09671 17.0036C1.05645 17.1323 1.04391 17.268 1.0599 17.4019C1.11711 17.8476 1.20544 18.2887 1.32424 18.7221V18.7273C2.29446 22.2979 5.24997 24.2648 9.64556 24.2648H15.3441C17.9713 24.2648 19.9441 23.3074 21.7981 21.5997C22.665 20.8034 23.3536 20.1706 23.7147 18.7346V18.7324L23.7165 18.7262C23.7165 18.7243 23.718 18.7229 23.7184 18.7214C23.8224 18.3181 23.8956 17.8791 23.9426 17.3784ZM14.0434 13.1471V3.55594C16.1551 7.12469 16.1559 10.2765 14.0434 13.1479V13.1471ZM11.5397 14.2743C10.2838 11.021 10.2838 7.73388 11.5397 4.47175V14.2743ZM12.0912 1.98535C12.0912 1.7996 12.1649 1.62146 12.2963 1.49012C12.4276 1.35877 12.6058 1.28498 12.7915 1.28498C12.9773 1.28498 13.1554 1.35877 13.2868 1.49012C13.4181 1.62146 13.4919 1.7996 13.4919 1.98535V16.3331H12.0912V1.98535ZM21.425 21.1934C19.6985 22.7854 17.8617 23.7133 15.3441 23.7133H9.64556C7.32056 23.7133 3.29078 23.082 1.95953 18.9302H23.0856C22.7474 19.9787 22.1794 20.5008 21.425 21.1934Z">
                                                    </path>
                                                </svg>
                                                Ocean Freight
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault3">
                                            <label class="form-check-label" for="flexRadioDefault3">
                                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11.4328 20.2307H7.70371C7.63058 20.2307 7.56045 20.2598 7.50874 20.3115C7.45703 20.3632 7.42798 20.4333 7.42798 20.5065C7.42798 20.5796 7.45703 20.6497 7.50874 20.7014C7.56045 20.7532 7.63058 20.7822 7.70371 20.7822H11.4328C11.5059 20.7822 11.576 20.7532 11.6277 20.7014C11.6794 20.6497 11.7085 20.5796 11.7085 20.5065C11.7085 20.4333 11.6794 20.3632 11.6277 20.3115C11.576 20.2598 11.5059 20.2307 11.4328 20.2307ZM9.73092 21.7954H7.70371C7.63058 21.7954 7.56045 21.8245 7.50874 21.8762C7.45703 21.9279 7.42798 21.9981 7.42798 22.0712C7.42798 22.1443 7.45703 22.2144 7.50874 22.2662C7.56045 22.3179 7.63058 22.3469 7.70371 22.3469H9.73092C9.80405 22.3469 9.87418 22.3179 9.92589 22.2662C9.9776 22.2144 10.0067 22.1443 10.0067 22.0712C10.0067 21.9981 9.9776 21.9279 9.92589 21.8762C9.87418 21.8245 9.80405 21.7954 9.73092 21.7954ZM16.9214 20.1616H14.0614C13.8541 20.1616 13.6857 20.33 13.6857 20.5377V21.9532C13.6857 22.1609 13.8541 22.3293 14.0614 22.3293H16.9217C17.1291 22.3293 17.2975 22.1609 17.2975 21.9535V20.5377C17.2975 20.33 17.1291 20.1616 16.9214 20.1616Z"
                                                        fill="#999999"></path>
                                                    <path
                                                        d="M22.1287 9.28854C21.5588 4.41133 17.4217 0.734863 12.5 0.734863C7.5728 0.734863 3.43236 4.41832 2.86913 9.30472C2.85001 9.48413 2.96177 9.65067 3.13457 9.70178L6.13751 13.8047C5.89012 14.1313 5.75567 14.5295 5.75442 14.9393V22.3577C5.755 22.8633 5.95615 23.3481 6.31372 23.7057C6.67129 24.0633 7.15609 24.2644 7.66177 24.265H17.3401C17.8458 24.2645 18.3307 24.0634 18.6884 23.7058C19.046 23.3483 19.2472 22.8634 19.2478 22.3577V14.9393C19.2465 14.5314 19.1133 14.135 18.868 13.8091C19.4033 13.09 21.4507 10.3407 21.9636 9.65288C22.022 9.61593 22.0687 9.56312 22.0982 9.50062C22.1277 9.43812 22.1388 9.36851 22.1302 9.29994V9.2992C22.1296 9.29551 22.129 9.29183 22.1283 9.28817L22.1287 9.28854ZM17.3397 13.0319H16.6489L17.4934 9.9878C17.5242 9.94979 17.5488 9.9071 17.5662 9.86133C17.6908 9.42708 17.9532 9.0451 18.3138 8.77295C18.6744 8.5008 19.1137 8.35324 19.5655 8.35251C19.9463 8.35068 20.3202 8.45439 20.6457 8.65213C20.9713 8.84986 21.2356 9.1339 21.4096 9.47273C18.9596 12.7628 18.6206 13.215 18.4757 13.4161C18.1488 13.1681 17.7501 13.0332 17.3397 13.0319ZM12.7757 13.0319V10.4305L12.7754 10.4279C12.7761 9.28339 13.7092 8.35251 14.8563 8.35251C15.3082 8.35444 15.7473 8.50275 16.1079 8.77523C16.4685 9.0477 16.731 9.42967 16.8563 9.86391C16.8699 9.91023 16.893 9.95067 16.9213 9.98744L16.0765 13.0319H12.7757ZM6.5331 13.4102L3.64707 9.37347C3.82969 9.06206 4.09071 8.80394 4.40414 8.62481C4.71757 8.44568 5.07246 8.3518 5.43347 8.35251C6.3581 8.35251 7.18199 8.9731 7.43383 9.85214C7.44707 9.90619 7.47317 9.95508 7.5081 9.99736L8.35332 13.0319H7.66177C7.23824 13.0319 6.85038 13.1753 6.5331 13.4102ZM8.92574 13.0319L8.07905 9.99148C8.10847 9.95361 8.13273 9.9106 8.14707 9.86133C8.27177 9.42703 8.53429 9.04504 8.89504 8.77295C9.25579 8.50086 9.69521 8.35343 10.1471 8.35288C10.6978 8.35356 11.2257 8.57263 11.6151 8.96203C12.0045 9.35143 12.2236 9.87938 12.2243 10.4301V13.0319H8.92648H8.92574ZM21.4614 8.60141C21.2159 8.34674 20.9213 8.14451 20.5954 8.00694C20.2696 7.86937 19.9192 7.79933 19.5655 7.80104C19.1766 7.80185 18.7928 7.88828 18.4412 8.05418C18.0895 8.22009 17.7787 8.4614 17.5309 8.76097C17.4438 5.68817 16.3235 3.01575 13.7276 1.36832C17.5666 1.88303 20.6912 4.78082 21.4614 8.60141ZM11.2728 1.36795C8.64891 3.05876 7.55516 5.66832 7.46802 8.76464C7.22064 8.4644 6.91007 8.22241 6.55847 8.05592C6.20686 7.88942 5.82286 7.80252 5.43383 7.80141C4.70185 7.80141 4.02464 8.097 3.53751 8.60435C4.30663 4.78229 7.43273 1.88303 11.2728 1.36795ZM18.6963 22.3577C18.6959 22.7172 18.5529 23.0619 18.2986 23.3161C18.0444 23.5703 17.6996 23.7132 17.3401 23.7135H7.66177C7.30229 23.7132 6.95764 23.5702 6.70345 23.316C6.44926 23.0618 6.30628 22.7171 6.30589 22.3577V14.9393C6.30628 14.5798 6.44926 14.2351 6.70345 13.981C6.95764 13.7268 7.30229 13.5838 7.66177 13.5834H10.8544V16.5257C10.8544 16.7481 11.096 16.8867 11.2882 16.7742L12.3548 16.1507C12.3989 16.1248 12.4492 16.1111 12.5004 16.1111C12.5516 16.1111 12.6018 16.1248 12.646 16.1507L13.7129 16.7742C13.7567 16.7998 13.8064 16.8134 13.8571 16.8137C13.9079 16.8139 13.9577 16.8008 14.0017 16.7755C14.0458 16.7503 14.0823 16.7139 14.1078 16.6701C14.1332 16.6262 14.1467 16.5764 14.1467 16.5257V13.5834H17.3401C18.0732 13.5834 18.6963 14.1944 18.6963 14.9393V22.3577Z">
                                                    </path>
                                                </svg>
                                                Land Freight
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <form action="contact.php" method="post">
                                    <div class="row g-4 mb-50">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-inner">
                                                <label>Full Name</label>
                                                <input type="text" name="tname" placeholder="Mr. Daniel Scoot" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-inner">
                                                <label>Email*</label>
                                                <input type="email" name="temail" placeholder="info@example.com" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-inner">
                                                <label>Phone*</label>
                                                <input type="text" name="tphone" placeholder="+920- 5566 **** ****">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-inner">
                                                <label>Type of Goods</label>
                                                <input type="text" name="tgoods" placeholder="General Freight">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-inner">
                                                <label>Weight of Shipment&nbsp;</label>
                                                <input type="text" name="tweight" placeholder="kilograms/tons">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-inner">
                                                <label>Dimensions&nbsp;</label>
                                                <input type="text" name="tdimensions" placeholder="Length x Width x Height">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contact-btn-area">
                                        <button class="primary-btn2 black-bg btn-hover" type="submit">
                                            Request Callback
                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z">
                                                    </path>
                                                </g>
                                            </svg>
                                            <span></span>
                                        </button>
                                        <div class="content">
                                            <p>Note: We’ll contact with you as soon as possible.</p>
                                            <span>Face any truoble? <a href="#">Contact Our Expert.</a></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-trackingShipment" role="tabpanel"
                                aria-labelledby="pills-trackingShipment-tab">
                                <div class="tracking-area-wrapper two">
                                    <div class="tracking-shipment-content">
                                        <span>Tracking Shipment</span>
                                        <p>Shipment tracking is the backbone of modern logistics. Customers expect
                                            real-time visibility into where their cargo is, its estimated delivery time,
                                            & any potential delays.</p>
                                    </div>
                                    <ul class="tracking-list">
                                        <li class="single-tracking">
                                            <img src="themes/theme3/assets/img/home1/icon/tracking-icon.svg" alt="">
                                            24/7 Real-time location updates.
                                        </li>
                                        <li class="single-tracking">
                                            <img src="themes/theme3/assets/img/home1/icon/tracking-icon.svg" alt="">
                                            Interactive Tracking Dashboardg
                                        </li>
                                    </ul>
                                    <form action="resources/track-result.php" method="post">
                                        <div class="form-inner">
                                            <label>Enter Your Tracking Id</label>
                                            <input type="text" name="search" placeholder="7890123456" required>
                                            <input type="hidden" name="dropdown" value="cid">
                                            <button class="primary-btn2 two btn-hover" type="submit" name="Submit">
                                                Track & Trace
                                                <svg width="10" height="10" viewBox="0 0 10 10"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path
                                                            d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z" />
                                                    </g>
                                                </svg>

                                                <span></span>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="contact">
                                        <p>Note: We’ll contact with you as soon as possible.</p>
                                        <span>Face any truoble? <a href="#">Contact Our Expert.</a></span>
                                    </div>
                                    <img class="vector" src="themes/theme3/assets/img/home1/vector/tracking-shipment-vector.png"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home3 Contact Section End -->

    <!-- Start Interactive Banner Section -->
    <div class="service-banner-section">
        <ul class="service-banner-img-group"
            style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img1.jpg');">
            <li class="single-banner-bg" id="background-panel-0"
                style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img1.jpg');">
            </li>
            <li class="single-banner-bg" id="background-panel-1"
                style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img2.jpg');">
            </li>
            <li class="single-banner-bg" id="background-panel-2"
                style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img3.jpg');">
            </li>
            <li class="single-banner-bg" id="background-panel-3"
                style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img4.jpg');">
            </li>
        </ul>
        <ul class="service-list">
            <li class="service-single-item" data-show="#background-panel-0">
                <div class="responsive-bg-img"
                    style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img1.jpg');">
                </div>
                <div class="card-content">
                    <div class="catgory-and-title">
                        <a href="services.php">Air Freight</a>
                        <h3><a href="services.php">Freight Transportation</a></h3>
                    </div>
                    <p>Freight Transportation shipping solutions by road, rail, sea, and air, ensuring your goods reach
                        their destination safely.</p>
                </div>
            </li>
            <li class="service-single-item" data-show="#background-panel-1">
                <div class="responsive-bg-img"
                    style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img2.jpg');">
                </div>
                <div class="card-content">
                    <div class="catgory-and-title">
                        <a href="services.php">Logistics</a>
                        <h3><a href="services.php">Logistics and Distribution</a></h3>
                    </div>
                    <p>Freight Transportation shipping solutions by road, rail, sea, and air, ensuring your goods reach
                        their destination safely.</p>
                </div>
            </li>
            <li class="service-single-item" data-show="#background-panel-2">
                <div class="responsive-bg-img"
                    style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img3.jpg');">
                </div>
                <div class="card-content">
                    <div class="catgory-and-title">
                        <a href="services.php">Road Freight</a>
                        <h3><a href="services.php">Road and Rail Freight</a></h3>
                    </div>
                    <p>Freight Transportation shipping solutions by road, rail, sea, and air, ensuring your goods reach
                        their destination safely.</p>
                </div>
            </li>
            <li class="service-single-item" data-show="#background-panel-3">
                <div class="responsive-bg-img"
                    style="background: linear-gradient(0deg, #000000 0%, rgba(0, 0, 0, 0) 67.82%), url('themes/theme3/assets/img/home3/img4.jpg');">
                </div>
                <div class="card-content">
                    <div class="catgory-and-title">
                        <a href="services.php">Warehousing</a>
                        <h3><a href="services.php">Warehousing and Distribution</a></h3>
                    </div>
                    <p>Freight Transportation shipping solutions by road, rail, sea, and air, ensuring your goods reach
                        their destination safely.</p>
                </div>
            </li>
        </ul>
    </div>
    <!-- End Interactive Banner Section -->

    <!-- Home3 Contact Info Start -->
    <div class="home2-contact-info two mb-130">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="col-xl-7 col-lg-8 wow animate fadeInLeft" data-wow-delay="200ms" data-wow-duration="2000ms"
                    style="visibility: visible; animation-duration: 2000ms; animation-delay: 200ms;">
                    <ul class="contact-list">
                        <li class="single-contact">
                            <div class="icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M17.5101 13.2102L14.9981 10.6982C14.101 9.8011 12.5759 10.16 12.217 11.3262C11.9479 12.1337 11.0508 12.5822 10.2434 12.4028C8.44911 11.9542 6.02686 9.62168 5.5783 7.73771C5.30916 6.93026 5.84744 6.03314 6.65485 5.76404C7.82112 5.40519 8.17997 3.88007 7.28284 2.98294L4.77089 0.470991C4.05319 -0.156997 2.97663 -0.156997 2.34864 0.470991L0.644104 2.17553C-1.06044 3.96978 0.82353 8.72455 5.04003 12.941C9.25652 17.1575 14.0113 19.1313 15.8055 17.337L17.5101 15.6324C18.1381 14.9147 18.1381 13.8382 17.5101 13.2102Z" />
                                    </g>
                                </svg>
                            </div>
                            <div class="contact-content">
                                <p>Call Us!</p>
                                <a href="tel:<?= htmlspecialchars($row['phone']) ?>"><?= htmlspecialchars($row['phone']) ?></a>
                            </div>
                        </li>
                        <li class="single-contact">
                            <div class="icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path
                                            d="M6.56248 13.2091V16.6876C6.56306 16.8058 6.60081 16.9208 6.6704 17.0164C6.73999 17.1119 6.83789 17.1832 6.95022 17.22C7.06256 17.2569 7.18363 17.2574 7.2963 17.2216C7.40897 17.1858 7.50752 17.1155 7.57798 17.0206L9.61273 14.2516L6.56248 13.2091ZM17.7637 0.104306C17.6792 0.044121 17.5797 0.00848417 17.4762 0.00133654C17.3727 -0.00581108 17.2692 0.015809 17.1772 0.0638058L0.302232 8.87631C0.205139 8.92762 0.125139 9.00617 0.0720502 9.1023C0.0189616 9.19843 -0.00490599 9.30798 0.00337671 9.41748C0.0116594 9.52699 0.051732 9.6317 0.118676 9.71875C0.185621 9.80581 0.276525 9.87143 0.380232 9.90756L5.07148 11.5111L15.0622 2.96856L7.33123 12.2828L15.1935 14.9701C15.2715 14.9963 15.3543 15.0051 15.4361 14.996C15.5179 14.9868 15.5967 14.9599 15.667 14.9171C15.7373 14.8743 15.7974 14.8167 15.8431 14.7482C15.8888 14.6798 15.9189 14.6021 15.9315 14.5208L17.994 0.645806C18.0092 0.543093 17.9958 0.438159 17.9552 0.342598C17.9146 0.247038 17.8483 0.164569 17.7637 0.104306Z" />
                                    </g>
                                </svg>
                            </div>
                            <div class="contact-content">
                                <p>Mail Us!</p>
                                <a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-3 col-lg-4 wow animate fadeInRight" data-wow-delay="200ms"
                    data-wow-duration="1500ms">
                    <a class="primary-btn2 white-bg btn-hover" href="services.php">
                        View All Service
                        <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z">
                                </path>
                            </g>
                        </svg>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Home3 Contact Info End -->

    <!-- Home3 Industries Section Start -->
    <div class="home3-industries-section mb-120">
        <div class="container">
            <div class="row align-items-center justify-content-center wow animate fadeInUp" data-wow-delay="200ms"
                data-wow-duration="2000ms">
                <div class="col-lg-6 mb-60">
                    <div class="section-title text-center">
                        <h2>Industry Solutions.</h2>
                        <p>We are more than a logistics provider; we are your trusted partner in global maritime
                            transport solutions.</p>
                    </div>
                </div>
            </div>
            <div class="transit-section mb-60 wow animate fadeInUp" data-wow-delay="400ms" data-wow-duration="4000ms">
                <span>100% Trust & Secure Supply Chain</span>
                <svg class="line" height="6" viewBox="0 0 1320 6" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM1315 3.5L1320 5.88675V0.113249L1315 2.5V3.5ZM4.5 3V3.5H1315.5V3V2.5H4.5V3Z">
                    </path>
                </svg>
                <div class="content">
                    <strong><span>>></span>54,000</strong>
                    <div class="right-content">
                        <div class="icon">
                            <svg width="68" height="68" viewBox="0 0 68 68" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M57.8718 34.4636L41.8607 67.4205C41.6673 67.7682 41.3193 68 40.8939 68H11.0594C10.2859 68 9.78316 67.1886 10.0925 66.4932L25.6783 34.4636C25.833 34.1545 25.833 33.8455 25.6783 33.5364L10.1699 1.50682C9.82183 0.811363 10.3246 0 11.1368 0H40.9712C41.3579 0 41.7447 0.231818 41.9381 0.579545L57.9492 33.5364C58.0265 33.8455 58.0265 34.1545 57.8718 34.4636Z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <p>We provide tailored shipping solutions for a variety of industries, ensures supply chain runs
                            smoothly.</p>
                    </div>
                </div>
            </div>
            <div class="swiper home3-industries-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="industries-card">
                            <a class="industries-img-wrap" href="services.php">
                                <img src="themes/theme3/assets/img/home1/service-card-img1.jpg" alt="">
                            </a>
                            <div class="industries-content">
                                <a href="services.php">
                                    Freight Transportation
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="industries-card">
                            <a class="industries-img-wrap" href="services.php">
                                <img src="themes/theme3/assets/img/home1/service-card-img2.jpg" alt="">
                            </a>
                            <div class="industries-content">
                                <a href="services.php">
                                    Logistics & Distribution
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="industries-card">
                            <a class="industries-img-wrap" href="services.php">
                                <img src="themes/theme3/assets/img/home1/service-card-img3.jpg" alt="">
                            </a>
                            <div class="industries-content">
                                <a href="services.php">
                                    Ground Transportation
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="industries-card">
                            <a class="industries-img-wrap" href="services.php">
                                <img src="themes/theme3/assets/img/home1/service-card-img4.jpg" alt="">
                            </a>
                            <div class="industries-content">
                                <a href="services.php">
                                    Reverse Logistics
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="industries-card">
                            <a class="industries-img-wrap" href="services.php">
                                <img src="themes/theme3/assets/img/home1/service-card-img1.jpg" alt="">
                            </a>
                            <div class="industries-content">
                                <a href="services.php">
                                    Ground Transportation
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="industries-card">
                            <a class="industries-img-wrap" href="services.php">
                                <img src="themes/theme3/assets/img/home1/service-card-img2.jpg" alt="">
                            </a>
                            <div class="industries-content">
                                <a href="services.php">
                                    Logistics & Distribution
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-60">
                <div class="col-lg-12 d-flex align-items-center justify-content-center">
                    <div class="slider-btn-grp">
                        <div class="slider-btn industries-slider-prev">
                            <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M9.59979 12C9.59979 9.17647 4.42774 6.94118 2.99979 6C4.68737 5.05882 9.59979 2.82353 9.59979 0"
                                        stroke-width="2" />
                                </g>
                            </svg>
                        </div>
                        <svg class="line" width="110" height="6" viewBox="0 0 110 6" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM105 3.5L110 5.88675V0.113249L105 2.5V3.5ZM4.5 3V3.5H105.5V3V2.5H4.5V3Z" />
                        </svg>
                        <div class="franctional-pagi2"></div>
                        <svg class="line" width="110" height="6" viewBox="0 0 110 6" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 2.5L0 0.113249V5.88675L5 3.5V2.5ZM105 3.5L110 5.88675V0.113249L105 2.5V3.5ZM4.5 3V3.5H105.5V3V2.5H4.5V3Z" />
                        </svg>
                        <div class="slider-btn industries-slider-next">
                            <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path d="M3 12C3 9.17647 8.17205 6.94118 9.6 6C7.91242 5.05882 3 2.82353 3 0"
                                        stroke-width="2" />
                                </g>
                            </svg>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home3 Industries Section End -->

    <!-- Home3 Banner Sectio  Start -->
    <div class="home2-company-banner-img  two">
    </div>
    <!-- Home3 Banner Sectio  End -->

    <!-- Home3 Process Step Start -->
    <div class="home3-process-section mb-120 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="2000ms">
        <div class="container">
            <div class="row justify-content-lg-end">
                <div class="col-lg-12">
                    <div class="process-wrapper">
                        <ul>
                            <li>
                                <div class="single-process">
                                    <div class="step-no">
                                        <span>Step</span>
                                        <strong>01</strong>
                                    </div>
                                    <div class="process-content">
                                        <h5>Request<br> a Quote</h5>
                                        <p>To quick response & fast delivery to fill the request form.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="single-process">
                                    <div class="step-no">
                                        <span>Step</span>
                                        <strong>02</strong>
                                    </div>
                                    <div class="process-content">
                                        <h5>Delivery<br> Cargo</h5>
                                        <p>Final destination, to get satisfcation with your buisness.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="single-process">
                                    <div class="step-no">
                                        <span>Step</span>
                                        <strong>03</strong>
                                    </div>
                                    <div class="process-content">
                                        <h5>Track<br> Shipment</h5>
                                        <p>Tracking your cargo shipment by using tracking ID.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home3 Process Step End -->



    <!-- Home3 Video Area Start -->
    <div class="home3-video-area mb-120">
        <video autoplay="" loop="" muted="" playsinline="" src="themes/theme3/assets/video/home3-video.mp4"></video>
        <div class="video-container-area">
            <div class="container">
                <div class="video-content">
                    <h2>We Move Your Business Forward</h2>
                    <a class="primary-btn2 btn-hover" href="contact.php">
                        Request a Quote
                        <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M5.83333 4.16667V0H4.16667V4.16667H0V5.83333H4.16667V10H5.83333V5.83333H10V4.16667H5.83333Z">
                                </path>
                            </g>
                        </svg>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Home3 Video Area Image End -->


    <!-- Footer Section Start -->
    
<?php include __DIR__ . '/footer.php'; ?>
