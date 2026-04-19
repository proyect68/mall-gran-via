<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Subcategoria;
use App\Models\Category;

class ReclassifyZapatosTrendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener categoría "Moda y accesorios"
        $modaCategory = Category::where('name', 'Moda y accesorios')->first();
        
        if (!$modaCategory) {
            echo "Categoría 'Moda y accesorios' no encontrada.\n";
            return;
        }

        // Buscar el producto "Zapatos Trend"
        $zapatosTrend = Product::where('name', 'Zapatos Trend')->first();

        if (!$zapatosTrend) {
            echo "Producto 'Zapatos Trend' no encontrado.\n";
            return;
        }

        // Obtener subcategoría "Calzado casual"
        $calzadoCasual = Subcategoria::where('nombre', 'Calzado casual')
            ->where('categoria_id', $modaCategory->id)
            ->first();

        if (!$calzadoCasual) {
            echo "Subcategoría 'Calzado casual' no encontrada.\n";
            return;
        }

        // Actualizar el producto
        $zapatosTrend->update(['subcategoria_id' => $calzadoCasual->id]);
        echo "✓ Zapatos Trend → Calzado casual\n";
        echo "\n✓ Reclasificación completada.\n";
    }
}
