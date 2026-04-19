<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$massages = Product::where('name', 'like', '%Masaje%')->get();
echo "Servicios de masaje encontrados:\n";
foreach ($massages as $m) {
    echo "ID: {$m->id}, Nombre: {$m->name}, Precio: {$m->price}, Old Price: {$m->old_price}, Is Service: {$m->is_service}\n";
}
