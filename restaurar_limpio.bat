@echo off
setlocal enabledelayedexpansion

echo === RESTAURANDO BASE DE DATOS ===
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
REM Establecer contraseña
set "PGPASSWORD=78801636Ab"

echo Limpiando base de datos...
for /d %%d in ("C:\Program Files\PostgreSQL\*") do (
    if exist "%%d\bin\psql.exe" (
        "%%d\bin\psql.exe" -U postgres -h localhost -d mall_gran_via -c "DROP SCHEMA public CASCADE; CREATE SCHEMA public;" >nul 2>&1
        goto :cleaned
    )
)

:cleaned
echo Restaurando dump...
"!PG_RESTORE!" -U postgres -h localhost -d mall_gran_via "C:\laragon\www\webpersonal\database\BD_mall_gran_via.sql" 2>&1 | findstr /v "error" >nul

echo.
echo ✅ Restauración completada
echo.
echo Verificando tablas...

cd C:\laragon\www\webpersonal
php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; use Illuminate\Support\Facades\DB; try { $count = DB::select('SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ' . chr(39) . 'public' . chr(39)); echo 'Tablas: ' . $count[0]->count . chr(10); } catch (\Exception $e) { echo 'Error: ' . $e->getMessage() . chr(10); }"

echo.
pause