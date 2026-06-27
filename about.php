<?php require_once __DIR__ . '/config.php';
$seo_title = 'About | ' . setting('business_name', 'Wedding Shedding');
$seo_description = 'About Wedding Shedding premium wedding photography and cinematic wedding video services.';
include __DIR__ . '/partials/header.php'; ?>
<main>
  <section class="section" style="padding-top:150px">
    <div class="container split">
      <div class="reveal">
        <span class="eyebrow">About Wedding Shedding</span>
        <h1 style="font-family:Playfair Display,Georgia,serif;color:var(--maroon);font-size:clamp(42px,6vw,76px);line-height:1;margin:18px 0;">Premium wedding memories with cinematic detail.</h1>
        <p style="line-height:1.85;color:var(--muted);font-size:18px;">Wedding Shedding is a luxury wedding photography and video brand built for emotional, graceful and modern wedding storytelling. We cover weddings, engagements, receptions, family functions and pre-wedding shoots with a clean premium visual style.</p>
        <ul class="feature-list">
          <li>Professional wedding photography</li>
          <li>Candid and traditional photography coverage</li>
          <li>Cinematic wedding films, reels and drone shoots</li>
          <li>Clean delivery workflow and responsive booking support</li>
        </ul>
      </div>
      <div class="glass-card reveal"><img src="<?= e(setting('hero_background_image')) ?>" alt="Wedding Shedding About" loading="lazy"></div>
    </div>
  </section>
  <section class="section">
    <div class="container grid grid-3">
      <article class="glass-card reveal"><div class="card-body"><h3>Our Vision</h3><p>Create wedding visuals that feel royal, emotional and timeless.</p></div></article>
      <article class="glass-card reveal"><div class="card-body"><h3>Our Style</h3><p>Soft cream tones, gold highlights, elegant framing and cinematic motion.</p></div></article>
      <article class="glass-card reveal"><div class="card-body"><h3>Our Delivery</h3><p>Photo gallery, videos, reels and client-ready wedding memories.</p></div></article>
    </div>
  </section>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
