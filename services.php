<?php require_once __DIR__ . '/config.php';
$seo_title = 'Services | ' . setting('business_name', 'Wedding Shedding');
$seo_description = 'Wedding Photography, Pre-Wedding Shoot, Candid Photography, Traditional Photography, Wedding Video, Cinematic Wedding Video, Drone Shoot and Wedding Shedding services.';
include __DIR__ . '/partials/header.php';
$services = [
 ['Wedding Photography','Full wedding day coverage with premium portraits, rituals, family moments and edited wedding frames.','service_wedding_photography'],
 ['Pre-Wedding Shoot','Romantic couple shoot planning with elegant locations, cinematic posing and luxury visual treatment.','service_pre_wedding_shoot'],
 ['Candid Photography','Real smiles, emotional rituals, family moments and natural wedding reactions captured beautifully.','service_candid_photography'],
 ['Traditional Photography','Complete ceremony coverage with clear family photos, rituals, group photos and stage memories.','service_traditional_photography'],
 ['Wedding Video','Full event video coverage for wedding, engagement, reception and family functions.','service_wedding_video'],
 ['Cinematic Wedding Video','Film-style wedding storytelling with music, transitions, color grading and emotional highlights.','service_cinematic_wedding_video'],
 ['Drone Shoot','Premium aerial shots for venues, entries, couple moments and cinematic wedding highlights.','service_drone_shoot'],
 ['Wedding Shedding','Professional wedding shedding service coverage for complete wedding functions and family events.','service_wedding_shedding'],
];
?>
<main>
  <section class="section" style="padding-top:150px">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Premium Services</span>
        <h1 style="font-family:Playfair Display,Georgia,serif;color:var(--maroon);font-size:clamp(42px,6vw,76px);line-height:1;margin:18px 0;">Wedding photography, video and wedding shedding services.</h1>
        <p>No decoration packages are included. This website focuses only on photography, video, drone, reels and wedding shedding services.</p>
      </div>
      <div class="grid grid-4">
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
  <section class="section"><div class="container cta reveal"><h2>Need booking for your date?</h2><p>Send your event date, location and service requirement. We will respond on WhatsApp.</p><a class="btn btn-gold" href="<?= e(setting('whatsapp_link')) ?>" target="_blank" rel="noopener">Book on WhatsApp</a></div></section>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
