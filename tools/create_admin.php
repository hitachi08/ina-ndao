<?php
// tools/create_admin.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';

$username = $argv[1] ?? 'admin';
$email = $argv[2] ?? 'admin@example.com';
$password = $argv[3] ?? 'ChangeMe123!';

$id = Auth::register($pdo, $username, $email, $password);
echo "Admin created (id={$id}). Username={$username}, password={$password}\n";
