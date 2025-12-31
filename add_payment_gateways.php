<?php
// Add payment gateways table and agency payment settings
$db_path = __DIR__ . '/writable/database/database.sqlite';

if (!file_exists($db_path)) {
    die("Database file not found at: $db_path\n");
}

try {
    $db = new SQLite3($db_path);
    
    echo "Creating payment_gateways table...\n";
    
    // Payment Gateways table (admin-managed global gateways)
    $db->exec("CREATE TABLE IF NOT EXISTS payment_gateways (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        code TEXT NOT NULL UNIQUE,
        description TEXT,
        api_key TEXT,
        api_secret TEXT,
        merchant_id TEXT,
        config TEXT,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Created payment_gateways table\n";
    
    echo "\nCreating agency_payment_gateways table...\n";
    
    // Agency Payment Gateways (agency-specific settings)
    $db->exec("CREATE TABLE IF NOT EXISTS agency_payment_gateways (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        agency_id INTEGER NOT NULL,
        payment_gateway_id INTEGER,
        use_own_gateway INTEGER DEFAULT 0,
        gateway_name TEXT,
        gateway_code TEXT,
        api_key TEXT,
        api_secret TEXT,
        merchant_id TEXT,
        config TEXT,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE CASCADE,
        FOREIGN KEY (payment_gateway_id) REFERENCES payment_gateways(id) ON DELETE SET NULL
    )");
    echo "✓ Created agency_payment_gateways table\n";
    
    echo "\nInserting default payment gateways...\n";
    
    // Insert default payment gateways
    $defaultGateways = [
        ['FPX Online Banking', 'fpx', 'Perbankan dalam talian Malaysia'],
        ['Stripe', 'stripe', 'Kad kredit/debit melalui Stripe'],
        ['PayPal', 'paypal', 'Pembayaran melalui PayPal'],
        ['Cash', 'cash', 'Bayaran tunai di kaunter']
    ];
    
    foreach ($defaultGateways as $gateway) {
        $stmt = $db->prepare("INSERT OR IGNORE INTO payment_gateways (name, code, description) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $gateway[0], SQLITE3_TEXT);
        $stmt->bindValue(2, $gateway[1], SQLITE3_TEXT);
        $stmt->bindValue(3, $gateway[2], SQLITE3_TEXT);
        $stmt->execute();
    }
    echo "✓ Inserted default payment gateways\n";
    
    echo "\n✅ Successfully created payment gateway tables!\n";
    
    $db->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
