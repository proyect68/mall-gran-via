@echo off
setlocal enabledelayedexpansion

REM Buscar psql en la instalacion de PostgreSQL
set "PSQL="
for /d %%d in ("C:\Program Files\PostgreSQL\*") do (
    if exist "%%d\bin\psql.exe" (
        set "PSQL=%%d\bin\psql.exe"
        goto :found
    )
)

if "!PSQL!"=="" (
    echo Error: PostgreSQL no encontrado
    pause
    exit /b 1
)

:found
echo Restaurando base de datos desde BD_mall_gran_via.sql...
"!PSQL!" -U postgres -h localhost mall_gran_via < "C:\laragon\www\webpersonal\database\BD_mall_gran_via.sql"

if %errorlevel% equ 0 (
    echo ✅ Base de datos restaurada
) else (
    echo ❌ Error al restaurar base de datos
)

pause