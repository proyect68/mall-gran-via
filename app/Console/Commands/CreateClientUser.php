<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateClientUser extends Command
{
    protected $signature = 'user:create-client';
    protected $description = 'Create a test client user';

    public function handle()
    {
        try {
            $email = 'cliente@gmail.com';
            
            // Verificar si el usuario ya existe
            $user = User::where('email', $email)->first();
            
            if ($user) {
                $this->info("✅ Usuario ya existe: {$email}");
                return 0;
            }
            
            // Crear nuevo usuario
            $user = User::create([
                'name' => 'Cliente Test',
                'email' => $email,
                'password' => Hash::make('cliente123'),
                'role' => 'cliente',
                'email_verified_at' => now(),
            ]);

            $this->info("✅ Usuario cliente creado exitosamente: {$user->email}");
            $this->info("   Contraseña: cliente123");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Error al crear usuario: {$e->getMessage()}");
            $this->error("   Línea: {$e->getLine()}");
            return 1;
        }
    }
}

