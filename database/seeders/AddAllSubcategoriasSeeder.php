<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddAllSubcategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategoriesByCategory = [
            'Tecnologia y electronica' => [
                'Celulares',
                'Tablets',
                'Laptops',
                'Cargadores',
                'Fundas',
                'Audífonos',
                'Parlantes',
                'Televisores',
                'Gaming'
            ],
            'Electrodomésticos' => [
                'Refrigeradores',
                'Lavadoras',
                'Cocinas',
                'Microondas',
                'Licuadoras',
                'Cafeteras',
                'Aspiradoras'
            ],
            'Hogar y decoración' => [
                'Muebles',
                'Decoración',
                'Iluminación',
                'Ropa de cama',
                'Organización del hogar'
            ],
            'Belleza y cuidado personal' => [
                'Maquillaje',
                'Perfumes',
                'Cuidado facial',
                'Cuidado corporal',
                'Productos capilares',
                'Barbería'
            ],
            'Deportes y entretenimiento' => [
                'Ropa deportiva',
                'Calzado deportivo',
                'Equipamiento fitness',
                'Bicicletas',
                'Juegos',
                'Entretenimiento'
            ],
            'Niños y bebés' => [
                'Ropa infantil',
                'Juguetes',
                'Articulos escolares',
                'Accesorios para bebé'
            ],
            'Comida y restaurantes' => [
                'Comida rapida',
                'Restaurantes',
                'Cafeterias',
                'Heladerias',
                'Snacks',
                'Bebidas'
            ],
            'Servicios' => [
                'Salones de belleza',
                'Gimnasios',
                'Bancos/cajeros',
                'Reparaciones',
                'Otros servicios'
            ]
        ];

        foreach ($subcategoriesByCategory as $categoryName => $subcategories) {
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                foreach ($subcategories as $subcategoria) {
                    Subcategoria::firstOrCreate(
                        [
                            'nombre' => $subcategoria,
                            'categoria_id' => $category->id
                        ],
                        [
                            'descripcion' => 'Explorar ' . strtolower($subcategoria),
                            'imagen' => null
                        ]
                    );
                }
            }
        }
    }
}
