@echo off
echo === INICIANDO POSTGRESQL ===
echo.

echo Buscando servicios de PostgreSQL...
for /f "tokens=2" %%i in ('sc query ^| findstr /i postgres') do (
    echo Intentando iniciar servicio: %%i
    net start %%i
    if %errorlevel% equ 0 (
        echo ✅ Servicio %%i iniciado correctamente
        goto :success
    ) else (
        echo ❌ Error al iniciar servicio %%i
    )
)

echo.
echo Si no se pudo iniciar automaticamente, intenta:
echo 1. Abrir pgAdmin o pg_ctl
echo 2. Iniciar PostgreSQL manualmente
echo 3. Verificar que el servicio este instalado
echo.

:success
echo.
echo Verificando conexion...
timeout /t 3 >nul
psql -U postgres -h localhost -c "SELECT 1;" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ PostgreSQL esta funcionando correctamente
) else (
    echo ❌ Aun no se puede conectar
)

echo.
pause