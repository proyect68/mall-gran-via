@echo off
cd /d "c:\laragon\www\webpersonal"

echo Iniciando servidor Laravel...
echo.

REM Use Laravel Artisan serve with specified host and port
"c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe" artisan serve --host=127.0.0.1 --port=8000

pause
