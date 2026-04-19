@echo off
setlocal enabledelayedexpansion

echo === RESTAURANDO DUMP DE POSTGRESQL ===
echo.

REM Buscar pg_restore
set "PG_RESTORE="
for /d %%d in ("C:\Program Files\PostgreSQL\*") do (
    if exist "%%d\bin\pg_restore.exe" (
        set "PG_RESTORE=%%d\bin\pg_restore.exe"
        echo ✅ pg_restore encontrado
        goto :found
    )
)

if "!PG_RESTORE!"=="" (
    echo ❌ pg_restore no encontrado
    pause
    exit /b 1
)

:found
echo.
echo Restaurando archivo...
echo.

REM Establecer password en variable de ambiente
set "PGPASSWORD=78801636Ab"

REM Restaurar el dump
"!PG_RESTORE!" -U postgres -h localhost -d mall_gran_via "C:\laragon\www\webpersonal\database\BD_mall_gran_via.sql"

if %errorlevel% equ 0 (
    echo.
    echo ✅ Base de datos restaurada
) else (
    echo.
    echo ❌ Error al restaurar
)

echo.
echo Verificando Laravel...
cd C:\laragon\www\webpersonal
php artisan migrate:fresh --force

echo.
echo ✅ Completado
echo.
pause