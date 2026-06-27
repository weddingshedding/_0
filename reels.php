<?php require_once __DIR__ . '/config.php';
$seo_title = 'Reels | ' . setting('business_name', 'Wedding Shedding');
$seo_description = 'Instagram-style wedding reels gallery with lazy loading and lightbox viewer.';
include __DIR__ . '/partials/header.php';
$reels = get_media('reel');
$categories = get_categories('reel');
?>
<main>
  <section class="section" style="padding-top:150px">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Instagram-Style Reels</span>
        <h1 style="font-family:Playfair Display,Georgia,serif;color:var(--maroon);font-size:clamp(42px,6vw,76px);line-height:1;margin:18px 0;">Short wedding highlights</h1>
        <p>Portrait reels for Instagram, WhatsApp status and premium wedding highlights.</p>
      </div>
      <div class="filter-bar reveal">
        <button class="filter-btn active" data-filter="all">All</button>
        <?php foreach ($categories as $cat): ?><button class="filter-btn" data-filter="<?= e($cat) ?>"><?= e($cat) ?></button><?php endforeach; ?>
      </div>
      <div class="grid grid-3">
        <?php foreach ($reels as $reel): ?>
          <article class="glass-card media-card reel-card reveal" data-category="<?= e($reel['category']) ?>" data-lightbox data-type="video" data-src="<?= e($reel['file_path']) ?>">
            <video src="<?= e($reel['file_path']) ?>" preload="metadata" muted playsinline></video>
            <div class="media-caption"><strong><?= e($reel['title']) ?></strong><br><span><?= e($reel['category']) ?></span></div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<div class="lightbox"><button class="lightbox-close" aria-label="Close">×</button><div class="lightbox-content"></div></div>
<?php include __DIR__ . '/partials/footer.php'; ?>
