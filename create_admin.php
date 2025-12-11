<?php

// Bootstrap CodeIgniter
require_once 'app/Config/Paths.php';
require_once 'vendor/autoload.php';

use CodeIgniter\Config\DotEnv;
use Config\Database;

// Load environment
$dotenv = new DotEnv(ROOTPATH);
$dotenv->load();

$db = Database::connect();

$data = [
    'email' => 'admin@example.com',
    'password' => password_hash('password123', PASSWORD_DEFAULT),
    'full_name' => 'Administrator',
    'phone' => '0123456789',
    'role' => 'admin',
    'user_type' => 'public',
    'approved' => 1,
    'status' => 'active',
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
];

try {
    $db->table('users')->insert($data);
    echo "Admin user created successfully!\n";
    echo "Email: admin@example.com\n";
    echo "Password: password123\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}