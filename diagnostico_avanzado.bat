@echo off
echo === DIAGNOSTICO AVANZADO DE POSTGRESQL ===
echo.

echo 1. Buscando instalacion de PostgreSQL...
set "PG_FOUND="
for %%d in (C D E F G) do (
    if exist "%%d:\Program Files\PostgreSQL" (
        echo ✅ PostgreSQL encontrado en: %%d:\Program Files\PostgreSQL
        set "PG_FOUND=%%d:\Program Files\PostgreSQL"
        goto :pg_found
    )
)
for %%d in (C D E F G) do (
    if exist "%%d:\PostgreSQL" (
        echo ✅ PostgreSQL encontrado en: %%d:\PostgreSQL
        set "PG_FOUND=%%d:\PostgreSQL"
        goto :pg_found
    )
)

echo ❌ PostgreSQL NO encontrado en ubicaciones comunes
echo    - Verifica si esta instalado
echo    - O esta en una ubicacion no estandar
goto :end

:pg_found
echo.
echo 2. Verificando PATH...
where psql >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ psql NO esta en PATH
    echo    Intentando agregar al PATH temporalmente...
    set "PATH=%PATH%;%PG_FOUND%\bin"
    where psql >nul 2>&1
    if %errorlevel% neq 0 (
        echo ❌ Aun no se puede encontrar psql
    ) else (
        echo ✅ psql encontrado despues de agregar PATH
    )
) else (
    echo ✅ psql esta en PATH
)

echo.
echo 3. Verificando servicios corriendo...
sc query | findstr /i postgres >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ No hay servicios de PostgreSQL corriendo
) else (
    echo ✅ Servicios de PostgreSQL encontrados
)

echo.
echo 4. Verificando puerto 5432...
powershell -Command "Test-NetConnection -ComputerName localhost -Port 5432 -InformationLevel Quiet" >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Puerto 5432 NO esta abierto
    echo    - PostgreSQL puede estar en otro puerto
    echo    - O no esta corriendo
) else (
    echo ✅ Puerto 5432 esta abierto
)

echo.
echo 5. Intentando conectar sin password...
psql -U postgres -h localhost -c "SELECT version();" >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ No se puede conectar sin password
    echo    Intentando con password...
    echo %DB_PASSWORD% | psql -U postgres -h localhost -c "SELECT version();" >nul 2>&1
    if %errorlevel% neq 0 (
        echo ❌ No se puede conectar con password
        echo    - Verifica la password en pg_hba.conf
        echo    - O el metodo de autenticacion
    ) else (
        echo ✅ Conexion exitosa con password
    )
) else (
    echo ✅ Conexion exitosa sin password
)

echo.
echo 6. Verificando configuracion de pg_hba.conf...
echo    (Buscando archivos de configuracion...)
for /r "%PG_FOUND%" %%f in (pg_hba.conf) do (
    echo ✅ pg_hba.conf encontrado: %%f
    echo    Revisando configuracion...
    findstr /i "local.*all.*all" "%%f" >nul 2>&1
    if %errorlevel% neq 0 (
        echo ❌ No hay entrada local para todos los usuarios
    ) else (
        echo ✅ Entrada local encontrada
    )
    goto :hba_done
)
echo ❌ pg_hba.conf no encontrado

:hba_done
echo.
echo 7. Verificando base de datos mall_gran_via...
psql -U postgres -h localhost -l | findstr mall_gran_via >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Base de datos mall_gran_via NO existe
    echo    Intentando crearla...
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
echo === RECOMENDACIONES ===
echo.
if "%PG_FOUND%"=="" (
    echo 1. INSTALA PostgreSQL si no esta instalado
    echo    - Descarga de: https://www.postgresql.org/download/
    echo    - Password: 78801636Ab
)
echo.
echo 2. AGREGA PostgreSQL al PATH del sistema:
echo    - Ruta: %PG_FOUND%\bin
echo    - Variables de entorno del sistema
echo.
echo 3. VERIFICA la configuracion en pg_hba.conf:
echo    - Debe permitir conexiones locales
echo    - Metodo: md5 o trust para desarrollo
echo.
echo 4. REINICIA PostgreSQL despues de cambios:
echo    - net stop postgresql-x64-XX
echo    - net start postgresql-x64-XX
echo.
echo 5. PRUEBA la conexion:
echo    - psql -U postgres -h localhost
echo.

:end
pause