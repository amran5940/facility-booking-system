<?php
// Migration Runner Script for Hosting
// Usage: php run_migrations.php

require_once __DIR__ . '/vendor/autoload.php';

use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Config;
use CodeIgniter\Database\MigrationRunner;

// Load environment (optional)
if (file_exists(__DIR__ . '/.env')) {
    // Note: This script assumes .env is already loaded by the web server
    // or environment variables are set manually
}

try {
    // Get database config
    $config = config('Database');

    // Create database connection
    $db = \Config\Database::connect();

    // Test connection
    $db->connect();

    echo "✅ Database connection successful!\n";

    // Create migration runner
    $runner = Services::migrations();

    // Get migration status
    $migrations = $runner->findMigrations();
    $history = $runner->getHistory();

    echo "\n📋 Migration Status:\n";
    echo "+-----------+-------------------+----------------------------+---------+---------------------+-------+\n";
    echo "| Namespace | Version           | Filename                   | Group   | Migrated On         | Batch |\n";
    echo "+-----------+-------------------+----------------------------+---------+---------------------+-------+\n";

    foreach ($migrations as $migration) {
        $version = $migration->version;
        $filename = basename($migration->path);
        $namespace = $migration->namespace;

        $migrated = false;
        $batch = '';
        $migratedOn = '';

        foreach ($history as $hist) {
            if ($hist['version'] == $version) {
                $migrated = true;
                $batch = $hist['batch'];
                $migratedOn = $hist['migrated_on'];
                break;
            }
        }

        if ($migrated) {
            echo sprintf("| %-9s | %-17s | %-26s | %-7s | %-19s | %-5s |\n",
                $namespace, $version, substr($filename, 0, 26), 'default', $migratedOn, $batch);
        } else {
            echo sprintf("| %-9s | %-17s | %-26s | %-7s | %-19s | %-5s |\n",
                $namespace, $version, substr($filename, 0, 26), 'default', 'PENDING', '');
        }
    }

    echo "+-----------+-------------------+----------------------------+---------+---------------------+-------+\n";

    // Count pending migrations
    $pending = array_filter($migrations, function($migration) use ($history) {
        foreach ($history as $hist) {
            if ($hist['version'] == $migration->version) {
                return false;
            }
        }
        return true;
    });

    if (count($pending) > 0) {
        echo "\n⚠️  Found " . count($pending) . " pending migration(s)\n";
        echo "Run: php spark migrate\n";
    } else {
        echo "\n✅ All migrations are up to date!\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";

    // Provide troubleshooting tips
    echo "\n🔧 Troubleshooting Tips:\n";
    echo "1. Check database credentials in .env file\n";
    echo "2. Ensure database exists and user has permissions\n";
    echo "3. Check MySQL version (ENUM support required)\n";
    echo "4. Verify table structure matches migration expectations\n";
    echo "5. Check foreign key constraints\n";

    exit(1);
}
?>