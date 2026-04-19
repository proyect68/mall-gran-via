<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategoria;

class RemoveDefaultSubcategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategoriasAEliminar = ['Ropa', 'Calzado', 'Accesorios'];
        
        foreach ($subcategoriasAEliminar as $nombre) {
            Subcategoria::where('nombre', $nombre)->delete();
        }
        
        echo "Subcategorías eliminadas: " . implode(', ', $subcategoriasAEliminar) . "\n";
    }
}
