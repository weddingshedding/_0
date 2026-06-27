<?php
$seo_title = $seo_title ?? setting('business_name', 'Wedding Shedding') . ' | Premium Wedding Photography';
$seo_description = $seo_description ?? setting('hero_description', 'Premium wedding photography and cinematic wedding video services.');
$body_class = $body_class ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($seo_title) ?></title>
  <meta name="description" content="<?= e($seo_description) ?>">
  <meta name="keywords" content="wedding photography, pre wedding shoot, candid photography, wedding video, cinematic wedding video, drone shoot, wedding shedding">
  <meta name="robots" content="index,follow">
  <meta property="og:title" content="<?= e($seo_title) ?>">
  <meta property="og:description" content="<?= e($seo_description) ?>">
  <meta property="og:image" content="<?= e(site_url(setting('hero_background_image', 'assets/images/hero-wedding-bg.jpg'))) ?>">
  <meta property="og:type" content="website">
  <link rel="icon" href="<?= e(setting('logo_path', 'assets/images/logo.svg')) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <?= seo_schema() ?>
</head>
<body class="<?= e($body_class) ?>">
<div class="premium-loader"><div class="loader-ring"></div></div>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="logo" href="index.php" aria-label="Wedding Shedding Home">
      <img src="<?= e(setting('logo_path', 'assets/images/logo.svg')) ?>" alt="<?= e(setting('business_name', 'Wedding Shedding')) ?> Logo">
    </a>
    <nav class="nav-links" aria-label="Main Navigation">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="services.php">Services</a>
      <a href="gallery.php">Photo Gallery</a>
      <a href="videos.php">Video Gallery</a>
      <a href="reels.php">Reels</a>
      <a href="contact.php">Contact</a>
    </nav>
    <button class="menu-toggle" aria-label="Open menu">☰</button>
  </div>
</header>
<a class="secret-admin" href="sonu.php" aria-label="Secret Admin Button">SONU</a>
<div class="float-actions" aria-label="Quick contact buttons">
  <a href="<?= e(setting('whatsapp_link', 'https://wa.me/917503550936')) ?>" target="_blank" rel="noopener" title="WhatsApp">WA</a>
  <a href="tel:<?= e(setting('call_number', '+917503550936')) ?>" title="Call">☎</a>
  <a class="review" href="<?= e(setting('google_review_link', 'https://g.page/r/CaNUqaPpp9tuEBM/review')) ?>" target="_blank" rel="noopener" title="Google Review">★</a>
</div>
