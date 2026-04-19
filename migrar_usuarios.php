<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    echo "Migrando datos de 'usuarios' a 'users'...\n";

    // Verificar si hay datos en usuarios
    $usuariosCount = DB::table('usuarios')->count();
    echo "Registros en 'usuarios': {$usuariosCount}\n";

    // Verificar si ya hay datos en users
    $usersCount = DB::table('users')->count();
    echo "Registros en 'users': {$usersCount}\n";

    if ($usuariosCount > 0 && $usersCount == 0) {
        // Migrar datos
        $usuarios = DB::table('usuarios')->get();

        foreach ($usuarios as $usuario) {
            DB::table('users')->insert([
                'name' => $usuario->name ?? 'Usuario',
                'email' => $usuario->email,
                'password' => $usuario->password,
                'role' => $usuario->role ?? 'cliente',
                'email_verified_at' => $usuario->email_verified_at,
                'created_at' => $usuario->created_at ?? now(),
                'updated_at' => $usuario->updated_at ?? now(),
            ]);
        }

        echo "✅ Migración completada: {$usuariosCount} usuarios migrados\n";
    } elseif ($usersCount > 0) {
        echo "ℹ️  Ya hay datos en 'users', no se migra\n";
    } else {
        echo "ℹ️  No hay datos para migrar\n";
    }

    // Crear usuario de prueba si no existe
    $testUser = DB::table('users')->where('email', 'cliente@gmail.com')->first();
    if (!$testUser) {
        DB::table('users')->insert([
            'name' => 'Cliente Test',
            'email' => 'cliente@gmail.com',
            'password' => bcrypt('cliente123'),
            'role' => 'cliente',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Usuario de prueba creado: cliente@gmail.com / cliente123\n";
    } else {
        echo "ℹ️  Usuario de prueba ya existe\n";
    }

    echo "\n✅ Proceso completado\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}