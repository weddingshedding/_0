<?php
/**
 * Wedding Shedding - Main Configuration
 * PHP 8+ / MySQL
 * Admin ID and password are stored as bcrypt hashes, not plain text.
 * The front site and admin also work in local JSON fallback mode until MySQL is connected.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');

// Database details - update these on hosting after creating MySQL database.
const DB_HOST = 'localhost';
const DB_NAME = 'wedding_shedding';
const DB_USER = 'root';
const DB_PASS = '';

// Admin credentials are hidden as bcrypt hashes. Do not replace with plain text.
const ADMIN_USERNAME_HASH = '$2y$12$A7TRwBP/paZf.oVE1kQ4tuBpF9ar7CtDNIiwt3tT2n8kOwaLLBSw.';
const ADMIN_PASSWORD_HASH = '$2y$12$sv6HP8RFa.u14A6hxbfNNexm75qSR9Z1H5NgkY1uGQz5ctvk5aWAK';

// Keep blank for relative paths, or set full domain e.g. https://yourdomain.com
const SITE_URL = '';

$pdo = null;
$db_error = '';
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (Throwable $e) {
    // Website/admin will still open with local JSON fallback until MySQL is connected.
    $pdo = null;
    $db_error = 'Database is not connected. Admin is using local JSON fallback until database.sql is imported and config.php is updated.';
}

function db_ready(): bool
{
    global $pdo;
    return $pdo instanceof PDO;
}

function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function site_url(string $path = ''): string
{
    $base = rtrim(SITE_URL, '/');
    $path = ltrim($path, '/');
    return $base ? $base . '/' . $path : $path;
}

function data_dir(): string
{
    return __DIR__ . '/data';
}

function data_file(): string
{
    return data_dir() . '/site-data.json';
}

function ensure_data_dir(): void
{
    if (!is_dir(data_dir())) {
        mkdir(data_dir(), 0755, true);
    }
    $htaccess = data_dir() . '/.htaccess';
    if (!is_file($htaccess)) {
        file_put_contents($htaccess, "Require all denied\nDeny from all\n");
    }
}

function default_settings(): array
{
    return [
        'business_name' => 'Wedding Shedding',
        'site_tagline' => 'Premium Wedding Photography & Cinematic Films',
        'logo_path' => 'assets/images/logo.svg',
        'hero_background_image' => 'assets/images/hero-wedding-bg.jpg',
        'hero_background_video' => '',
        'hero_heading' => "Professional Wedding Photography,\nCinematic Wedding Video &\nWedding Shedding Services",
        'hero_description' => 'We provide professional wedding photography, pre-wedding shoots, candid photography, traditional photography, wedding videos, cinematic wedding films, drone shoots and wedding shedding services for weddings, engagements, receptions and family functions.',
        'whatsapp_number' => '+91 7503550936',
        'whatsapp_link' => 'https://wa.me/917503550936',
        'call_number' => '+917503550936',
        'google_review_link' => 'https://g.page/r/CaNUqaPpp9tuEBM/review',
        'contact_email' => 'booking@weddingshedding.com',
        'contact_address' => 'India',
        'map_embed' => 'https://www.google.com/maps?q=Wedding%20Photography%20India&output=embed',
        'service_wedding_photography' => 'assets/images/service-wedding-photography.svg',
        'service_pre_wedding_shoot' => 'assets/images/service-pre-wedding-shoot.svg',
        'service_candid_photography' => 'assets/images/service-candid-photography.svg',
        'service_traditional_photography' => 'assets/images/service-traditional-photography.svg',
        'service_wedding_video' => 'assets/images/service-wedding-video.svg',
        'service_cinematic_wedding_video' => 'assets/images/service-cinematic-wedding-video.svg',
        'service_drone_shoot' => 'assets/images/service-drone-shoot.svg',
        'service_wedding_shedding' => 'assets/images/service-wedding-shedding.svg',
    ];
}

function default_media_all(): array
{
    return [
        ['id' => 1001, 'media_type' => 'photo', 'title' => 'Royal Wedding Moment', 'category' => 'Wedding', 'file_path' => 'assets/images/gallery-photo-1.svg', 'alt_text' => 'Luxury wedding photography moment', 'sort_order' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 1002, 'media_type' => 'photo', 'title' => 'Pre Wedding Romance', 'category' => 'Pre-Wedding', 'file_path' => 'assets/images/gallery-photo-2.svg', 'alt_text' => 'Premium pre wedding photography', 'sort_order' => 2, 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 1003, 'media_type' => 'photo', 'title' => 'Candid Ceremony Smile', 'category' => 'Candid', 'file_path' => 'assets/images/gallery-photo-3.svg', 'alt_text' => 'Candid wedding photography', 'sort_order' => 3, 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2001, 'media_type' => 'video', 'title' => 'Cinematic Wedding Film', 'category' => 'Wedding Film', 'file_path' => 'assets/videos/sample-video.mp4', 'alt_text' => 'Cinematic wedding video sample', 'sort_order' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 3001, 'media_type' => 'reel', 'title' => 'Wedding Reel Highlight', 'category' => 'Reels', 'file_path' => 'assets/videos/sample-reel.mp4', 'alt_text' => 'Instagram style wedding reel', 'sort_order' => 1, 'created_at' => date('Y-m-d H:i:s')],
    ];
}

function default_media(string $type = 'photo'): array
{
    return array_values(array_filter(default_media_all(), fn($row) => $row['media_type'] === $type));
}

function default_json_data(): array
{
    return [
        'settings' => default_settings(),
        'media' => default_media_all(),
        'contact_messages' => [],
        'next_media_id' => 4001,
        'next_message_id' => 1,
    ];
}

function load_json_data(): array
{
    ensure_data_dir();
    $file = data_file();
    if (!is_file($file)) {
        $data = default_json_data();
        save_json_data($data);
        return $data;
    }
    $raw = file_get_contents($file);
    $data = json_decode($raw ?: '', true);
    if (!is_array($data)) {
        $data = default_json_data();
    }
    $seed = default_json_data();
    $data['settings'] = array_merge($seed['settings'], $data['settings'] ?? []);
    $data['media'] = array_values($data['media'] ?? $seed['media']);
    $data['contact_messages'] = array_values($data['contact_messages'] ?? []);
    $data['next_media_id'] = (int)($data['next_media_id'] ?? 4001);
    $data['next_message_id'] = (int)($data['next_message_id'] ?? 1);
    return $data;
}

function save_json_data(array $data): void
{
    ensure_data_dir();
    file_put_contents(data_file(), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function get_settings(): array
{
    global $pdo;
    $settings = default_settings();
    if ($pdo) {
        try {
            $stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
            foreach ($stmt as $row) {
                if ($row['setting_value'] !== null && $row['setting_value'] !== '') {
                    $settings[$row['setting_key']] = $row['setting_value'];
                }
            }
            return $settings;
        } catch (Throwable $e) {
            // If tables are not imported yet, continue with local JSON fallback.
        }
    }
    $data = load_json_data();
    return array_merge($settings, $data['settings'] ?? []);
}

function setting(string $key, string $default = ''): string
{
    $settings = get_settings();
    return (string)($settings[$key] ?? $default);
}

function update_setting(string $key, string $value): void
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
            $stmt->execute([$key, $value]);
            return;
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    $data['settings'][$key] = $value;
    save_json_data($data);
}

function get_media(string $type = 'photo', ?string $category = null, int $limit = 200): array
{
    global $pdo;
    if ($pdo) {
        try {
            if ($category) {
                $stmt = $pdo->prepare('SELECT * FROM media WHERE media_type = ? AND category = ? ORDER BY sort_order ASC, id DESC LIMIT ' . (int)$limit);
                $stmt->execute([$type, $category]);
            } else {
                $stmt = $pdo->prepare('SELECT * FROM media WHERE media_type = ? ORDER BY sort_order ASC, id DESC LIMIT ' . (int)$limit);
                $stmt->execute([$type]);
            }
            $rows = $stmt->fetchAll();
            if ($rows) { return $rows; }
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    $rows = array_filter($data['media'] ?? [], function($row) use ($type, $category) {
        if (($row['media_type'] ?? '') !== $type) return false;
        if ($category !== null && ($row['category'] ?? '') !== $category) return false;
        return true;
    });
    usort($rows, fn($a, $b) => ((int)($a['sort_order'] ?? 0) <=> (int)($b['sort_order'] ?? 0)) ?: ((int)($b['id'] ?? 0) <=> (int)($a['id'] ?? 0)));
    return array_slice(array_values($rows), 0, $limit);
}

function get_categories(string $type = 'photo'): array
{
    $rows = get_media($type, null, 500);
    $cats = array_values(array_unique(array_filter(array_map(fn($row) => (string)($row['category'] ?? ''), $rows))));
    sort($cats, SORT_NATURAL | SORT_FLAG_CASE);
    return $cats;
}

function add_media_item(string $type, string $title, string $category, string $filePath, string $altText = '', int $sortOrder = 0): int
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('INSERT INTO media (media_type, title, category, file_path, alt_text, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$type, $title, $category, $filePath, $altText, $sortOrder]);
            return (int)$pdo->lastInsertId();
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    $id = (int)($data['next_media_id'] ?? 4001);
    $data['next_media_id'] = $id + 1;
    $data['media'][] = [
        'id' => $id,
        'media_type' => $type,
        'title' => $title ?: ucfirst($type) . ' Item',
        'category' => $category ?: ucfirst($type),
        'file_path' => $filePath,
        'alt_text' => $altText,
        'sort_order' => $sortOrder,
        'created_at' => date('Y-m-d H:i:s'),
    ];
    save_json_data($data);
    return $id;
}

function update_media_item(int $id, string $title, string $category, string $altText, int $sortOrder): void
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('UPDATE media SET title = ?, category = ?, alt_text = ?, sort_order = ? WHERE id = ?');
            $stmt->execute([$title, $category, $altText, $sortOrder, $id]);
            return;
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    foreach ($data['media'] as &$row) {
        if ((int)($row['id'] ?? 0) === $id) {
            $row['title'] = $title;
            $row['category'] = $category;
            $row['alt_text'] = $altText;
            $row['sort_order'] = $sortOrder;
            break;
        }
    }
    unset($row);
    save_json_data($data);
}

function get_media_file_path(int $id): ?string
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('SELECT file_path FROM media WHERE id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) return (string)$row['file_path'];
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    foreach ($data['media'] as $row) {
        if ((int)($row['id'] ?? 0) === $id) return (string)($row['file_path'] ?? '');
    }
    return null;
}

function delete_media_item(int $id): void
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('DELETE FROM media WHERE id = ?');
            $stmt->execute([$id]);
            return;
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    $data['media'] = array_values(array_filter($data['media'], fn($row) => (int)($row['id'] ?? 0) !== $id));
    save_json_data($data);
}

function add_contact_message(string $name, string $phone, string $email, ?string $eventDate, string $message): void
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('INSERT INTO contact_messages (name, phone, email, event_date, message) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $phone, $email, $eventDate, $message]);
            return;
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    $id = (int)($data['next_message_id'] ?? 1);
    $data['next_message_id'] = $id + 1;
    $data['contact_messages'][] = [
        'id' => $id,
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'event_date' => $eventDate,
        'message' => $message,
        'created_at' => date('Y-m-d H:i:s'),
    ];
    save_json_data($data);
}

function get_contact_messages(int $limit = 20): array
{
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->query('SELECT * FROM contact_messages ORDER BY id DESC LIMIT ' . (int)$limit);
            return $stmt->fetchAll();
        } catch (Throwable $e) {}
    }
    $data = load_json_data();
    $rows = $data['contact_messages'] ?? [];
    usort($rows, fn($a, $b) => (int)($b['id'] ?? 0) <=> (int)($a['id'] ?? 0));
    return array_slice($rows, 0, $limit);
}

function admin_credentials_valid(string $username, string $password): bool
{
    return password_verify($username, ADMIN_USERNAME_HASH) && password_verify($password, ADMIN_PASSWORD_HASH);
}

function require_admin(): void
{
    if (empty($_SESSION['admin_logged_in'])) {
        $inAdminFolder = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/');
        header('Location: ' . ($inAdminFolder ? '../sonu.php' : 'sonu.php'));
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function check_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            die('Security token mismatch. Refresh and try again.');
        }
    }
}

function upload_file(string $field, string $folder, array $allowedExtensions, int $maxBytes = 52428800): ?string
{
    if (empty($_FILES[$field]['name']) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed. Please try again.');
    }
    if ($_FILES[$field]['size'] > $maxBytes) {
        throw new RuntimeException('File too large. Max allowed size is ' . round($maxBytes / 1048576) . 'MB.');
    }

    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions, true)) {
        throw new RuntimeException('Invalid file type. Allowed: ' . implode(', ', $allowedExtensions));
    }

    $folder = trim($folder, '/');
    $targetDir = __DIR__ . '/' . $folder;
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '-', pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME));
    $fileName = date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '-' . substr($safeName, 0, 60) . '.' . $ext;
    $targetPath = $targetDir . '/' . $fileName;

    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
        throw new RuntimeException('Could not save uploaded file. Check folder permission.');
    }
    return $folder . '/' . $fileName;
}

function seo_schema(): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => setting('business_name', 'Wedding Shedding'),
        'url' => SITE_URL ?: '',
        'telephone' => setting('whatsapp_number', '+91 7503550936'),
        'image' => site_url(setting('logo_path', 'assets/images/logo.svg')),
        'description' => setting('hero_description', ''),
        'sameAs' => [setting('google_review_link', 'https://g.page/r/CaNUqaPpp9tuEBM/review')]
    ];
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}
?>
