<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario de prueba principal
        User::firstOrCreate(
            ['email' => 'cliente@mallgranvia.com'],
            [
                'name' => 'Cliente Test',
                'password' => Hash::make('cliente123'),
                'email_verified_at' => now(),
            ]
        );

        // Usuarios adicionales de prueba
        $testUsers = [
            [
                'name' => 'Cliente 7806',
                'email' => 'Cliente7806@gmail.com',
                'password' => 'cliente123',
            ],
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'María García',
                'email' => 'maria.garcia@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Carlos López',
                'email' => 'carlos.lopez@example.com',
                'password' => 'password123',
            ],
        ];

        foreach ($testUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}

