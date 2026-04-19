@echo off
echo === DIAGNOSTICO DE POSTGRESQL ===
echo.

echo 1. Verificando si PostgreSQL esta instalado...
where psql >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PostgreSQL NO esta instalado o no esta en PATH
    goto :end
) else (
    echo ✅ PostgreSQL esta instalado
)

echo.
echo 2. Verificando servicios de PostgreSQL...
sc query | findstr /i postgres >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ No se encontraron servicios de PostgreSQL corriendo
) else (
    echo ✅ Servicios de PostgreSQL encontrados
)

echo.
echo 3. Verificando puerto 5432...
netstat -ano | findstr :5432 >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Puerto 5432 NO esta abierto
) else (
    echo ✅ Puerto 5432 esta abierto
)

echo.
echo 4. Intentando conectar a PostgreSQL...
psql -U postgres -h localhost -c "SELECT version();" >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ No se puede conectar a PostgreSQL
    echo    - Verifica que PostgreSQL este corriendo
    echo    - Verifica la contraseña en pg_hba.conf
) else (
    echo ✅ Conexion a PostgreSQL exitosa
)

echo.
echo 5. Verificando base de datos mall_gran_via...
psql -U postgres -h localhost -l | findstr mall_gran_via >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Base de datos mall_gran_via NO existe
    echo    Creando base de datos...
    psql -U postgres -h localhost -c "CREATE DATABASE mall_gran_via;" >nul 2>&1
    if %errorlevel% neq 0 (
        echo ❌ Error al crear la base de datos
    ) else (
        echo ✅ Base de datos mall_gran_via creada
    )
) else (
    echo ✅ Base de datos mall_gran_via existe
)

echo.
echo 6. Probando configuracion de Laravel...
cd c:\laragon\www\webpersonal
php artisan migrate:status >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error en migraciones de Laravel
    echo    Ejecutando migraciones...
    php artisan migrate:fresh --force >nul 2>&1
    if %errorlevel% neq 0 (
        echo ❌ Error al ejecutar migraciones
    ) else (
        echo ✅ Migraciones ejecutadas correctamente
    )
) else (
    echo ✅ Migraciones de Laravel OK
)

echo.
echo === RESULTADO ===
echo Si ves errores arriba, necesitas:
echo 1. Iniciar PostgreSQL si no esta corriendo
echo 2. Verificar la contraseña en la configuracion
echo 3. Asegurarte de que la base de datos existe
echo.

:end
pause