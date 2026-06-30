<?php
require __DIR__ . '/app/config/database.php';
require __DIR__ . '/app/models/Tema.php';

use App\Models\Tema;

try {
    $tema = new Tema();
    $temas = $tema->obtenerTodos();
    echo 'OK\n';
    echo 'COUNT=' . count($temas) . "\n";
    foreach ($temas as $row) {
        echo $row['id'] . ' - ' . $row['nombre'] . "\n";
    }
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
