<?php require_once __DIR__ . '/../config.php';
if (!empty($_SESSION['admin_logged_in'])) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin Login | Wedding Shedding</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body>
  <main class="admin-login">
    <form class="login-card" method="post">
      <img src="../<?= e(setting('logo_path', 'assets/images/logo.svg')) ?>" class="preview-logo" alt="Wedding Shedding Logo">
      <h1>SONU Admin Login</h1>
      <p class="muted">Hidden admin panel for gallery, videos, reels, homepage and contact management.</p>
      <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
      <label>Username</label>
      <input type="text" name="username" placeholder="7503550936" required>
      <label>Password</label>
      <input type="password" name="password" placeholder="Password" required>
      <div style="height:16px"></div>
      <button class="btn" type="submit">Login</button>
      <a class="btn gold" style="margin-left:8px" href="../index.php">Back to Website</a>
    </form>
  </main>
</body></html>
