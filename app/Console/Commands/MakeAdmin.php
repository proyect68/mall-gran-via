<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a default administrator user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@gmail.com';

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'role' => 'administrador',
                'estado' => 'activo',
            ]);
            $this->info('Admin user already existed. Role updated to administrador.');
            return;
        }

        User::create([
            'name' => 'Admin',
            'apellido_paterno' => 'Mall',
            'apellido_materno' => 'Admin',
            'email' => $email,
            'password' => Hash::make('admin123#'), // Added a special character and number to pass our new validation rules
            'role' => 'administrador',
            'estado' => 'activo',
        ]);

        $this->info("Admin user created successfully! Email: {$email} Password: admin123#");
    }
}
