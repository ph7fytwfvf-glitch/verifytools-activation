<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\AdminAuth;
use App\Database;

AdminAuth::requireLogin();
$db = Database::get();

if (isset($_GET['revoke']) && is_numeric($_GET['revoke'])) {
    $stmt = $db->prepare("UPDATE licenses SET status='revoked' WHERE id=:id");
    $stmt->execute([':id'=> (int)$_GET['revoke']]);
    header('Location: /admin/dashboard.php');
    exit;
}

$licenses = $db->query("SELECT * FROM licenses ORDER BY created_at DESC LIMIT 200")->fetchAll();
$activations = $db->query("SELECT a.*, l.license_key FROM activations a LEFT JOIN licenses l ON l.id = a.license_id ORDER BY a.activated_at DESC LIMIT 200")->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/assets/css/style.css"/>
  <style>table{width:100%;border-collapse:collapse}td,th{padding:8px;border:1px solid #eee}</style>
</head>
<body>
  <main style="max-width:1100px;margin:24px auto;">
    <h1>Admin Dashboard</h1>
    <p><a href="/admin.php?action=logout">Logout</a></p>

    <section>
      <h2>Licenses</h2>
      <table>
        <thead><tr><th>ID</th><th>Key</th><th>Email</th><th>Status</th><th>Expires</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($licenses as $l): ?>
          <tr>
            <td><?=htmlspecialchars($l['id'])?></td>
            <td><?=htmlspecialchars($l['license_key'])?></td>
            <td><?=htmlspecialchars($l['email'])?></td>
            <td><?=htmlspecialchars($l['status'])?></td>
            <td><?=htmlspecialchars($l['expires_at'])?></td>
            <td><a href="/admin/dashboard.php?revoke=<?=htmlspecialchars($l['id'])?>" onclick="return confirm('Revoke license?')">Revoke</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section style="margin-top:24px;">
      <h2>Activations</h2>
      <table>
        <thead><tr><th>ID</th><th>License</th><th>Email</th><th>Machine</th><th>IP</th><th>When</th></tr></thead>
        <tbody>
        <?php foreach ($activations as $a): ?>
          <tr>
            <td><?=htmlspecialchars($a['id'])?></td>
            <td><?=htmlspecialchars($a['license_key'])?></td>
            <td><?=htmlspecialchars($a['email'])?></td>
            <td><?=htmlspecialchars($a['machine_id'])?></td>
            <td><?=htmlspecialchars($a['ip'])?></td>
            <td><?=htmlspecialchars($a['activated_at'])?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
