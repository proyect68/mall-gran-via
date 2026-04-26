<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategoria;

class ClassifyModaProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener categoría "Moda y accesorios"
        $modaCategory = Category::where('nombre', 'Moda y accesorios')->first();
        
        if (!$modaCategory) {
            echo "Categoría 'Moda y accesorios' no encontrada.\n";
            return;
        }

        // Mapeo de palabras clave a subcategorías
        $keywordMapping = [
            'Ropa casual' => ['casual', 'camisa', 'blusa', 'polera', 't-shirt', 'tshirt'],
            'Ropa formal' => ['formal', 'elegante', 'oficina', 'negocio', 'traje', 'corbata'],
            'Ropa deportiva' => ['deportiva', 'deporte', 'gym', 'running', 'fitness', 'activewear', 'sport'],
            'Calzado casual' => ['zapato casual', 'zapatos casual', 'tenis', 'sneaker', 'zapatilla casual', 'mocasín', 'mocasin'],
            'Calzado deportivo' => ['zapatilla deportiva', 'zapatillas deportivas', 'zapatilla run', 'zapatillas run', 'deportivo', 'running'],
            'Bolsos' => ['bolso', 'bolsa', 'cartera', 'mochila grande', 'tote', 'handbag'],
            'Mochilas' => ['mochila', 'backpack', 'mochila escolar'],
            'Relojes' => ['reloj', 'watch', 'smartwatch', 'smart watch'],
            'Joyería' => ['joya', 'joyas', 'collar', 'pulsera', 'anillo', 'arete', 'aro', 'set de accesorios'],
        ];

        // Obtener todos los productos de la categoría Moda y accesorios
        $products = Product::where('categoria_id', $modaCategory->id)->get();

        foreach ($products as $product) {
            $productName = strtolower($product->name);
            $subcategoriaAsignada = null;

            // Buscar coincidencia con las palabras clave
            foreach ($keywordMapping as $subcategoryName => $keywords) {
                foreach ($keywords as $keyword) {
                    if (strpos($productName, strtolower($keyword)) !== false) {
                        $subcategoriaAsignada = Subcategoria::where('nombre', $subcategoryName)
                            ->where('categoria_id', $modaCategory->id)
                            ->first();
                        
                        if ($subcategoriaAsignada) {
                            $product->update(['subcategoria_id' => $subcategoriaAsignada->id]);
                            echo "✓ {$product->name} → {$subcategoryName}\n";
                            break 2; // Salir de ambos loops
                        }
                    }
                }
            }

            if (!$subcategoriaAsignada) {
                // Si no se encuentra coincidencia exacta, asignar a "Bolsos" por defecto (accesorios generales)
                $defaultSubcategory = Subcategoria::where('nombre', 'Bolsos')
                    ->where('categoria_id', $modaCategory->id)
                    ->first();
                
                if ($defaultSubcategory) {
                    $product->update(['subcategoria_id' => $defaultSubcategory->id]);
                    echo "⚠ {$product->name} → Bolsos (default)\n";
                }
            }
        }

        echo "\n✓ Clasificación de productos completada.\n";
    }
}
