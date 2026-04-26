<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'nombre' => 'Auriculares Pro',
                'tienda' => 'Tienda Plaza',
                'precio' => '120 BS',
                'precio_anterior' => '180 BS',
                'oferta' => '25%',
                'color' => 'offer-red',
                'imagen' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=300&fit=crop&q=80',
                'expira' => '20/04/2026',
                'es_servicio' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Reloj Smart',
                'tienda' => 'Tienda Plaza',
                'precio' => '350 BS',
                'precio_anterior' => '450 BS',
                'oferta' => '2x1',
                'color' => 'offer-blue',
                'imagen' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=300&fit=crop&q=80',
                'expira' => '22/04/2026',
                'es_servicio' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Bolso Urbano',
                'tienda' => 'Moda Express',
                'precio' => '90 BS',
                'precio_anterior' => '120 BS',
                'oferta' => 'Especial',
                'color' => 'offer-purple',
                'imagen' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=300&h=300&fit=crop&q=80',
                'expira' => '25/04/2026',
                'es_servicio' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Zapatos Trend',
                'tienda' => 'Moda Express',
                'precio' => '150 BS',
                'precio_anterior' => '190 BS',
                'oferta' => '20%',
                'color' => 'offer-red',
                'imagen' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=300&fit=crop&q=80',
                'expira' => '23/04/2026',
                'es_servicio' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Camisa Casual',
                'tienda' => 'Moda Express',
                'precio' => '80 BS',
                'precio_anterior' => '110 BS',
                'oferta' => '2x1',
                'color' => 'offer-blue',
                'imagen' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=300&h=300&fit=crop&q=80',
                'expira' => '26/04/2026',
                'es_servicio' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Set de Accesorios',
                'tienda' => 'Moda Express',
                'precio' => '60 BS',
                'precio_anterior' => '80 BS',
                'oferta' => 'Especial',
                'color' => 'offer-purple',
                'imagen' => 'https://images.unsplash.com/photo-1611652022419-2dcff5b2b35f?w=300&h=300&fit=crop&q=80',
                'expira' => '28/04/2026',
                'es_servicio' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
