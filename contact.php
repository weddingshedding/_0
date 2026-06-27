<?php require_once __DIR__ . '/config.php';
$seo_title = 'Contact | ' . setting('business_name', 'Wedding Shedding');
$seo_description = 'Contact Wedding Shedding for wedding photography, cinematic wedding video, drone shoot and wedding shedding services.';
$success = '';
$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    try {
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $event_date = trim($_POST['event_date'] ?? '') ?: null;
        $message = trim($_POST['message'] ?? '');
        if ($name === '' || $phone === '') {
            throw new RuntimeException('Name and phone number are required.');
        }
        add_contact_message($name, $phone, $email, $event_date, $message);
        $success = 'Thank you. Your message has been saved. You can also book directly on WhatsApp.';
    } catch (Throwable $t) {
        $error = $t->getMessage();
    }
}
include __DIR__ . '/partials/header.php'; ?>
<main>
  <section class="section" style="padding-top:150px">
    <div class="container">
      <div class="section-title reveal">
        <span class="eyebrow">Contact</span>
        <h1 style="font-family:Playfair Display,Georgia,serif;color:var(--maroon);font-size:clamp(42px,6vw,76px);line-height:1;margin:18px 0;">Book your wedding date</h1>
        <p>Share your event details for photography, video, reels, drone shoot and wedding shedding services.</p>
      </div>
      <div class="contact-box">
        <aside class="glass-card reveal"><div class="card-body">
          <h3><?= e(setting('business_name', 'Wedding Shedding')) ?></h3>
          <p><strong>WhatsApp:</strong> <?= e(setting('whatsapp_number')) ?></p>
          <p><strong>Email:</strong> <?= e(setting('contact_email')) ?></p>
          <p><strong>Address:</strong> <?= e(setting('contact_address')) ?></p>
          <div class="hero-actions" style="margin-top:18px">
            <a class="btn btn-primary" href="<?= e(setting('whatsapp_link')) ?>" target="_blank" rel="noopener">WhatsApp</a>
            <a class="btn btn-gold" href="tel:<?= e(setting('call_number')) ?>">Call</a>
            <a class="btn btn-ghost" href="<?= e(setting('google_review_link')) ?>" target="_blank" rel="noopener">Review</a>
          </div>
        </div></aside>
        <div class="glass-card reveal"><div class="card-body">
          <?php if ($success): ?><div class="alert"><?= e($success) ?></div><?php endif; ?>
          <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
          <form class="form" method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="tel" name="phone" placeholder="Phone / WhatsApp Number" required>
            <input type="email" name="email" placeholder="Email Optional">
            <input type="date" name="event_date" placeholder="Event Date">
            <textarea name="message" placeholder="Event type, location, services required"></textarea>
            <button class="btn btn-primary" type="submit">Send Enquiry</button>
          </form>
        </div></div>
      </div>
      <div style="height:30px"></div>
      <iframe class="map reveal" src="<?= e(setting('map_embed')) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Wedding Shedding Google Map"></iframe>
    </div>
  </section>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
