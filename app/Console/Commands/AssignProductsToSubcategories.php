<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Subcategoria;
use App\Models\Category;
use Illuminate\Console\Command;

class AssignProductsToSubcategories extends Command
{
    protected $signature = 'products:assign-to-subcategories';
    protected $description = 'Assign products to appropriate subcategories';

    public function handle()
    {
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
                'anillo' => 'Joyeria',
                'pulsera' => 'Joyeria',
                'collar' => 'Joyeria',
            ],
            'Tecnologia y electronica' => [
                'celular' => 'Celulares',
                'smartphone' => 'Celulares',
                'telefono' => 'Celulares',
                'tablet' => 'Tablets',
                'ipad' => 'Tablets',
                'laptop' => 'Laptops',
                'computadora' => 'Laptops',
                'notebook' => 'Laptops',
                'cargador' => 'Cargadores',
                'cable' => 'Cargadores',
                'funda' => 'Fundas',
                'case' => 'Fundas',
                'audiofonos' => 'Audiafonos',
                'auriculares' => 'Audiafonos',
                'headphones' => 'Audiafonos',
                'parlante' => 'Parlantes',
                'speaker' => 'Parlantes',
                'televisor' => 'Televisores',
                'tv' => 'Televisores',
                'monitor' => 'Televisores',
                'gaming' => 'Gaming',
                'ps5' => 'Gaming',
                'xbox' => 'Gaming',
                'switch' => 'Gaming',
                'joystick' => 'Gaming',
                'control' => 'Gaming',
            ],
            'Electrodomesticos' => [
                'refrigerador' => 'Refrigeradores',
                'nevera' => 'Refrigeradores',
                'lavadora' => 'Lavadoras',
                'cocina' => 'Cocinas',
                'estufa' => 'Cocinas',
                'microondas' => 'Microondas',
                'licuadora' => 'Licuadoras',
                'cafetera' => 'Cafeteras',
                'aspiradora' => 'Aspiradoras',
            ],
            'Hogar y decoracion' => [
                'mueble' => 'Muebles',
                'silla' => 'Muebles',
                'mesa' => 'Muebles',
                'cama' => 'Muebles',
                'sofa' => 'Muebles',
                'cortina' => 'Decoracion',
                'cuadro' => 'Decoracion',
                'decoracion' => 'Decoracion',
                'planta' => 'Decoracion',
                'lampara' => 'Iluminacion',
                'luz' => 'Iluminacion',
                'foco' => 'Iluminacion',
                'sabana' => 'Ropa de cama',
                'almohada' => 'Ropa de cama',
                'edredon' => 'Ropa de cama',
                'manta' => 'Ropa de cama',
                'organizador' => 'Organizacion del hogar',
                'estante' => 'Organizacion del hogar',
            ],
            'Belleza y cuidado personal' => [
                'maquillaje' => 'Maquillaje',
                'lipstick' => 'Maquillaje',
                'rimmel' => 'Maquillaje',
                'sombra' => 'Maquillaje',
                'perfume' => 'Perfumes',
                'colonia' => 'Perfumes',
                'fragancia' => 'Perfumes',
                'crema' => 'Cuidado facial',
                'limpiador' => 'Cuidado facial',
                'serum' => 'Cuidado facial',
                'mascarilla' => 'Cuidado facial',
                'jabon' => 'Cuidado corporal',
                'locion' => 'Cuidado corporal',
                'gel' => 'Cuidado corporal',
                'shampoo' => 'Productos capilares',
                'acondicionador' => 'Productos capilares',
                'tinte' => 'Productos capilares',
                'navaja' => 'Barberia',
                'afeitadora' => 'Barberia',
                'espuma' => 'Barberia',
            ],
            'Deportes y entretenimiento' => [
                'mancuerna' => 'Equipamiento fitness',
                'banda' => 'Equipamiento fitness',
                'mat' => 'Equipamiento fitness',
                'bicicleta' => 'Bicicletas',
                'mountain bike' => 'Bicicletas',
                'juego' => 'Juegos',
                'videojuego' => 'Juegos',
                'juguete' => 'Entretenimiento',
                'puzzle' => 'Entretenimiento',
                'libro' => 'Entretenimiento',
                'pelicula' => 'Entretenimiento',
            ],
            'Ninos y bebes' => [
                'ropa infantil' => 'Ropa infantil',
                'pañal' => 'Accesorios para bebe',
                'mamadera' => 'Accesorios para bebe',
                'coche' => 'Accesorios para bebe',
                'andador' => 'Accesorios para bebe',
                'juguete' => 'Juguetes',
                'peluche' => 'Juguetes',
                'cuaderno' => 'Articulos escolares',
                'lapiz' => 'Articulos escolares',
                'mochila' => 'Articulos escolares',
                'uniforme' => 'Articulos escolares',
            ],
            'Comida y restaurantes' => [
                'hamburguesa' => 'Comida rapida',
                'pizza' => 'Comida rapida',
                'papas' => 'Comida rapida',
                'pollo' => 'Comida rapida',
                'sandwich' => 'Comida rapida',
                'comida' => 'Comida rapida',
                'plato' => 'Restaurantes',
                'ensalada' => 'Restaurantes',
                'carne' => 'Restaurantes',
                'pescado' => 'Restaurantes',
                'cafe' => 'Cafeterias',
                'cappuccino' => 'Cafeterias',
                'espresso' => 'Cafeterias',
                'helado' => 'Heladerias',
                'gelato' => 'Heladerias',
                'chips' => 'Snacks',
                'agua' => 'Bebidas',
                'gaseosa' => 'Bebidas',
                'jugo' => 'Bebidas',
                'refresco' => 'Bebidas',
            ],
            'Servicios' => [
                'corte' => 'Salones de belleza',
                'peluqueria' => 'Salones de belleza',
                'spa' => 'Salones de belleza',
                'masaje' => 'Salones de belleza',
                'terapia' => 'Salones de belleza',
                'gimnasio' => 'Gimnasios',
                'gym' => 'Gimnasios',
                'entrenamiento' => 'Gimnasios',
                'clases' => 'Gimnasios',
                'banco' => 'Bancos',
                'cajero' => 'Bancos',
                'transferencia' => 'Bancos',
                'reparacion' => 'Reparaciones',
                'tecnico' => 'Reparaciones',
                'mantenimiento' => 'Reparaciones',
                'servicio' => 'Otros servicios',
                'consulta' => 'Otros servicios',
            ]
        ];

        $products = Product::all();
        $assigned = 0;

        foreach ($products as $product) {
            if ($product->subcategoria_id) {
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
                    if (strpos($productName, $keyword) !== false) {
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
            }
        }

        $this->info("Asignados $assigned productos a subcategorias.");
    }
}
