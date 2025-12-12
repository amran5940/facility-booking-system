<?php
// Manual Migration Runner for Hosting
// Usage: php manual_migrate.php

require_once __DIR__ . '/vendor/autoload.php';

use CodeIgniter\Config\Factories;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Config;
use CodeIgniter\Database\MigrationRunner;
use CodeIgniter\CLI\CLI;

// Load environment (optional)
if (file_exists(__DIR__ . '/.env')) {
    // Note: This script assumes .env is already loaded by the web server
    // or environment variables are set manually
}

// Bootstrap CodeIgniter runtime when running from CLI so helpers like
// config() and Services are available. This mirrors what `spark` does.
if (!function_exists('config')) {
    // If CodeIgniter helpers are not available, delegate to the project's
    // `spark` CLI which bootstraps the framework correctly.
    $spark = __DIR__ . DIRECTORY_SEPARATOR . 'spark';
    if (file_exists($spark)) {
        echo "⚠️  Bootstrapping via spark CLI...\n\n";
        passthru(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($spark) . ' migrate 2>&1', $ret);
        exit($ret);
    }

    echo "⚠️  CodeIgniter runtime not available and 'spark' not found or not executable.\n";
    echo "Run migrations using: php spark migrate\n";
    exit(1);
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

    // Get pending migrations
    $migrations = $runner->findMigrations();
    $history = $runner->getHistory();

    $pending = [];
    foreach ($migrations as $migration) {
        $isMigrated = false;
        foreach ($history as $hist) {
            if ($hist['version'] == $migration->version) {
                $isMigrated = true;
                break;
            }
        }
        if (!$isMigrated) {
            $pending[] = $migration;
        }
    }

    if (empty($pending)) {
        echo "✅ All migrations are already up to date!\n";
        exit(0);
    }

    echo "\n📋 Found " . count($pending) . " pending migration(s):\n";

    foreach ($pending as $migration) {
        echo "- " . basename($migration->path) . " (" . $migration->version . ")\n";
    }

    echo "\n🚀 Starting migration process...\n";

    // Run migrations one by one for better error handling
    foreach ($pending as $migration) {
        echo "Running: " . basename($migration->path) . "... ";

        try {
            // Include the migration file
            require_once $migration->path;

            // Get the class name
            $className = $migration->class;
            $fullClassName = $migration->namespace . '\\' . $className;

            if (!class_exists($fullClassName)) {
                throw new Exception("Migration class '$fullClassName' not found");
            }

            // Create instance and run up()
            $instance = new $fullClassName();
            $instance->up();

            // Record in history by inserting directly into the migrations table
            $db->table('migrations')->insert([
                'version' => $migration->version,
                'class' => $migration->class,
                'group' => 'default',
                'namespace' => $migration->namespace,
                'time' => time(),
            ]);

            echo "✅ SUCCESS\n";

        } catch (Exception $e) {
            echo "❌ FAILED\n";
            echo "Error: " . $e->getMessage() . "\n";

            // Try to rollback if possible
            try {
                if (isset($instance) && method_exists($instance, 'down')) {
                    echo "Attempting rollback... ";
                    $instance->down();
                    echo "✅ ROLLED BACK\n";
                }
            } catch (Exception $rollbackError) {
                echo "❌ ROLLBACK FAILED: " . $rollbackError->getMessage() . "\n";
            }

            exit(1);
        }
    }

    echo "\n🎉 All migrations completed successfully!\n";

} catch (Exception $e) {
    echo "❌ Critical Error: " . $e->getMessage() . "\n";

    echo "\n🔧 Common Solutions:\n";
    echo "1. Check .env database credentials\n";
    echo "2. Ensure database and user exist\n";
    echo "3. Check MySQL version (ENUM support)\n";
    echo "4. Verify user permissions (CREATE, ALTER, DROP)\n";
    echo "5. Check foreign key constraints\n";
    echo "6. Ensure tables exist before adding columns\n";

    exit(1);
}
?>