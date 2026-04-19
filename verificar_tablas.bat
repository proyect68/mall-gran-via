@echo off
setlocal enabledelayedexpansion

set "PGPASSWORD=78801636Ab"

REM Buscar psql
set "PSQL="
for /d %%d in ("C:\Program Files\PostgreSQL\*") do (
    if exist "%%d\bin\psql.exe" (
        set "PSQL=%%d\bin\psql.exe"
        goto :found
    )
)

if "!PSQL!"=="" (
    echo ❌ psql no encontrado
    pause
    exit /b 1
)

:found
echo === VERIFICANDO TABLAS ===
echo.

"!PSQL!" -U postgres -h localhost -d mall_gran_via -c "SELECT COUNT(*) as total FROM information_schema.tables WHERE table_schema = 'public';"

echo.
echo === LISTANDO TABLAS PRINCIPALES ===
echo.

"!PSQL!" -U postgres -h localhost -d mall_gran_via -c "\dt" | findstr /v "^(" | findstr /v "total"

echo.
pause