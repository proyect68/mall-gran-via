@echo off
echo === ESTABLECIENDO USUARIO DE PRUEBA ===
echo.

cd c:\laragon\www\webpersonal

echo Verificando migraciones...
php artisan migrate:status

echo.
echo Intentando crear usuario de prueba...
php artisan user:create-client

if %errorlevel% neq 0 (
    echo.
    echo ❌ Error al crear usuario
    echo.
    echo Intentando revisar la tabla users...
    php artisan tinker --execute="dd(DB::table('users')->get());"
)

echo.
pause