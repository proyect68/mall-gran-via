@echo off
echo === CONFIGURACION COMPLETA DE POSTGRESQL ===
echo.

echo Paso 1: Configurando PATH...
call configurar_path.bat >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error en PATH
) else (
    echo ✅ PATH configurado
)

echo.
echo Paso 2: Configurando pg_hba.conf...
call configurar_pg_hba.bat >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error en pg_hba.conf
) else (
    echo ✅ pg_hba.conf configurado
)

echo.
echo Paso 3: Verificando configuracion...
call diagnostico_avanzado.bat >nul 2>&1

echo.
echo Paso 4: Configurando Laravel...
cd c:\laragon\www\webpersonal
php artisan migrate:fresh --force >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error en migraciones
) else (
    echo ✅ Migraciones ejecutadas
)

php artisan user:create-client >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error al crear usuario
) else (
    echo ✅ Usuario de prueba creado
)

echo.
echo === CONFIGURACION COMPLETADA ===
echo.
echo Ahora puedes probar el login en: http://localhost
echo Usuario: cliente@gmail.com
echo Password: cliente123
echo.
echo Si hay problemas, ejecuta diagnostico_avanzado.bat para mas detalles
echo.
pause