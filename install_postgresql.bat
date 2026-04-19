@echo off
echo Instalando PostgreSQL para Mall Gran Via...
echo.

echo Descargando PostgreSQL 16...
powershell -Command "Invoke-WebRequest -Uri 'https://get.enterprisedb.com/postgresql/postgresql-16.3-1-1-windows-x64.exe' -OutFile 'postgresql-installer.exe'"

echo.
echo Ejecutando instalador de PostgreSQL...
echo IMPORTANTE: Durante la instalacion:
echo - Selecciona componentes: PostgreSQL Server, pgAdmin, Command Line Tools
echo - Password para postgres: 78801636Ab
echo - Puerto: 5432
echo - Locale: Default
echo.
echo Presiona cualquier tecla para continuar con la instalacion...
pause > nul

start postgresql-installer.exe

echo.
echo Esperando a que termine la instalacion...
echo Una vez instalado, ejecuta: setup_postgresql.bat
echo.
pause