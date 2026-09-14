<?php
// This file lives at themes/{theme}/header.php -- resources/ is two levels
// up, at the project root, regardless of which theme is active or how this
// page was reached (dispatcher, direct hit, etc.), so resolve it via __DIR__
// rather than a CWD-relative path. Used by every INNER page (about, contact,
// tracking, etc.) -- the 5 homepage variants each have their own distinct
// header instead (see courier-service.php, freight.php, etc.) but share the
// same head.php boilerplate.
require_once __DIR__ . '/head.php';
?>
    <!-- header Section Start-->
    <header class="header-area style-2">
        <div class="container-fluid d-flex flex-nowrap align-items-center justify-content-between">
            <div class="logo-and-menu-area">
                <a href="index.php" class="header-logo">
                    <img src="resources/img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:42px;">
                </a>
                <div class="main-menu">
                    <div class="mobile-logo-area d-xl-none d-flex align-items-center justify-content-between">
                        <a href="index.php" class="mobile-logo-wrap">
                            <img src="resources/img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:32px;">
                        </a>
                        <div class="menu-close-btn">
                            <i class="bi bi-x"></i>
                        </div>
                    </div>
                    <?php include __DIR__ . '/nav.php'; ?>
                    <a class="primary-btn2 btn-hover d-xl-none d-flex justify-content-center"
                        href="tracking.php">
                        Track &amp; Trace
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
            <div class="nav-right">
                <div class="translator-area">
                    <?php include __DIR__ . '/../../resources/translator.php'; ?>
                </div>
                <div class="contact-area">
                    <div class="search-and-login">
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
