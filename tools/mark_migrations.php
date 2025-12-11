<?php
// Mark migrations as applied since build_sqlite.php already created the schema
$pdo = new PDO('sqlite:C:\xampp\htdocs\am\writable\database\database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$migrations = [
    ['App', '2025-12-06-011248', 'AddAgencyApplicationFields', 'default'],
    ['App', '2025-12-06-011917', 'AddUserAdditionalFields', 'default'],
    ['App', '2025-12-08-030248', 'DropUsernameFromUsers', 'default'],
];

$pdo->beginTransaction();

foreach ($migrations as $index => $migration) {
    [$namespace, $version, $class, $group] = $migration;
    
    $stmt = $pdo->prepare("INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $version,
        $class,
        $group,
        $namespace,
        time(),
        1
    ]);
    
    echo "Marked migration: $class\n";
}

$pdo->commit();
echo "\nAll migrations marked as applied!\n";
