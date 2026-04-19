<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateRelationships extends Command
{
    protected $signature = 'relationships:migrate';
    protected $description = 'Migrate foreign keys from usuarios to users table';

    public function handle()
    {
        $this->info('Migrando relaciones de usuarios a users...');

        // 1. Eliminar restricciones de clave foránea que referencian usuarios
        $this->info('Eliminando restricciones de clave foránea...');

        $constraints = [
            'busquedas_id_usuario_fkey',
            'fk_busqueda_usuario',
            'fk_interaccion_usuario',
            'fk_propietario',
            'fk_resena_usuario',
            'fk_seguidor_usuario',
            'fk_tienda_propietario_usuario',
            'fk_usuario_notif_usuario',
            'fk_usuario_rol_usuario',
            'interacciones_id_usuario_fkey',
            'resenas_producto_id_usuario_fkey',
            'resenas_tienda_id_usuario_fkey',
            'seguidores_tienda_id_usuario_fkey',
            'tienda_propietario_id_usuario_fkey',
            'usuario_notificacion_id_usuario_fkey',
            'usuario_rol_id_usuario_fkey'
        ];

        foreach ($constraints as $constraint) {
            try {
                DB::statement("ALTER TABLE busquedas DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE interacciones DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE tiendas DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE resenas_producto DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE seguidores_tienda DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE tienda_propietario DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE usuario_notificacion DROP CONSTRAINT IF EXISTS {$constraint}");
                DB::statement("ALTER TABLE usuario_rol DROP CONSTRAINT IF EXISTS {$constraint}");
            } catch (Exception $e) {
                // Ignorar errores si la restricción no existe
            }
        }

        $this->info('✅ Restricciones eliminadas');

        // 2. Actualizar datos en las tablas que referencian id_usuario
        $this->info('Actualizando referencias de datos...');

        $userMapping = DB::table('usuarios')
            ->join('users', 'usuarios.email', '=', 'users.email')
            ->select('usuarios.id_usuario', 'users.id as user_id')
            ->get()
            ->pluck('user_id', 'id_usuario')
            ->toArray();

        $tablesToUpdate = [
            'busquedas' => 'id_usuario',
            'interacciones' => 'id_usuario',
            'tiendas' => 'id_propietario',
            'resenas_producto' => 'id_usuario',
            'seguidores_tienda' => 'id_usuario',
            'tienda_propietario' => 'id_usuario',
            'usuario_notificacion' => 'id_usuario',
            'usuario_rol' => 'id_usuario'
        ];

        foreach ($tablesToUpdate as $table => $column) {
            $count = DB::table($table)->whereNotNull($column)->count();
            if ($count > 0) {
                foreach ($userMapping as $oldId => $newId) {
                    DB::table($table)
                        ->where($column, $oldId)
                        ->update([$column => $newId]);
                }
                $this->info("✅ Actualizadas {$count} referencias en {$table}");
            }
        }

        // 3. Renombrar columnas para consistencia
        $this->info('Renombrando columnas para consistencia...');

        $columnsToRename = [
            'busquedas' => 'id_usuario',
            'interacciones' => 'id_usuario',
            'tiendas' => 'id_propietario',
            'resenas_producto' => 'id_usuario',
            'seguidores_tienda' => 'id_usuario',
            'tienda_propietario' => 'id_usuario',
            'usuario_notificacion' => 'id_usuario'
        ];

        foreach ($columnsToRename as $table => $oldColumn) {
            $newColumn = ($oldColumn === 'id_propietario') ? 'owner_id' : 'user_id';
            try {
                DB::statement("ALTER TABLE {$table} RENAME COLUMN {$oldColumn} TO {$newColumn}");
                $this->info("✅ Renombrada columna {$oldColumn} → {$newColumn} en {$table}");
            } catch (Exception $e) {
                $this->warn("⚠️  No se pudo renombrar columna en {$table}: {$e->getMessage()}");
            }
        }

        // 4. Eliminar tabla usuarios duplicada
        $this->info('Eliminando tabla usuarios duplicada...');
        DB::statement('DROP TABLE usuarios CASCADE');
        $this->info('✅ Tabla usuarios eliminada');

        $this->info('🎉 Migración de relaciones completada!');
    }
}