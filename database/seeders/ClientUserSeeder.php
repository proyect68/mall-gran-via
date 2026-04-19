<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'cliente@mallgranvia.com'],
            [
                'name' => 'Cliente Test',
                'password' => Hash::make('cliente123'),
                'role' => 'cliente',
                'email_verified_at' => now(),
            ]
        );
    }
}
