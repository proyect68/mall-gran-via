@echo off
cd /d c:\laragon\www\webpersonal

REM Set PostgreSQL environment variables
set PGPASSWORD=78801636Ab

REM Execute SQL file
psql -h 127.0.0.1 -U postgres -d mall_gran_via -p 5432 -f assign_products.sql

pause
