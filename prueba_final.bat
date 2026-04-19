@echo off
echo === PRUEBA FINAL DE CONEXION ===
echo.

cd c:\laragon\www\webpersonal

echo 1. Probando PHP...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP no funciona
    goto :end
) else (
    echo ✅ PHP funcionando
)

echo.
echo 2. Probando Laravel...
php artisan --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Laravel no funciona
    goto :end
) else (
    echo ✅ Laravel funcionando
)

echo.
echo 3. Probando base de datos...
php artisan migrate:status >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error de base de datos
    echo    Ejecutando migraciones...
    php artisan migrate:fresh --force >nul 2>&1
    if %errorlevel% neq 0 (
        echo ❌ Error al ejecutar migraciones
    ) else (
        echo ✅ Migraciones ejecutadas
    )
) else (
    echo ✅ Base de datos conectada
)

echo.
echo 4. Creando usuario de prueba...
php artisan user:create-client >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error al crear usuario
) else (
    echo ✅ Usuario de prueba creado
)

echo.
echo 5. Compilando assets...
npm run build >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Error en assets
) else (
    echo ✅ Assets compilados
)

echo.
echo === PRUEBA COMPLETADA ===
echo.
echo 🌐 Ve a: http://localhost
echo 👤 Usuario: cliente@gmail.com
echo 🔑 Password: cliente123
echo.
echo Si hay errores arriba, revisalos antes de probar.
echo.

:end
pause