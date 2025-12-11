<?php
// Check migrations table structure
$pdo = new PDO('sqlite:C:\xampp\htdocs\am\writable\database\database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Migrations table structure:\n";
$stmt = $pdo->query("PRAGMA table_info(migrations)");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "- {$col['name']} ({$col['type']})\n";
}

echo "\nCurrent migrations:\n";
$stmt = $pdo->query("SELECT * FROM migrations");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    print_r($row);
}
