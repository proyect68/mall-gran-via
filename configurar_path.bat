@echo off
echo === CONFIGURANDO PATH DE POSTGRESQL ===
echo.

echo Buscando instalacion de PostgreSQL...
set "PG_PATH="
for %%d in (C D E F G) do (
    if exist "%%d:\Program Files\PostgreSQL" (
        for /d %%i in ("%%d:\Program Files\PostgreSQL\*") do (
            if exist "%%i\bin\psql.exe" (
                set "PG_PATH=%%i\bin"
                goto :found
            )
        )
    )
)

echo ❌ PostgreSQL no encontrado
goto :end

:found
echo ✅ PostgreSQL encontrado en: %PG_PATH%
echo.
echo Agregando al PATH del sistema...

setx PATH "%PATH%;%PG_PATH%" /M
if %errorlevel% equ 0 (
    echo ✅ PATH agregado permanentemente
    echo    Reinicia la terminal para que tome efecto
) else (
    echo ❌ Error al agregar PATH
)

echo.
echo Verificando...
set "PATH=%PATH%;%PG_PATH%"
where psql >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ psql ahora esta disponible
) else (
    echo ❌ psql aun no disponible
)

:end
pause