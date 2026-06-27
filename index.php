<?php require_once __DIR__ . '/config.php';
$seo_title = setting('business_name', 'Wedding Shedding') . ' | Professional Wedding Photography & Cinematic Video';
$seo_description = setting('hero_description', 'Premium wedding photography and cinematic wedding film services.');
include __DIR__ . '/partials/header.php';
$photos = get_media('photo', null, 6);
$services = [
 ['Wedding Photography','Royal wedding coverage with premium editing.','service_wedding_photography'],
 ['Pre-Wedding Shoot','Romantic outdoor and cinematic couple shoot.','service_pre_wedding_shoot'],
 ['Candid Photography','Natural emotions, smiles and real family moments.','service_candid_photography'],
 ['Cinematic Wedding Video','Film-style wedding story with music and color grading.','service_cinematic_wedding_video'],
 ['Drone Shoot','Aerial wedding shots for premium highlights.','service_drone_shoot'],
 ['Wedding Shedding','Professional wedding shedding services for complete functions.','service_wedding_shedding'],
];
?>
<main>
  <section class="hero" style="--hero-bg:url('<?= e(setting('hero_background_image', 'assets/images/hero-wedding-bg.jpg')) ?>')">
    <?php if (setting('hero_background_video')): ?>
      <video class="hero-video" src="<?= e(setting('hero_background_video')) ?>" autoplay muted loop playsinline></video>
    <?php else: ?>
      <img class="hero-bg" src="<?= e(setting('hero_background_image', 'assets/images/hero-wedding-bg.jpg')) ?>" alt="Wedding Shedding cinematic wedding background" loading="eager" onerror="this.style.display='none'">
    <?php endif; ?>
    <canvas id="weddingScene" class="hero-canvas" aria-hidden="true"></canvas>
    <div class="container hero-content">
      <div data-parallax>
        <span class="eyebrow">Luxury Wedding Studio</span>
        <h1><?= nl2br(e(setting('hero_heading'))) ?></h1>
        <p><?= e(setting('hero_description')) ?></p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="<?= e(setting('whatsapp_link')) ?>" target="_blank" rel="noopener">Book on WhatsApp</a>
          <a class="btn btn-gold" href="gallery.php">View Gallery</a>
          <a class="btn btn-ghost" href="<?= e(setting('google_review_link')) ?>" target="_blank" rel="noopener">Google Reviews</a>
        </div>
      </div>
      <aside class="hero-card" data-parallax>
        <div class="hero-card-inner">
          <div>
            <div class="ring-mark">∞</div>
            <h3>Cinematic memories crafted with premium detail.</h3>
            <div class="shine-line"></div>
            <p>From engagement to reception, every frame is planned with soft light, graceful motion and emotional storytelling.</p>
          </div>
          <a class="btn btn-gold" href="contact.php">Plan Your Wedding Shoot</a>
        </div>
      </aside>
    </div>
  </section>

  <section class="section">
    <div class="container stats reveal">
      <div class="stat"><strong data-count="500">500</strong><span>Events Captured</span></div>
      <div class="stat"><strong data-count="8">8</strong><span>Premium Services</span></div>
      <div class="stat"><strong data-count="4">4</strong><span>Gallery Formats</span></div>
      <div class="stat"><strong data-count="24">24</strong><span>Booking Support</span></div>
    </div>
  </section>

  <section class="section" id="services">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Our Services</span>
        <h2>Wedding visuals with a premium cinematic finish.</h2>
        <p>Photography and video services built for weddings, engagements, receptions, family functions and pre-wedding stories.</p>
      </div>
      <div class="grid grid-3">
        <?php foreach ($services as $service): ?>
        <article class="glass-card service-card reveal">
          <img class="service-img" src="<?= e(setting($service[2])) ?>" alt="<?= e($service[0]) ?>" loading="lazy">
          <div class="card-body">
            <h3><?= e($service[0]) ?></h3>
            <p><?= e($service[1]) ?></p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container split">
      <div class="reveal">
        <span class="eyebrow">About Studio</span>
        <h2 class="gold-text" style="font-family:Playfair Display,Georgia,serif;font-size:54px;line-height:1.05;margin:16px 0;">Elegant, emotional and hosting-ready storytelling.</h2>
        <p style="line-height:1.8;color:var(--muted);">Wedding Shedding creates clean, luxury wedding visuals with premium editing, careful composition and cinematic motion. The style is soft, royal and modern without using heavy dark backgrounds.</p>
        <ul class="feature-list">
          <li>✓ Candid + traditional coverage</li>
          <li>✓ Cinematic video, reels and drone options</li>
          <li>✓ Fast gallery loading with lightbox viewing</li>
        </ul>
      </div>
      <div class="glass-card reveal"><img src="<?= e(setting('hero_background_image')) ?>" alt="Wedding Shedding premium wedding visual" loading="lazy"></div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Photo Gallery</span>
        <h2>Selected wedding frames</h2>
      </div>
      <div class="grid grid-3">
        <?php foreach ($photos as $photo): ?>
          <article class="glass-card media-card reveal" data-lightbox data-type="image" data-src="<?= e($photo['file_path']) ?>">
            <img src="<?= e($photo['file_path']) ?>" alt="<?= e($photo['alt_text'] ?: $photo['title']) ?>" loading="lazy">
            <div class="media-caption"><strong><?= e($photo['title']) ?></strong><br><span><?= e($photo['category']) ?></span></div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container cta reveal">
      <h2>Book your wedding shoot on WhatsApp.</h2>
      <p>Share date, location, event type and requirement. We will guide you for photography, video, cinematic film, drone shoot and reels.</p>
      <a class="btn btn-gold" href="<?= e(setting('whatsapp_link')) ?>" target="_blank" rel="noopener">Book on WhatsApp</a>
    </div>
  </section>
</main>
<div class="lightbox"><button class="lightbox-close" aria-label="Close">×</button><div class="lightbox-content"></div></div>
<?php include __DIR__ . '/partials/footer.php'; ?>
