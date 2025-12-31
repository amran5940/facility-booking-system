<?php
// Build a fresh SQLite database for the CI4 app.
// Usage: php tools/build_sqlite.php

declare(strict_types=1);

$pdo = new PDO('sqlite:C:\xampp\htdocs\am\writable\database\database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = [
    "DROP TABLE IF EXISTS bookings;",
    "DROP TABLE IF EXISTS facilities;",
    "DROP TABLE IF EXISTS facility_custom_values;",
    "DROP TABLE IF EXISTS facility_category_fields;",
    "DROP TABLE IF EXISTS facility_categories;",
    "DROP TABLE IF EXISTS users;",
    "DROP TABLE IF EXISTS agencies;",
    // Agencies
    "CREATE TABLE agencies (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE,
        code TEXT UNIQUE,
        description TEXT,
        status TEXT NOT NULL DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );",
    // Users
    "CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        full_name TEXT,
        phone TEXT,
        date_of_birth DATE,
        address TEXT,
        gender TEXT,
        role TEXT NOT NULL CHECK (role IN ('admin','manager','user')),
        agency_id INTEGER,
        user_type TEXT DEFAULT 'public' CHECK (user_type IN ('public','agency')),
        approved INTEGER DEFAULT 1,
        agency_application_status TEXT DEFAULT 'none' CHECK (agency_application_status IN ('none','pending','approved','rejected')),
        requested_agency_id INTEGER,
        application_notes TEXT,
        status TEXT NOT NULL DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE SET NULL,
        FOREIGN KEY (requested_agency_id) REFERENCES agencies(id) ON DELETE SET NULL
    );",
    // Facility Categories
    "CREATE TABLE facility_categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE,
        description TEXT,
        created_by INTEGER NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    );",
    // Facility Category Fields
    "CREATE TABLE facility_category_fields (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER NOT NULL,
        field_name TEXT NOT NULL,
        field_label TEXT NOT NULL,
        field_type TEXT NOT NULL DEFAULT 'text' CHECK (field_type IN ('text','textarea','number','date','select','checkbox')),
        options TEXT,
        required INTEGER DEFAULT 0,
        sort_order INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES facility_categories(id) ON DELETE CASCADE
    );",
    // Facilities
    "CREATE TABLE facilities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        description TEXT,
        category_id INTEGER NOT NULL,
        agency_id INTEGER,
        type TEXT NOT NULL CHECK (type IN ('public','agency')),
        status TEXT NOT NULL DEFAULT 'active',
        capacity INTEGER,
        location TEXT,
        latitude REAL,
        longitude REAL,
        created_by INTEGER NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES facility_categories(id),
        FOREIGN KEY (agency_id) REFERENCES agencies(id),
        FOREIGN KEY (created_by) REFERENCES users(id)
    );",
    // Facility Custom Values
    "CREATE TABLE facility_custom_values (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        facility_id INTEGER NOT NULL,
        field_id INTEGER NOT NULL,
        field_value TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE,
        FOREIGN KEY (field_id) REFERENCES facility_category_fields(id) ON DELETE CASCADE
    );",
    // Facility Images
    "CREATE TABLE facility_images (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        facility_id INTEGER NOT NULL,
        image_data BLOB NOT NULL,
        image_type TEXT NOT NULL,
        is_primary INTEGER DEFAULT 0,
        sort_order INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE
    );",
    // Bookings
    "CREATE TABLE bookings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        facility_id INTEGER NOT NULL,
        start_date DATETIME NOT NULL,
        end_date DATETIME NOT NULL,
        status TEXT NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','approved','cancelled')),
        notes TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (facility_id) REFERENCES facilities(id)
    );",
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

echo "SQLite DB built successfully\n";