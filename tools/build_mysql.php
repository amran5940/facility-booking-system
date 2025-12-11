<?php
// Build a fresh MySQL database for the CI4 app.
// Usage: php tools/build_mysql.php

declare(strict_types=1);

$pdo = new PDO('mysql:host=localhost;dbname=am', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = [
    "SET FOREIGN_KEY_CHECKS = 0;",
    "DROP TABLE IF EXISTS bookings;",
    "DROP TABLE IF EXISTS facilities;",
    "DROP TABLE IF EXISTS facility_custom_values;",
    "DROP TABLE IF EXISTS facility_category_fields;",
    "DROP TABLE IF EXISTS facility_categories;",
    "DROP TABLE IF EXISTS users;",
    "DROP TABLE IF EXISTS agencies;",
    "SET FOREIGN_KEY_CHECKS = 1;",
    // Agencies
    "CREATE TABLE agencies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        code VARCHAR(50) UNIQUE,
        description TEXT,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",
    // Users
    "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255),
        role ENUM('admin','manager','user') NOT NULL,
        agency_id INT,
        user_type ENUM('public','agency') DEFAULT 'public',
        approved TINYINT(1) DEFAULT 1,
        status VARCHAR(20) NOT NULL DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE SET NULL
    ) ENGINE=InnoDB;",
    // Facility Categories
    "CREATE TABLE facility_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        created_by INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB;",
    // Facility Category Fields
    "CREATE TABLE facility_category_fields (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT NOT NULL,
        field_name VARCHAR(100) NOT NULL,
        field_label VARCHAR(255) NOT NULL,
        field_type ENUM('text','textarea','number','date','select','checkbox') NOT NULL DEFAULT 'text',
        options TEXT, -- JSON for select options
        required TINYINT(1) DEFAULT 0,
        sort_order INT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES facility_categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",
    // Facilities
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
    // Bookings
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
];

foreach ($schema as $sql) {
    $pdo->exec($sql);
}

// Seed data
$pdo->beginTransaction();
$pdo->prepare('INSERT INTO agencies (name, code, description) VALUES (?,?,?)')
    ->execute(['Contoh Agensi', 'AGY001', 'Agensi contoh untuk demo']);
$agencyId = $pdo->lastInsertId();

$insertUser = $pdo->prepare('INSERT INTO users (username, email, password, full_name, role, agency_id, user_type, approved) VALUES (?,?,?,?,?,?,?,?)');
$insertUser->execute(['admin', 'admin@example.com', password_hash('password', PASSWORD_BCRYPT), 'Pentadbir Sistem', 'admin', null, 'public', 1]);
$insertUser->execute(['manager', 'manager@example.com', password_hash('password', PASSWORD_BCRYPT), 'Pengurus Agensi', 'manager', $agencyId, 'agency', 1]);
$insertUser->execute(['user', 'user@example.com', password_hash('password', PASSWORD_BCRYPT), 'Pengguna Biasa', 'user', null, 'public', 1]);

$pdo->prepare('INSERT INTO facility_categories (name, description, created_by) VALUES (?,?,?)')
    ->execute(['Hall', 'Meeting halls and auditoriums', 1]);
$pdo->prepare('INSERT INTO facility_categories (name, description, created_by) VALUES (?,?,?)')
    ->execute(['Hostel', 'Accommodation facilities', 1]);
$pdo->prepare('INSERT INTO facility_categories (name, description, created_by) VALUES (?,?,?)')
    ->execute(['Court', 'Sports courts', 1]);
$pdo->prepare('INSERT INTO facility_categories (name, description, created_by) VALUES (?,?,?)')
    ->execute(['Vehicle', 'Transportation vehicles', 1]);

$pdo->commit();

echo "MySQL DB built in database 'am'\n";