<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Database;

if ($argc < 3) {
    echo "Usage: php create_admin.php username email [password]\n";
    exit(1);
}

$username = $argv[1];
$email = $argv[2];
$password = $argc >= 4 ? $argv[3] : bin2hex(random_bytes(8));

require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Database.php';

$pdo = App\Database::get();
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (:u,:e,:p)');
$stmt->execute([':u'=>$username,':e'=>$email,':p'=>$hash]);
echo "Created admin: $username with password: $password\n";
