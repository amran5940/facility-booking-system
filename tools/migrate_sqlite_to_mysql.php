<?php
// Migrate data from SQLite to MySQL while keeping the schema aligned.
// Usage: php tools/migrate_sqlite_to_mysql.php

declare(strict_types=1);

$sqlitePath = 'C:\\xampp\\htdocs\\am\\writable\\database\\database.sqlite';
$mysqlDsn   = 'mysql:host=localhost;dbname=am;charset=utf8mb4';
$mysqlUser  = 'root';
$mysqlPass  = '';

$sqlite = new PDO("sqlite:$sqlitePath");
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sqlite->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$mysql = new PDO($mysqlDsn, $mysqlUser, $mysqlPass);
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Recreate schema to match SQLite exactly.
$schema = [
    "SET FOREIGN_KEY_CHECKS = 0;",
    "DROP TABLE IF EXISTS blocked_dates;",
    "DROP TABLE IF EXISTS bookings;",
    "DROP TABLE IF EXISTS facility_custom_values;",
    "DROP TABLE IF EXISTS facilities;",
    "DROP TABLE IF EXISTS facility_category_fields;",
    "DROP TABLE IF EXISTS facility_categories;",
    "DROP TABLE IF EXISTS users;",
    "DROP TABLE IF EXISTS agencies;",
    "DROP TABLE IF EXISTS migrations;",
    "SET FOREIGN_KEY_CHECKS = 1;",
    "CREATE TABLE migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        version VARCHAR(255) NOT NULL,
        class VARCHAR(255) NOT NULL,
        `group` VARCHAR(255) NOT NULL,
        `namespace` VARCHAR(255) NOT NULL,
        time INT NOT NULL,
        batch INT NOT NULL
    ) ENGINE=InnoDB;",
    "CREATE TABLE agencies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        code VARCHAR(50) UNIQUE,
        description TEXT,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",
    "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255),
        phone VARCHAR(50),
        date_of_birth DATE,
        address TEXT,
        gender VARCHAR(20),
        role ENUM('admin','manager','user') NOT NULL,
        agency_id INT,
        user_type ENUM('public','agency') DEFAULT 'public',
        approved TINYINT(1) DEFAULT 1,
        agency_application_status ENUM('none','pending','approved','rejected') DEFAULT 'none',
        requested_agency_id INT,
        application_notes TEXT,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE SET NULL,
        FOREIGN KEY (requested_agency_id) REFERENCES agencies(id) ON DELETE SET NULL
    ) ENGINE=InnoDB;",
    "CREATE TABLE facility_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        created_by INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB;",
    "CREATE TABLE facility_category_fields (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT NOT NULL,
        field_name VARCHAR(100) NOT NULL,
        field_label VARCHAR(255) NOT NULL,
        field_type ENUM('text','textarea','number','date','select','checkbox') NOT NULL DEFAULT 'text',
        options TEXT,
        required TINYINT(1) DEFAULT 0,
        sort_order INT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES facility_categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE facilities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        category_id INT NOT NULL,
        agency_id INT,
        type ENUM('public','agency') NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        capacity INT,
        location VARCHAR(255),
        created_by INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES facility_categories(id),
        FOREIGN KEY (agency_id) REFERENCES agencies(id),
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB;",
    "CREATE TABLE facility_custom_values (
        id INT AUTO_INCREMENT PRIMARY KEY,
        facility_id INT NOT NULL,
        field_id INT NOT NULL,
        field_value TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE,
        FOREIGN KEY (field_id) REFERENCES facility_category_fields(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    "CREATE TABLE bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        facility_id INT NOT NULL,
        start_date DATETIME NOT NULL,
        end_date DATETIME NOT NULL,
        status ENUM('pending','approved','cancelled') NOT NULL DEFAULT 'pending',
        notes TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (facility_id) REFERENCES facilities(id)
    ) ENGINE=InnoDB;",
    "CREATE TABLE blocked_dates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        facility_id INT NOT NULL,
        blocked_date DATE NOT NULL,
        reason TEXT,
        created_by INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_facility_date (facility_id, blocked_date),
        FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
];

foreach ($schema as $sql) {
    $mysql->exec($sql);
}

$tables = [
    'migrations' => ['id', 'version', 'class', 'group', 'namespace', 'time', 'batch'],
    'agencies' => ['id', 'name', 'code', 'description', 'status', 'created_at', 'updated_at'],
    'users' => ['id', 'username', 'email', 'password', 'full_name', 'phone', 'date_of_birth', 'address', 'gender', 'role', 'agency_id', 'user_type', 'approved', 'agency_application_status', 'requested_agency_id', 'application_notes', 'status', 'created_at', 'updated_at'],
    'facility_categories' => ['id', 'name', 'description', 'created_by', 'created_at', 'updated_at'],
    'facility_category_fields' => ['id', 'category_id', 'field_name', 'field_label', 'field_type', 'options', 'required', 'sort_order', 'created_at', 'updated_at'],
    'facilities' => ['id', 'name', 'description', 'category_id', 'agency_id', 'type', 'status', 'capacity', 'location', 'created_by', 'created_at', 'updated_at'],
    'facility_custom_values' => ['id', 'facility_id', 'field_id', 'field_value', 'created_at', 'updated_at'],
    'bookings' => ['id', 'user_id', 'facility_id', 'start_date', 'end_date', 'status', 'notes', 'created_at', 'updated_at'],
    'blocked_dates' => ['id', 'facility_id', 'blocked_date', 'reason', 'created_by', 'created_at', 'updated_at'],
];

$mysql->beginTransaction();

foreach ($tables as $table => $columns) {
    $colList = implode(',', array_map(fn($c) => "`$c`", $columns));
    $placeholders = ':' . implode(',:', $columns);
    $insert = $mysql->prepare("INSERT INTO `$table` ($colList) VALUES ($placeholders)");

    $rows = $sqlite->query('SELECT ' . implode(',', array_map(fn($c) => "`$c`", $columns)) . " FROM `$table`");
    foreach ($rows as $row) {
        foreach ($columns as $col) {
            $value = $row[$col];
            if ($value === null) {
                $insert->bindValue(":" . $col, null, PDO::PARAM_NULL);
            } else {
                $insert->bindValue(":" . $col, $value);
            }
        }
        $insert->execute();
    }
}

$mysql->commit();

echo "Data migrated from SQLite to MySQL.\n";
