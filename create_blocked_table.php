<?php
$db = new SQLite3('writable/database/database.sqlite');
$sql = 'CREATE TABLE IF NOT EXISTS blocked_dates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    facility_id INTEGER NOT NULL,
    blocked_date DATE NOT NULL,
    reason TEXT,
    created_by INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE (facility_id, blocked_date)
)';
if($db->exec($sql)){
    echo 'Table blocked_dates created successfully';
} else {
    echo 'Error: ' . $db->lastErrorMsg();
}
