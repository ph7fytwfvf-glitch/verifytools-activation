<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\AdminAuth;

session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (AdminAuth::login($username, $password)) {
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        $errors[] = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Admin Login</title>
  <link rel="stylesheet" href="/assets/css/style.css"/>
</head>
<body>
  <main style="max-width:420px;margin:48px auto;">
    <h2>Admin Login</h2>
    <?php foreach ($errors as $e): ?>
      <div class="alert error"><?=htmlspecialchars($e)?></div>
    <?php endforeach; ?>
    <form method="post" action="/admin.php">
      <label>Username</label>
      <input name="username" required />
      <label>Password</label>
      <input name="password" type="password" required />
      <button type="submit">Sign in</button>
    </form>
  </main>
</body>
</html>
