<?php require_once __DIR__ . '/config.php';
$seo_title = 'Video Gallery | ' . setting('business_name', 'Wedding Shedding');
$seo_description = 'Premium wedding video gallery with cinematic wedding films, lazy loading and lightbox viewer.';
include __DIR__ . '/partials/header.php';
$videos = get_media('video');
$categories = get_categories('video');
?>
<main>
  <section class="section" style="padding-top:150px">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Video Gallery</span>
        <h1 style="font-family:Playfair Display,Georgia,serif;color:var(--maroon);font-size:clamp(42px,6vw,76px);line-height:1;margin:18px 0;">Cinematic wedding films</h1>
        <p>Wedding video, cinematic highlights and complete event video coverage.</p>
      </div>
      <div class="filter-bar reveal">
        <button class="filter-btn active" data-filter="all">All</button>
        <?php foreach ($categories as $cat): ?><button class="filter-btn" data-filter="<?= e($cat) ?>"><?= e($cat) ?></button><?php endforeach; ?>
      </div>
      <div class="grid grid-3">
        <?php foreach ($videos as $video): ?>
          <article class="glass-card media-card reveal" data-category="<?= e($video['category']) ?>" data-lightbox data-type="video" data-src="<?= e($video['file_path']) ?>">
            <video src="<?= e($video['file_path']) ?>" preload="metadata" muted playsinline></video>
            <div class="media-caption"><strong><?= e($video['title']) ?></strong><br><span><?= e($video['category']) ?></span></div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<div class="lightbox"><button class="lightbox-close" aria-label="Close">×</button><div class="lightbox-content"></div></div>
<?php include __DIR__ . '/partials/footer.php'; ?>
