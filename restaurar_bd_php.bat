@echo off
echo === RESTAURANDO BASE DE DATOS ORIGINAL ===
echo.

cd c:\laragon\www\webpersonal

echo Leyendo archivo SQL...
for /f %%A in ("database\BD_mall_gran_via.sql") do set "FILE_SIZE=%%~zA"
echo Tamaño: %FILE_SIZE% bytes

echo.
echo Importando SQL a PostgreSQL...
php artisan tinker << 'EOF'
use Illuminate\Support\Facades\DB;

$sql = file_get_contents(database_path('BD_mall_gran_via.sql'));
$statements = array_filter(array_map('trim', explode(';', $sql)), function($s) { return !empty($s); });

foreach ($statements as $statement) {
    try {
        DB::statement($statement);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

$count = DB::select("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'public'");
echo "✅ Base de datos restaurada con " . $count[0]->count . " tablas\n";
EOF

echo.
echo.
echo Verificando conexion a Laravel...
php artisan migrate:status

echo.
echo ✅ Restauracion completada
echo.
pause