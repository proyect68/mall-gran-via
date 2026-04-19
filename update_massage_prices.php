<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

// Actualizar Masaje Relajante - precio a consultar, pero sin old_price
Product::where('id', 7)->update([
    'old_price' => null // Remover el "0 BS" que se mostraba tachado
]);

// Actualizar Masaje Terapéutico - precio a consultar, pero sin old_price
Product::where('id', 18)->update([
    'old_price' => null
]);

echo "✓ Precios actualizados correctamente\n";
echo "Masaje Relajante: Precio = Consultar (sin precio viejo tachado)\n";
echo "Masaje Terapéutico: Precio = Consultar (sin precio viejo tachado)\n";
