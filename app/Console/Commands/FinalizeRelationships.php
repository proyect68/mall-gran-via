<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FinalizeRelationships extends Command
{
    protected $signature = 'relationships:finalize';
    protected $description = 'Finalize relationships migration and cleanup';

    public function handle()
    {
        $this->info('Finalizando migración de relaciones...');

        // 1. Actualizar datos restantes
        $userMapping = DB::table('usuarios')
            ->join('users', 'usuarios.email', '=', 'users.email')
            ->select('usuarios.id_usuario', 'users.id as user_id')
            ->get()
            ->pluck('user_id', 'id_usuario')
            ->toArray();

        $tablesToUpdate = [
            'busquedas' => 'id_usuario',
            'interacciones' => 'id_usuario',
            'tiendas' => 'id_propietario'
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

        // 2. Renombrar columnas restantes
        $columnsToRename = [
            'busquedas' => 'id_usuario',
            'interacciones' => 'id_usuario',
            'tiendas' => 'id_propietario'
        ];

        foreach ($columnsToRename as $table => $oldColumn) {
            $newColumn = ($oldColumn === 'id_propietario') ? 'owner_id' : 'user_id';
            DB::statement("ALTER TABLE {$table} RENAME COLUMN {$oldColumn} TO {$newColumn}");
            $this->info("✅ Renombrada columna {$oldColumn} → {$newColumn} en {$table}");
        }

        // 3. Eliminar tabla usuarios
        $this->info('Eliminando tabla usuarios duplicada...');
        DB::statement('DROP TABLE usuarios CASCADE');
        $this->info('✅ Tabla usuarios eliminada');

        $this->info('🎉 Migración finalizada!');
    }
}