<?php
// Hidden admin login is intentionally not available at /admin/.
// Open it only from the small SONU button on the website.
http_response_code(404);
require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>404 | Wedding Shedding</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body><main class="admin-login"><div class="login-card"><h1>Page not found</h1><p class="muted">This page is private.</p><a class="btn gold" href="../index.php">Back to Website</a></div></main></body>
</html>
