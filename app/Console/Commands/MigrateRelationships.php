<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

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
                $targetTables = ['busquedas', 'interacciones', 'tiendas', 'resenas_producto', 'seguidores_tienda', 'tienda_propietario', 'usuario_notificacion', 'usuario_rol', 'resenas_tienda'];
                foreach ($targetTables as $table) {
                    if (Schema::hasTable($table)) {
                        DB::statement("ALTER TABLE {$table} DROP CONSTRAINT IF EXISTS {$constraint}");
                    }
                }
            } catch (Exception $e) {
                // Ignorar errores si la restricción no existe
            }
        }

        $this->info('✅ Restricciones eliminadas');

        // 2. Actualizar datos en las tablas que referencian id_usuario
        $this->info('Actualizando referencias de datos...');

        $tablesToUpdate = [
        $tablesToUpdate = array_filter([
            'busquedas' => 'id_usuario',
            'interacciones' => 'id_usuario',
            'tiendas' => 'id_propietario',
            'resenas_producto' => 'id_usuario',
            'seguidores_tienda' => 'id_usuario',
            'tienda_propietario' => 'id_usuario',
            'usuario_notificacion' => 'id_usuario',
            'usuario_rol' => 'id_usuario'
        ];
        ], fn($table) => Schema::hasTable($table));

        foreach ($tablesToUpdate as $table => $column) {
            if (!Schema::hasTable($table) || !Schema::hasTable('usuarios')) {
                $this->warn("⚠️  Saltando {$table}: la tabla o el origen 'usuarios' no existen.");
            // Check if the 'usuarios' table exists before attempting to join it
            // Also check if the target table exists
            if (!Schema::hasTable('usuarios') || !Schema::hasTable($table)) {
                $this->warn("⚠️  Saltando {$table}: la tabla 'usuarios' o '{$table}' no existen para actualizar referencias.");
                continue;
            }

            // Actualización masiva por JOIN para evitar bucles pesados
            $affected = DB::table($table)
                ->join('usuarios', "{$table}.{$column}", '=', 'usuarios.id_usuario')
                ->join('users', 'usuarios.email', '=', 'users.email')
                ->update(["{$table}.{$column}" => DB::raw('users.id')]);
            
            $this->info("✅ Actualizadas {$affected} referencias en {$table}");
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
                // Verificar si la columna antigua existe antes de intentar renombrar
                $columnExists = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name='{$table}' AND column_name='{$oldColumn}'");
                
                if (!empty($columnExists)) {
                    DB::statement("ALTER TABLE {$table} RENAME COLUMN {$oldColumn} TO {$newColumn}");
                    $this->info("✅ Renombrada columna {$oldColumn} → {$newColumn} en {$table}");
                }
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