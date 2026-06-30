<?php
try {
    $dbh = new PDO('mysql:host=127.0.0.1;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "OK\n";
    $dbs = $dbh->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN);
    echo "DBS=" . implode(',', $dbs) . "\n";
    if (in_array('parcial_itech', $dbs, true)) {
        $dbh->exec('USE parcial_itech');
        $tables = $dbh->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        echo "TABLES=" . implode(',', $tables) . "\n";
        if (in_array('areas_interes', $tables, true)) {
            $count = $dbh->query('SELECT COUNT(*) FROM areas_interes')->fetchColumn();
            echo "AREAS_COUNT=" . $count . "\n";
        }
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
