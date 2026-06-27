<?php
require_once __DIR__ . '/../config.php';
require_admin();
check_csrf();
$message = '';
$error = '';
$services = [
 'service_wedding_photography' => 'Wedding Photography',
 'service_pre_wedding_shoot' => 'Pre-Wedding Shoot',
 'service_candid_photography' => 'Candid Photography',
 'service_traditional_photography' => 'Traditional Photography',
 'service_wedding_video' => 'Wedding Video',
 'service_cinematic_wedding_video' => 'Cinematic Wedding Video',
 'service_drone_shoot' => 'Drone Shoot',
 'service_wedding_shedding' => 'Wedding Shedding',
];
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'update_home') {
            update_setting('hero_heading', trim($_POST['hero_heading'] ?? ''));
            update_setting('hero_description', trim($_POST['hero_description'] ?? ''));
            update_setting('site_tagline', trim($_POST['site_tagline'] ?? ''));
            $message = 'Homepage text updated.';
        }
        if ($action === 'update_contact') {
            foreach (['business_name','whatsapp_number','whatsapp_link','call_number','google_review_link','contact_email','contact_address','map_embed'] as $key) {
                update_setting($key, trim($_POST[$key] ?? ''));
            }
            $message = 'Contact details updated.';
        }
        if ($action === 'upload_media') {
            $type = $_POST['media_type'] ?? 'photo';
            if (!in_array($type, ['photo','video','reel'], true)) { throw new RuntimeException('Invalid media type.'); }
            $folder = $type === 'photo' ? 'uploads/photos' : ($type === 'video' ? 'uploads/videos' : 'uploads/reels');
            $allowed = $type === 'photo' ? ['jpg','jpeg','png','webp','gif','svg'] : ['mp4','webm','mov'];
            $max = $type === 'photo' ? 10485760 : 209715200;
            $file = upload_file('media_file', $folder, $allowed, $max);
            if (!$file) { throw new RuntimeException('Please choose a file.'); }
            $stmt = $pdo->prepare('INSERT INTO media (media_type, title, category, file_path, alt_text, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$type, trim($_POST['title'] ?? ''), trim($_POST['category'] ?? ''), $file, trim($_POST['alt_text'] ?? ''), (int)($_POST['sort_order'] ?? 0)]);
            $message = ucfirst($type) . ' uploaded successfully.';
        }
        if ($action === 'delete_media') {
            $id = (int)($_POST['id'] ?? 0);
            $stmt = $pdo->prepare('SELECT file_path FROM media WHERE id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                $path = realpath(__DIR__ . '/../' . $row['file_path']);
                $root = realpath(__DIR__ . '/..');
                if ($path && $root && str_starts_with($path, $root) && is_file($path) && !str_contains($row['file_path'], 'assets/')) {
                    @unlink($path);
                }
                $pdo->prepare('DELETE FROM media WHERE id = ?')->execute([$id]);
            }
            $message = 'Media deleted.';
        }
        if ($action === 'upload_logo') {
            $file = upload_file('logo_file', 'uploads/logo', ['jpg','jpeg','png','webp','svg'], 10485760);
            if ($file) { update_setting('logo_path', $file); $message = 'Logo updated.'; }
        }
        if ($action === 'upload_background_image') {
            $file = upload_file('background_image', 'uploads/backgrounds', ['jpg','jpeg','png','webp','svg'], 15728640);
            if ($file) { update_setting('hero_background_image', $file); $message = 'Homepage background image updated.'; }
        }
        if ($action === 'upload_background_video') {
            $file = upload_file('background_video', 'uploads/backgrounds', ['mp4','webm','mov'], 209715200);
            if ($file) { update_setting('hero_background_video', $file); $message = 'Homepage background video updated.'; }
        }
        if ($action === 'remove_background_video') {
            update_setting('hero_background_video', '');
            $message = 'Homepage background video removed. Image background will be used.';
        }
        if ($action === 'upload_service_image') {
            $key = $_POST['service_key'] ?? '';
            if (!array_key_exists($key, $services)) { throw new RuntimeException('Invalid service.'); }
            $file = upload_file('service_image', 'uploads/services', ['jpg','jpeg','png','webp','svg'], 10485760);
            if ($file) { update_setting($key, $file); $message = $services[$key] . ' image updated.'; }
        }
    }
} catch (Throwable $t) { $error = $t->getMessage(); }
$photos = get_media('photo', null, 500);
$videos = get_media('video', null, 500);
$reels = get_media('reel', null, 500);
$messages = $pdo->query('SELECT * FROM contact_messages ORDER BY id DESC LIMIT 20')->fetchAll();
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Dashboard | Wedding Shedding</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
<div class="admin-shell">
  <aside class="sidebar">
    <img src="../<?= e(setting('logo_path', 'assets/images/logo.svg')) ?>" alt="Logo">
    <h2>Dashboard</h2>
    <a href="#upload">Upload Media</a>
    <a href="#gallery">Edit Gallery</a>
    <a href="#branding">Logo & Background</a>
    <a href="#services">Service Images</a>
    <a href="#homepage">Homepage Text</a>
    <a href="#contact">Contact Details</a>
    <a href="#messages">Messages</a>
    <a href="../index.php" target="_blank">View Website</a>
    <a href="logout.php">Logout</a>
  </aside>
  <main class="main">
    <div class="topbar"><div><h1>Wedding Shedding Admin</h1><p class="muted">Upload photos, videos, reels and manage premium website content.</p></div><a class="btn" href="logout.php">Logout</a></div>
    <?php if ($message): ?><div class="alert"><?= e($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>

    <section id="upload" class="panel-card">
      <h2>Upload Photos / Videos / Reels</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="upload_media">
        <div class="row">
          <div><label>Media Type</label><select name="media_type"><option value="photo">Photo</option><option value="video">Video</option><option value="reel">Reel</option></select></div>
          <div><label>File</label><input type="file" name="media_file" required></div>
        </div>
        <div class="row">
          <div><label>Title</label><input type="text" name="title" placeholder="Royal Wedding Moment"></div>
          <div><label>Category</label><input type="text" name="category" placeholder="Wedding / Pre-Wedding / Candid"></div>
        </div>
        <div class="row">
          <div><label>Alt Text / SEO Text</label><input type="text" name="alt_text" placeholder="Premium wedding photography"></div>
          <div><label>Sort Order</label><input type="number" name="sort_order" value="0"></div>
        </div>
        <div style="height:14px"></div><button class="btn" type="submit">Upload</button>
      </form>
    </section>

    <section id="gallery" class="panel-card full">
      <h2>Edit Gallery</h2>
      <h3>Photos</h3><?php render_media_admin($photos); ?>
      <h3>Videos</h3><?php render_media_admin($videos, true); ?>
      <h3>Reels</h3><?php render_media_admin($reels, true); ?>
    </section>

    <div class="panel-grid">
      <section id="branding" class="panel-card">
        <h2>Change Website Logo</h2>
        <form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="upload_logo"><label>Logo File</label><input type="file" name="logo_file" required><div style="height:14px"></div><button class="btn" type="submit">Update Logo</button></form>
        <h2>Homepage Background Image</h2>
        <form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="upload_background_image"><label>Background Image</label><input type="file" name="background_image" required><div style="height:14px"></div><button class="btn" type="submit">Update Background Image</button></form>
      </section>
      <section class="panel-card">
        <h2>Homepage Background Video</h2>
        <p class="muted">Upload MP4/WebM for cinematic homepage video. If blank, image background is used.</p>
        <form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="upload_background_video"><label>Background Video</label><input type="file" name="background_video" required><div style="height:14px"></div><button class="btn" type="submit">Update Video</button></form>
        <form method="post" style="margin-top:12px"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="remove_background_video"><button class="btn danger" type="submit">Remove Background Video</button></form>
      </section>
    </div>

    <section id="services" class="panel-card">
      <h2>Change Service Images</h2>
      <div class="service-upload">
        <?php foreach ($services as $key => $label): ?>
        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="upload_service_image"><input type="hidden" name="service_key" value="<?= e($key) ?>">
          <label><?= e($label) ?></label><input type="file" name="service_image" required><button class="btn gold" type="submit" style="margin-top:10px">Update</button>
        </form>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="homepage" class="panel-card">
      <h2>Manage Homepage Text</h2>
      <form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="update_home">
        <label>Site Tagline</label><input type="text" name="site_tagline" value="<?= e(setting('site_tagline')) ?>">
        <label>Hero Heading</label><textarea name="hero_heading"><?= e(setting('hero_heading')) ?></textarea>
        <label>Hero Description</label><textarea name="hero_description"><?= e(setting('hero_description')) ?></textarea>
        <div style="height:14px"></div><button class="btn" type="submit">Save Homepage Text</button>
      </form>
    </section>

    <section id="contact" class="panel-card">
      <h2>Manage Contact Details</h2>
      <form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="update_contact">
        <div class="row"><div><label>Business Name</label><input name="business_name" value="<?= e(setting('business_name')) ?>"></div><div><label>WhatsApp Number</label><input name="whatsapp_number" value="<?= e(setting('whatsapp_number')) ?>"></div></div>
        <div class="row"><div><label>WhatsApp Link</label><input name="whatsapp_link" value="<?= e(setting('whatsapp_link')) ?>"></div><div><label>Call Number</label><input name="call_number" value="<?= e(setting('call_number')) ?>"></div></div>
        <div class="row"><div><label>Google Review Link</label><input name="google_review_link" value="<?= e(setting('google_review_link')) ?>"></div><div><label>Email</label><input name="contact_email" value="<?= e(setting('contact_email')) ?>"></div></div>
        <label>Address</label><input name="contact_address" value="<?= e(setting('contact_address')) ?>">
        <label>Google Map Embed URL</label><input name="map_embed" value="<?= e(setting('map_embed')) ?>">
        <div style="height:14px"></div><button class="btn" type="submit">Save Contact</button>
      </form>
    </section>

    <section id="messages" class="panel-card">
      <h2>Latest Contact Messages</h2>
      <?php if (!$messages): ?><p class="muted">No messages yet.</p><?php endif; ?>
      <?php foreach ($messages as $msg): ?>
        <div class="media-item" style="padding:14px;margin-bottom:10px"><strong><?= e($msg['name']) ?></strong> — <?= e($msg['phone']) ?><br><span class="mini"><?= e($msg['email']) ?> | <?= e($msg['event_date']) ?> | <?= e($msg['created_at']) ?></span><p><?= e($msg['message']) ?></p></div>
      <?php endforeach; ?>
    </section>
  </main>
</div>
</body></html>
<?php
function render_media_admin(array $items, bool $video = false): void
{
    if (!$items) { echo '<p class="muted">No media found.</p>'; return; }
    echo '<div class="media-list">';
    foreach ($items as $item) {
        echo '<div class="media-item">';
        if ($video) {
            echo '<video src="../' . e($item['file_path']) . '" controls preload="metadata"></video>';
        } else {
            echo '<img src="../' . e($item['file_path']) . '" alt="' . e($item['title']) . '">';
        }
        echo '<div class="body"><strong>' . e($item['title']) . '</strong><br><span class="mini">' . e($item['category']) . '</span>';
        echo '<form method="post" onsubmit="return confirm(\'Delete this media?\')" style="margin-top:10px"><input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '"><input type="hidden" name="action" value="delete_media"><input type="hidden" name="id" value="' . (int)$item['id'] . '"><button class="btn danger" type="submit">Delete</button></form></div></div>';
    }
    echo '</div>';
}
?>
