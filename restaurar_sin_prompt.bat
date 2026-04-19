@echo off
setlocal enabledelayedexpansion

echo === RESTAURANDO BASE DE DATOS ORIGINAL ===
echo.

REM Buscar pg_restore
set "PG_RESTORE="
for /d %%d in ("C:\Program Files\PostgreSQL\*") do (
    if exist "%%d\bin\pg_restore.exe" (
        set "PG_RESTORE=%%d\bin\pg_restore.exe"
        goto :found
    )
)

if "!PG_RESTORE!"=="" (
    echo ❌ pg_restore no encontrado
    pause
    exit /b 1
)

:found
echo Restaurando dump (esto puede tardar)...
echo.

REM Establecer contraseña
set "PGPASSWORD=78801636Ab"

REM Restaurar sin solicitar contraseña
"!PG_RESTORE!" -U postgres -h localhost -d mall_gran_via -c "C:\laragon\www\webpersonal\database\BD_mall_gran_via.sql" 2>&1

if %errorlevel% equ 0 (
    echo.
    echo ✅ Base de datos restaurada exitosamente
    echo.
    echo Verificando tablas...
    cd C:\laragon\www\webpersonal
    php artisan tinker << 'ENDPHP'
use Illuminate\Support\Facades\DB;
$tables = DB::select("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'public'");
echo "Tablas en BD: " . $tables[0]->count . "\n";
ENDPHP
) else (
    echo.
    echo ⚠️  Restauración completada (posibles advertencias)
    echo.
    echo Verificando estado...
    cd C:\laragon\www\webpersonal
    php artisan tinker << 'ENDPHP'
use Illuminate\Support\Facades\DB;
$tables = DB::select("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'public'");
echo "Tablas en BD: " . $tables[0]->count . "\n";
ENDPHP
)

echo.
pause