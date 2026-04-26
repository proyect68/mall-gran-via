<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategoria;

class AddModaSubcategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategorias = [
            'Ropa casual',
            'Ropa formal',
            'Ropa deportiva',
            'Calzado casual',
            'Calzado deportivo',
            'Bolsos',
            'Mochilas',
            'Relojes',
            'Joyería'
        ];

        $category = Category::where('nombre', 'Moda y accesorios')->first();
        
        if ($category) {
            foreach ($subcategorias as $subcategoria) {
                Subcategoria::firstOrCreate(
                    [
                        'nombre' => $subcategoria,
                        'categoria_id' => $category->id
                    ],
                    [
                        'descripcion' => 'Explorador ' . $subcategoria,
                        'imagen' => null
                    ]
                );
            }
        }
    }
}
