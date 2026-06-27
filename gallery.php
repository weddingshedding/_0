<?php require_once __DIR__ . '/config.php';
$seo_title = 'Photo Gallery | ' . setting('business_name', 'Wedding Shedding');
$seo_description = 'Premium wedding photo gallery with category filters, lazy loading and lightbox viewer.';
include __DIR__ . '/partials/header.php';
$photos = get_media('photo');
$categories = get_categories('photo');
?>
<main>
  <section class="section" style="padding-top:150px">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Photo Gallery</span>
        <h1 style="font-family:Playfair Display,Georgia,serif;color:var(--maroon);font-size:clamp(42px,6vw,76px);line-height:1;margin:18px 0;">Luxury wedding frames</h1>
        <p>Explore wedding photography, pre-wedding shoots, candid frames and traditional coverage.</p>
      </div>
      <div class="filter-bar reveal">
        <button class="filter-btn active" data-filter="all">All</button>
        <?php foreach ($categories as $cat): ?><button class="filter-btn" data-filter="<?= e($cat) ?>"><?= e($cat) ?></button><?php endforeach; ?>
      </div>
      <div class="grid grid-3">
        <?php foreach ($photos as $photo): ?>
          <article class="glass-card media-card reveal" data-category="<?= e($photo['category']) ?>" data-lightbox data-type="image" data-src="<?= e($photo['file_path']) ?>">
            <img class="gallery-img" src="<?= e($photo['file_path']) ?>" alt="<?= e($photo['alt_text'] ?: $photo['title']) ?>" loading="lazy">
            <div class="media-caption"><strong><?= e($photo['title']) ?></strong><br><span><?= e($photo['category']) ?></span></div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<div class="lightbox"><button class="lightbox-close" aria-label="Close">×</button><div class="lightbox-content"></div></div>
<?php include __DIR__ . '/partials/footer.php'; ?>
