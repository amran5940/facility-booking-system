<?php
$db = new SQLite3('C:\xampp\htdocs\am\writable\database\database.sqlite');
$tables = $db->querySingle("SELECT name FROM sqlite_master WHERE type='table' AND name='blocked_dates'", true);
if($tables){
    echo "blocked_dates exists\n";
    $cols = $db->query('PRAGMA table_info(blocked_dates)');
    while($col = $cols->fetchArray(SQLITE3_ASSOC)){
        echo $col['name'] . "\n";
    }
} else {
    echo "blocked_dates table does not exist\n";
}
