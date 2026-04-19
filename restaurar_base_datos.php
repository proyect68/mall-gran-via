<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
    // Leer el archivo SQL
    $sqlFile = __DIR__ . '/database/BD_mall_gran_via.sql';
    
    if (!file_exists($sqlFile)) {
        echo "❌ Archivo SQL no encontrado: {$sqlFile}\n";
        exit(1);
    }
    
    $sql = file_get_contents($sqlFile);
    echo "Leyendo archivo SQL (" . strlen($sql) . " bytes)...\n";
    
    // Dividir por statements
    $statements = array_filter(
        array_map('trim', preg_split('/;[\s\n]+(?=--|\/\*|\w|\(|$)/i', $sql)),
        function($s) { return !empty($s); }
    );
    
    echo "Encontrados " . count($statements) . " statements\n";
    echo "Importando a base de datos...\n\n";
    
    $imported = 0;
    $errors = 0;
    
    foreach ($statements as $statement) {
        try {
            if (strpos(strtoupper($statement), 'CREATE') === 0 || 
                strpos(strtoupper($statement), 'INSERT') === 0 ||
                strpos(strtoupper($statement), 'TRUNCATE') === 0) {
                DB::statement($statement);
                $imported++;
            }
        } catch (\Exception $e) {
            echo "⚠️  Aviso: " . substr($e->getMessage(), 0, 80) . "\n";
            $errors++;
        }
    }
    
    echo "\n✅ Importación completada\n";
    echo "   Statements ejecutados: {$imported}\n";
    echo "   Errores ignorados: {$errors}\n";
    
    // Contar tablas
    try {
        $tableCount = DB::select("
            SELECT COUNT(*) as count 
            FROM information_schema.tables 
            WHERE table_schema = 'public'
        ");
        echo "   Tablas en la BD: " . $tableCount[0]->count . "\n";
    } catch (\Exception $e) {
        echo "   (No se pudo contar tablas)\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
