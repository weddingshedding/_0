<?php require_once __DIR__ . '/config.php';
if (!empty($_SESSION['admin_logged_in'])) { header('Location: admin/dashboard.php'); exit; }
$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (admin_credentials_valid($username, $password)) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin/dashboard.php');
        exit;
    }
    $error = 'Invalid private login details.';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <title>Private Login | Wedding Shedding</title>
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
  <main class="admin-login secret-login-page">
    <form class="login-card" method="post" autocomplete="off">
      <img src="<?= e(setting('logo_path', 'assets/images/logo.svg')) ?>" class="preview-logo" alt="Wedding Shedding Logo">
      <h1>SONU Private Panel</h1>
      <p class="muted">Hidden admin access. Details are protected and not shown.</p>
      <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
      <label>Private ID</label>
      <input type="password" name="username" placeholder="Private ID" required autocomplete="off" inputmode="numeric" aria-label="Private ID">
      <label>Password</label>
      <input type="password" name="password" placeholder="Password" required autocomplete="new-password" aria-label="Password">
      <div style="height:16px"></div>
      <button class="btn" type="submit">Open Dashboard</button>
      <a class="btn gold" style="margin-left:8px" href="index.php">Back to Website</a>
    </form>
  </main>
</body>
</html>
