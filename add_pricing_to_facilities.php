<?php
// Add pricing columns to facilities table
$db_path = __DIR__ . '/writable/database/database.sqlite';

if (!file_exists($db_path)) {
    die("Database file not found at: $db_path\n");
}

try {
    $db = new SQLite3($db_path);
    
    echo "Adding pricing columns to facilities table...\n";
    
    // Add pricing_type column (hourly or daily)
    $db->exec("ALTER TABLE facilities ADD COLUMN pricing_type TEXT DEFAULT 'hourly' CHECK (pricing_type IN ('hourly','daily'))");
    echo "✓ Added pricing_type column\n";
    
    // Add price_per_hour column
    $db->exec("ALTER TABLE facilities ADD COLUMN price_per_hour REAL DEFAULT 0.00");
    echo "✓ Added price_per_hour column\n";
    
    // Add price_per_day column
    $db->exec("ALTER TABLE facilities ADD COLUMN price_per_day REAL DEFAULT 0.00");
    echo "✓ Added price_per_day column\n";
    
    echo "\n✅ Successfully added pricing columns to facilities table!\n";
    
    $db->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
