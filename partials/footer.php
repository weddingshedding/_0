<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <img src="<?= e(setting('logo_path', 'assets/images/logo.svg')) ?>" alt="Wedding Shedding Logo">
        <p><?= e(setting('site_tagline', 'Premium Wedding Photography & Cinematic Films')) ?></p>
        <p>Wedding photography, cinematic wedding videos, pre-wedding shoots, candid moments, drone shoots and wedding shedding services.</p>
      </div>
      <div>
        <h3>Pages</h3>
        <p><a href="about.php">About</a><br><a href="services.php">Services</a><br><a href="gallery.php">Photo Gallery</a><br><a href="videos.php">Video Gallery</a><br><a href="reels.php">Reels</a></p>
      </div>
      <div>
        <h3>Contact</h3>
        <p><?= e(setting('whatsapp_number', '+91 7503550936')) ?><br><?= e(setting('contact_email', 'booking@weddingshedding.com')) ?><br><?= e(setting('contact_address', 'India')) ?></p>
      </div>
    </div>
    <div class="copyright">© <?= date('Y') ?> <?= e(setting('business_name', 'Wedding Shedding')) ?>. All rights reserved.</div>
  </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<script src="assets/js/main.js" defer></script>
</body>
</html>
