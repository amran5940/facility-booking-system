<?php
// Check tables in SQLite database
$pdo = new PDO('sqlite:C:\xampp\htdocs\am\writable\database\database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "Tables in database:\n";
foreach ($tables as $table) {
    echo "- $table\n";
}

// Check users table columns
if (in_array('users', $tables)) {
    echo "\nUsers table columns:\n";
    $stmt = $pdo->query("PRAGMA table_info(users)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo "- {$col['name']} ({$col['type']})\n";
    }
}
