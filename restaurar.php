<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    $sqlFile = __DIR__ . '/database/BD_mall_gran_via.sql';
    
    if (!file_exists($sqlFile)) {
        echo "❌ Archivo no encontrado\n";
        exit(1);
    }
    
    $sql = file_get_contents($sqlFile);
    echo "Restaurando (" . strlen($sql) . " bytes)...\n";
    
    // Ejecutar todo de una vez
    DB::statement($sql);
    
    echo "✅ Base de datos restaurada\n";
    
} catch (\Exception $e) {
    echo "⚠️  Intentando línea por línea...\n";
    
    $lines = file(__DIR__ . '/database/BD_mall_gran_via.sql');
    $statement = '';
    $count = 0;
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '--') === 0) continue;
        
        $statement .= ' ' . $line;
        
        if (substr($line, -1) === ';') {
            try {
                DB::statement($statement);
                $count++;
            } catch (\Exception $e) {
                // Ignorar
            }
            $statement = '';
        }
    }
    
    echo "✅ Restaurados $count statements\n";
}
