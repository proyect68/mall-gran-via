<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

// Registrar el kernel
$app->make(\Illuminate\Contracts\Debug\ExceptionHandler::class);

// Usar la BD
$users = \App\Models\User::all();
foreach ($users as $user) {
    $user->password = \Illuminate\Support\Facades\Hash::make('password123');
    $user->save();
    echo "Updated: {$user->email}\n";
}

echo "All passwords updated to 'password123'\n";
