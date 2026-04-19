# Configuración de PostgreSQL para Mall Gran Vía

## 🚀 SOLUCIÓN RÁPIDA (Recomendado)

### Ejecuta la configuración completa:
1. Ejecuta `configuracion_completa.bat` **como Administrador**
2. Ejecuta `prueba_final.bat` para verificar
3. Ve a http://localhost y prueba el login

---

## 🔧 Solución Manual (Paso a Paso)

### Paso 1: Configurar PATH
Ejecuta `configurar_path.bat` **como Administrador**

### Paso 2: Configurar Autenticación
Ejecuta `configurar_pg_hba.bat` **como Administrador**

### Paso 3: Verificar y Crear BD
Ejecuta `diagnostico_avanzado.bat`

### Paso 4: Configurar Laravel
```bash
cd c:\laragon\www\webpersonal
php artisan migrate:fresh --force
php artisan user:create-client
```

## 📁 Archivos Creados:
- `configuracion_completa.bat` - **Configura todo automáticamente**
- `prueba_final.bat` - **Verifica que todo funcione**
- `diagnostico_avanzado.bat` - Diagnóstico detallado
- `configurar_path.bat` - Agrega PostgreSQL al PATH
- `configurar_pg_hba.bat` - Configura autenticación
- `iniciar_postgresql.bat` - Inicia servicios
- `setup_postgresql.bat` - Configura base de datos

## ⚙️ Configuración .env
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mall_gran_via
DB_USERNAME=postgres
DB_PASSWORD=78801636Ab
```

## 🎯 Para Probar:
- URL: http://localhost
- Usuario: cliente@gmail.com
- Password: cliente123

## 📋 Checklist Final:
- [ ] `configuracion_completa.bat` ejecutado como Admin
- [ ] `prueba_final.bat` ejecutado (sin errores)
- [ ] http://localhost carga correctamente
- [ ] Login funciona con cliente@gmail.com / cliente123

**¿Ya ejecutaste la configuración completa?**
- Password: cliente123

**¿Ya ejecutaste `configuracion_completa.bat`?**