<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/helpers.php';
?>

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4X7XCBWJZS"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-4X7XCBWJZS');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>
        <?php
        echo isset($page_title)
            ? $page_title
            : "Go-to-Market Consulting Services | Catalyst Inc.";
        ?>
    </title>
    <meta name="description"
        content="Expert Go-to-Market strategy consulting. Proven 6-step GTM framework to launch products and accelerate revenue growth. Free consultation available.">
    <meta property="og:title" content="Go-to-Market Consulting Services | Catalyst Inc.">
    <meta property="og:description"
        content="Expert Go-to-Market strategy consulting. Proven 6-step GTM framework to launch products and accelerate revenue growth. Free consultation available.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://go-to-market.jp/en/">
    <meta property="og:image" content="https://go-to-market.jp/assets/images/banner.webp">
    <meta property="og:site_name" content="Catalyst Inc.">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Go-to-Market Consulting Services | Catalyst Inc.">
    <meta name="twitter:description"
        content="Expert Go-to-Market strategy consulting. Proven 6-step GTM framework to launch products and accelerate revenue growth. Free consultation available.">
    <meta name="twitter:image" content="https://go-to-market.jp/assets/images/banner.webp">
    <meta property="og:locale" content="en_US">
    <link rel="canonical" href="https://go-to-market.jp/en/">
    <link rel="icon" href="/ICON.png" type="image/png">
    <link rel="stylesheet" href="<?= versionedAsset('output.css'); ?>">
    <link rel="stylesheet" href="<?= versionedAsset('custom.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="<?= versionedAsset('main.min.js'); ?>" defer="defer"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
