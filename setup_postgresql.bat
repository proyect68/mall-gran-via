@echo off
echo Configurando PostgreSQL para Mall Gran Via...
echo.

echo Creando base de datos mall_gran_via...
createdb -U postgres -h localhost mall_gran_via

echo.
echo Ejecutando migraciones de Laravel...
cd c:\laragon\www\webpersonal
php artisan migrate:fresh --force

echo.
echo Creando usuario de prueba...
php artisan user:create-client

echo.
echo ¡Configuracion completada!
echo Ahora puedes probar el login en: http://localhost
echo.
echo Usuario de prueba: cliente@gmail.com / cliente123
echo.
pause