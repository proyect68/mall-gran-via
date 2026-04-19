<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MigrateUsers extends Command
{
    protected $signature = 'users:migrate';
    protected $description = 'Migrate users from usuarios table to users table';

    public function handle()
    {
        $usuariosCount = DB::table('usuarios')->count();
        $usersCount = DB::table('users')->count();

        $this->info("Usuarios en 'usuarios': {$usuariosCount}");
        $this->info("Usuarios en 'users': {$usersCount}");

        if ($usuariosCount > 0 && $usersCount == 0) {
            $usuarios = DB::table('usuarios')->get();

            foreach ($usuarios as $usuario) {
                DB::table('users')->insert([
                    'name' => $usuario->nombre . ' ' . $usuario->ap_p . ' ' . $usuario->ap_m,
                    'email' => $usuario->email,
                    'password' => $usuario->password_hash,
                    'role' => 'cliente',
                    'email_verified_at' => now(),
                    'created_at' => $usuario->fecha_registro,
                    'updated_at' => now(),
                ]);
            }

            $this->info("✅ Migrados {$usuariosCount} usuarios");
        } else {
            $this->info("ℹ️  No se necesita migración");
        }

        // Crear usuario de prueba
        $testUser = DB::table('users')->where('email', 'cliente@gmail.com')->first();
        if (!$testUser) {
            DB::table('users')->insert([
                'name' => 'Cliente Test',
                'email' => 'cliente@gmail.com',
                'password' => Hash::make('cliente123'),
                'role' => 'cliente',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->info("✅ Usuario de prueba creado: cliente@gmail.com / cliente123");
        } else {
            $this->info("ℹ️  Usuario de prueba ya existe");
        }
    }
}