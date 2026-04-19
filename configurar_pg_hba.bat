@echo off
echo === CONFIGURANDO PG_HBA.CONF ===
echo.

echo Buscando pg_hba.conf...
set "HBA_FILE="
for %%d in (C D E F G) do (
    if exist "%%d:\Program Files\PostgreSQL" (
        for /d %%i in ("%%d:\Program Files\PostgreSQL\*") do (
            if exist "%%i\data\pg_hba.conf" (
                set "HBA_FILE=%%i\data\pg_hba.conf"
                goto :found
            )
        )
    )
)

if "%HBA_FILE%"=="" (
    echo ❌ pg_hba.conf no encontrado
    goto :end
)

:found
echo ✅ pg_hba.conf encontrado: %HBA_FILE%
echo.

echo Creando backup...
copy "%HBA_FILE%" "%HBA_FILE%.backup" >nul
if %errorlevel% equ 0 (
    echo ✅ Backup creado: %HBA_FILE%.backup
) else (
    echo ❌ Error al crear backup
    goto :end
)

echo.
echo Configurando para conexiones locales sin password...
echo # Configuracion para desarrollo local >> "%HBA_FILE%"
echo local   all             all                                     trust >> "%HBA_FILE%"
echo host    all             all             127.0.0.1/32            trust >> "%HBA_FILE%"
echo host    all             all             ::1/128                 trust >> "%HBA_FILE%"

if %errorlevel% equ 0 (
    echo ✅ Configuracion agregada
    echo.
    echo 🔄 REINICIANDO POSTGRESQL...
    echo.
    net stop postgresql-x64-16 >nul 2>&1
    timeout /t 2 >nul
    net start postgresql-x64-16 >nul 2>&1
    if %errorlevel% equ 0 (
        echo ✅ PostgreSQL reiniciado
    ) else (
        echo ❌ Error al reiniciar PostgreSQL
    )
) else (
    echo ❌ Error al configurar pg_hba.conf
)

echo.
echo Probando conexion...
psql -U postgres -h localhost -c "SELECT 1;" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Conexion exitosa
) else (
    echo ❌ Aun no se puede conectar
)

:end
echo.
echo NOTA: Si hay problemas, revisa el archivo pg_hba.conf
echo       y reinicia PostgreSQL manualmente
pause