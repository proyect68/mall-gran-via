<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subcategoria;
use App\Models\Category;

class AssignmentController extends Controller
{
    public function assignProducts()
    {
        // Only allow in development
        if (app()->environment('production')) {
            abort(403, 'Not available in production');
        }

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
                'microondas' => 'Microondas',
                'licuadora' => 'Licuadoras',
            ],
            'Hogar y decoracion' => [
                'mueble' => 'Muebles',
                'silla' => 'Muebles',
                'mesa' => 'Muebles',
                'cama' => 'Muebles',
                'lampara' => 'Iluminacion',
                'decoracion' => 'Decoracion',
                'sabana' => 'Ropa de cama',
                'almohada' => 'Ropa de cama',
            ],
            'Belleza y cuidado personal' => [
                'maquillaje' => 'Maquillaje',
                'perfume' => 'Perfumes',
                'crema' => 'Cuidado facial',
                'jabon' => 'Cuidado corporal',
                'shampoo' => 'Productos capilares',
                'navaja' => 'Barberia',
            ],
            'Deportes y entretenimiento' => [
                'bicicleta' => 'Bicicletas',
                'juego' => 'Juegos',
                'videojuego' => 'Juegos',
                'juguete' => 'Entretenimiento',
                'libro' => 'Entretenimiento',
            ],
            'Ninos y bebes' => [
                'ropa infantil' => 'Ropa infantil',
                'juguete' => 'Juguetes',
                'cuaderno' => 'Articulos escolares',
            ],
            'Comida y restaurantes' => [
                'hamburguesa' => 'Comida rapida',
                'pizza' => 'Comida rapida',
                'papas' => 'Comida rapida',
                'pollo' => 'Comida rapida',
                'cafe' => 'Cafeterias',
                'helado' => 'Heladerias',
                'bebida' => 'Bebidas',
            ],
            'Servicios' => [
                'gimnasio' => 'Gimnasios',
                'spa' => 'Salones de belleza',
                'banco' => 'Bancos',
                'reparacion' => 'Reparaciones',
            ]
        ];

        $products = Product::all();
        $assigned = 0;
        $skipped = 0;
        $results = [];

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

            if (!$subcategory) {
                $subcategory = Subcategoria::where('categoria_id', $category->id)->first();
            }

            if ($subcategory) {
                $product->subcategoria_id = $subcategory->id;
                $product->save();
                $assigned++;
                $results[] = [
                    'product' => $product->name,
                    'subcategory' => $subcategory->nombre,
                    'category' => $category->name
                ];
            }
        }

        return response()->json([
            'success' => true,
            'assigned' => $assigned,
            'skipped' => $skipped,
            'total' => count($products),
            'results' => $results
        ]);
    }
}
