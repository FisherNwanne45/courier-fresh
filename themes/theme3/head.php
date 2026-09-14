<?php
// This file lives at themes/{theme}/head.php -- resources/ is two levels
// up, at the project root, regardless of which theme is active or how this
// page was reached (dispatcher, direct hit, etc.), so resolve it via __DIR__
// rather than a CWD-relative path.
require_once __DIR__ . '/../../resources/config.php';

$pageTitle = $pageTitle ?? $row['name'];
$pageDescription = $pageDescription ?? ($row['name'] . ' - global freight, courier and logistics services.');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">

    <link href="themes/theme3/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="themes/theme3/assets/css/jquery-ui.css" rel="stylesheet">
    <link href="themes/theme3/assets/css/bootstrap-icons.css" rel="stylesheet">
    <link href="themes/theme3/assets/css/animate.min.css" rel="stylesheet">
    <link href="themes/theme3/assets/css/jquery.fancybox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="themes/theme3/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="themes/theme3/assets/css/slick.css">
    <link rel="stylesheet" href="themes/theme3/assets/css/slick-theme.css">
    <link rel="stylesheet" href="themes/theme3/assets/css/daterangepicker.css">
    <link href="themes/theme3/assets/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="themes/theme3/assets/css/style.css">
    <title><?= htmlspecialchars($pageTitle) ?> &middot; <?= htmlspecialchars($row['name']) ?></title>
    <link rel="icon" href="resources/img/<?= htmlspecialchars($row['favicon'] ?? '') ?>">
    <style>
        /* Theme3's own look for the shared translator widget (see
           resources/translator.php) -- Google's real widget, styled in
           place, matching the same light/dark cue the menu text itself
           follows on each header variant:
             - style-1 (home-main.php, freight.php) and style-3
               (international-logistics.php) sit over a real dark hero /
               solid dark bar, white menu text throughout -- translator
               stays light throughout too.
             - style-2 (maritime-transport.php + every interior page) and
               style-4 (courier-service.php) are NOT fixed over a hero --
               they sit on the page's plain white background, dark menu
               text from the start -- translator matches, dark throughout.
           Languages come from admin Appearance settings. */
        .translator-area { display: flex; align-items: center; }
        .translator-area .site-translator .goog-te-gadget-simple,
        .translator-area .site-translator .site-translator-trigger {
            background-color: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 13px;
            display: inline-block;
            cursor: pointer;
            transition: background-color .3s, border-color .3s;
        }
        .translator-area .site-translator .goog-te-gadget-simple a,
        .translator-area .site-translator .goog-te-gadget-simple a span,
        .translator-area .site-translator .site-translator-trigger a,
        .translator-area .site-translator .site-translator-trigger a span {
            color: #fff !important;
            text-decoration: none !important;
        }
        header.style-2 .translator-area .site-translator .goog-te-gadget-simple,
        header.style-4 .translator-area .site-translator .goog-te-gadget-simple,
        header.style-2 .translator-area .site-translator .site-translator-trigger,
        header.style-4 .translator-area .site-translator .site-translator-trigger {
            background-color: rgba(0, 0, 0, 0.04);
            border-color: rgba(0, 0, 0, 0.15);
        }
        header.style-2 .translator-area .site-translator .goog-te-gadget-simple a,
        header.style-2 .translator-area .site-translator .goog-te-gadget-simple a span,
        header.style-4 .translator-area .site-translator .goog-te-gadget-simple a,
        header.style-4 .translator-area .site-translator .goog-te-gadget-simple a span,
        header.style-2 .translator-area .site-translator .site-translator-trigger a,
        header.style-2 .translator-area .site-translator .site-translator-trigger a span,
        header.style-4 .translator-area .site-translator .site-translator-trigger a,
        header.style-4 .translator-area .site-translator .site-translator-trigger a span {
            color: var(--black-color, #1a1a1a) !important;
        }
    </style>
</head>

<body class="tt-magic-cursor">

    <div id="magic-cursor">
        <div id="ball"></div>
    </div>

    <!-- Back To Top -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
        <svg class="arrow" width="22" height="25" viewBox="0 0 24 23" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0.556131 11.4439L11.8139 0.186067L13.9214 2.29352L13.9422 20.6852L9.70638 20.7061L9.76793 8.22168L3.6064 14.4941L0.556131 11.4439Z" />
            <path d="M23.1276 11.4999L16.0288 4.40105L15.9991 10.4203L20.1031 14.5243L23.1276 11.4999Z" />
        </svg>
    </div>
