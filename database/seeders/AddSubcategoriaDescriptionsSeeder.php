<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategoria;

class AddSubcategoriaDescriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $descriptions = [
            'Ropa casual' => 'Prendas cómodas y versátiles para el día a día. Desde camisas hasta poleras, encuentra todo lo que necesitas para estar cómodo.',
            'Ropa formal' => 'Ropa elegante y profesional para ocasiones especiales. Trajes, corbatas y prendas de oficina con estilo.',
            'Ropa deportiva' => 'Atuendos diseñados para el deporte y el fitness. Ropa cómoda y funcional para tus entrenamientos.',
            'Calzado casual' => 'Zapatos cómodos para el día a día. Sneakers, tenis y mocasines con estilo.',
            'Calzado deportivo' => 'Zapatillas diseñadas para correr, entrenar y hacer deporte. Máxima comodidad y soporte.',
            'Bolsos' => 'Mochilas, bolsas y carteras de diversos tamaños. Funcionales y con gran variedad de estilos.',
            'Mochilas' => 'Mochilas prácticas para la escuela, universidad o viajes. Espaciosas y ergonómicas.',
            'Relojes' => 'Relojes elegantes y smartwatches de última tecnología. Perfecto para complementar tu look.',
            'Joyería' => 'Collares, pulseras, anillos y aretes. Accesorios que brillan y realzan tu estilo.',
        ];

        foreach ($descriptions as $nombre => $descripcion) {
            $subcategoria = Subcategoria::where('nombre', $nombre)->first();
            if ($subcategoria) {
                $subcategoria->update(['descripcion' => $descripcion]);
                echo "✓ {$nombre} - Descripción agregada\n";
            }
        }

        echo "\n✓ Descripciones de subcategorías agregadas.\n";
    }
}
