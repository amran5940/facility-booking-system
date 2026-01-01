<?php
// Migrate data from SQLite to MySQL

// SQLite connection
$sqlite = new SQLite3(__DIR__ . '/writable/database/database.sqlite');

// MySQL connection
$mysqli = new mysqli('localhost', 'root', '', 'am_db');
if ($mysqli->connect_error) {
    die("MySQL connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');

// Tables to migrate
$tables = [
    'users',
    'agencies',
    'facility_categories',
    'facilities',
    'bookings',
    'blocked_dates',
    'facility_images',
    'payment_gateways',
    'agency_payment_gateways',
    'facility_category_fields',
    'facility_custom_values'
];

// Disable foreign key checks
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");

foreach ($tables as $table) {
    echo "Migrating table: $table\n";

    // Truncate MySQL table first
    $mysqli->query("TRUNCATE TABLE `$table`");
    if ($mysqli->error) {
        echo "Error truncating $table: " . $mysqli->error . "\n";
        continue;
    }

    // Get data from SQLite
    $result = $sqlite->query("SELECT * FROM $table");

    if (!$result) {
        echo "No data in $table or table doesn't exist\n";
        continue;
    }

    $rows = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rows[] = $row;
    }

    if (empty($rows)) {
        echo "No data to migrate for $table\n";
        continue;
    }

    // Get column names, exclude certain columns
    $columns = array_keys($rows[0]);
    $excludeColumns = [
        'users' => ['username'], // username was dropped
        'agencies' => ['code'], // code not in model
    ];

    if (isset($excludeColumns[$table])) {
        $columns = array_diff($columns, $excludeColumns[$table]);
    }

    $columnsList = '`' . implode('`, `', $columns) . '`';

    // Prepare MySQL insert
    $placeholders = str_repeat('?,', count($columns) - 1) . '?';
    $stmt = $mysqli->prepare("INSERT INTO `$table` ($columnsList) VALUES ($placeholders)");

    if (!$stmt) {
        echo "Error preparing statement for $table: " . $mysqli->error . "\n";
        continue;
    }

    // Insert each row
    foreach ($rows as $row) {
        // Remove excluded columns from row
        if (isset($excludeColumns[$table])) {
            foreach ($excludeColumns[$table] as $col) {
                unset($row[$col]);
            }
        }

        $values = array_values($row);
        $types = '';
        foreach ($values as $value) {
            if (is_null($value)) {
                $types .= 's';
            } elseif (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        $stmt->bind_param($types, ...$values);

        if (!$stmt->execute()) {
            echo "Error inserting into $table: " . $stmt->error . "\n";
        }
    }

    $stmt->close();
    echo "Migrated " . count($rows) . " rows for $table\n";
}

// Enable foreign key checks
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");

$sqlite->close();
$mysqli->close();

echo "Data migration completed!\n";
?>