<?php

// Disable PsyShell or any REPL interference
if (function_exists('putenv')) {
    putenv('PSYSH=');
}

// Include Laravel bootstrap
require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Subcategoria;
use App\Models\Category;

$mappings = [
    'Moda y accesorios' => [
        'ropa casual' => 'Ropa casual',
        'ropa formal' => 'Ropa formal',
        'ropa deportiva' => 'Ropa deportiva',
        'zapato' => 'Calzado casual',
        'zapatilla' => 'Calzado deportivo',
        'bolso' => 'Bolsos',
        'mochila' => 'Mochilas',
        'reloj' => 'Relojes',
        'joyeria' => 'Joyeria',
        'joya' => 'Joyeria',
    ],
    'Tecnologia y electronica' => [
        'celular' => 'Celulares',
        'smartphone' => 'Celulares',
        'tablet' => 'Tablets',
        'laptop' => 'Laptops',
        'computadora' => 'Laptops',
        'cargador' => 'Cargadores',
        'funda' => 'Fundas',
        'parlante' => 'Parlantes',
        'televisor' => 'Televisores',
        'gaming' => 'Gaming',
    ],
    'Electrodomesticos' => [
        'refrigerador' => 'Refrigeradores',
        'nevera' => 'Refrigeradores',
        'lavadora' => 'Lavadoras',
        'cocina' => 'Cocinas',
    ],
    'Hogar y decoracion' => [
        'mueble' => 'Muebles',
        'silla' => 'Muebles',
        'mesa' => 'Muebles',
        'lampara' => 'Iluminacion',
        'decoracion' => 'Decoracion',
    ],
    'Belleza y cuidado personal' => [
        'maquillaje' => 'Maquillaje',
        'perfume' => 'Perfumes',
        'crema' => 'Cuidado facial',
        'shampoo' => 'Productos capilares',
    ],
    'Deportes y entretenimiento' => [
        'bicicleta' => 'Bicicletas',
        'juego' => 'Juegos',
        'juguete' => 'Entretenimiento',
    ],
    'Ninos y bebes' => [
        'ropa infantil' => 'Ropa infantil',
        'juguete' => 'Juguetes',
    ],
    'Comida y restaurantes' => [
        'hamburguesa' => 'Comida rapida',
        'pizza' => 'Comida rapida',
        'cafe' => 'Cafeterias',
        'helado' => 'Heladerias',
    ],
    'Servicios' => [
        'gimnasio' => 'Gimnasios',
        'spa' => 'Salones de belleza',
        'banco' => 'Bancos',
    ]
];

echo "Starting product assignment...\n";

$products = Product::all();
$assigned = 0;
$skipped = 0;

foreach ($products as $product) {
    if ($product->subcategoria_id) {
        $skipped++;
        continue;
    }

    $category = Category::find($product->category_id);
    if (!$category) {
        continue;
    }

    $productName = strtolower($product->name);
    $subcategory = null;

    if (isset($mappings[$category->name])) {
        foreach ($mappings[$category->name] as $keyword => $subcategoryName) {
            if (strpos($productName, strtolower($keyword)) !== false) {
                $subcategory = Subcategoria::where('nombre', $subcategoryName)
                    ->where('categoria_id', $category->id)
                    ->first();
                if ($subcategory) {
                    break;
                }
            }
        }
    }

    // If no match found, assign to first subcategory of the category
    if (!$subcategory) {
        $subcategory = Subcategoria::where('categoria_id', $category->id)->first();
    }

    if ($subcategory) {
        $product->subcategoria_id = $subcategory->id;
        $product->save();
        $assigned++;
        echo "✓ Assigned: {$product->name} → {$subcategory->nombre}\n";
    }
}

echo "\n=== Results ===\n";
echo "Assigned: $assigned\n";
echo "Skipped (already assigned): $skipped\n";
echo "Total products: " . count($products) . "\n";
echo "\nDone!\n";
