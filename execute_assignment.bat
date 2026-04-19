@echo off
setlocal enabledelayedexpansion

cd /d "c:\laragon\www\webpersonal"

set PHP_PATH=c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe

echo PHP Path: !PHP_PATH!
echo.

REM Execute the PHP script
"!PHP_PATH!" assign_products_manual.php

pause
