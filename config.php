<?php
/**
 * Wedding Shedding - Main Configuration
 * Edit DB_NAME, DB_USER and DB_PASS after uploading to hosting.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');

// Database details
const DB_HOST = 'localhost';
const DB_NAME = 'wedding_shedding';
const DB_USER = 'root';
const DB_PASS = '';

// Admin Login - change after first deployment if needed
const ADMIN_USERNAME = '7503550936';
const ADMIN_PASSWORD = 'Anubha@2255';

// Keep blank for relative paths, or set full domain e.g. https://yourdomain.com
const SITE_URL = '';

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
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed. Please import database.sql and update config.php database details.');
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

function get_settings(): array
{
    global $pdo;
    static $settings = null;
    if ($settings !== null) {
        return $settings;
    }
    $settings = [];
    $stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
    foreach ($stmt as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

function setting(string $key, string $default = ''): string
{
    $settings = get_settings();
    return $settings[$key] ?? $default;
}

function update_setting(string $key, string $value): void
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
    $stmt->execute([$key, $value]);
}

function get_media(string $type = 'photo', ?string $category = null, int $limit = 200): array
{
    global $pdo;
    if ($category) {
        $stmt = $pdo->prepare('SELECT * FROM media WHERE media_type = ? AND category = ? ORDER BY sort_order ASC, id DESC LIMIT ' . (int)$limit);
        $stmt->execute([$type, $category]);
    } else {
        $stmt = $pdo->prepare('SELECT * FROM media WHERE media_type = ? ORDER BY sort_order ASC, id DESC LIMIT ' . (int)$limit);
        $stmt->execute([$type]);
    }
    return $stmt->fetchAll();
}

function get_categories(string $type = 'photo'): array
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT DISTINCT category FROM media WHERE media_type = ? AND category <> "" ORDER BY category ASC');
    $stmt->execute([$type]);
    return array_column($stmt->fetchAll(), 'category');
}

function require_admin(): void
{
    if (empty($_SESSION['admin_logged_in'])) {
        header('Location: index.php');
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
