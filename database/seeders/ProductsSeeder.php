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
        DB::table('products')->insert([
            [
                'name' => 'Auriculares Pro',
                'store' => 'Tienda Plaza',
                'price' => '120 BS',
                'old_price' => '180 BS',
                'offer' => '25%',
                'color' => 'offer-red',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=300&fit=crop&q=80',
                'expires' => '20/04/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reloj Smart',
                'store' => 'Tienda Plaza',
                'price' => '350 BS',
                'old_price' => '450 BS',
                'offer' => '2x1',
                'color' => 'offer-blue',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=300&fit=crop&q=80',
                'expires' => '22/04/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bolso Urbano',
                'store' => 'Moda Express',
                'price' => '90 BS',
                'old_price' => '120 BS',
                'offer' => 'Especial',
                'color' => 'offer-purple',
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=300&h=300&fit=crop&q=80',
                'expires' => '25/04/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Zapatos Trend',
                'store' => 'Moda Express',
                'price' => '150 BS',
                'old_price' => '190 BS',
                'offer' => '20%',
                'color' => 'offer-red',
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=300&fit=crop&q=80',
                'expires' => '23/04/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Camisa Casual',
                'store' => 'Moda Express',
                'price' => '80 BS',
                'old_price' => '110 BS',
                'offer' => '2x1',
                'color' => 'offer-blue',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=300&h=300&fit=crop&q=80',
                'expires' => '26/04/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Set de Accesorios',
                'store' => 'Moda Express',
                'price' => '60 BS',
                'old_price' => '80 BS',
                'offer' => 'Especial',
                'color' => 'offer-purple',
                'image' => 'https://images.unsplash.com/photo-1611652022419-2dcff5b2b35f?w=300&h=300&fit=crop&q=80',
                'expires' => '28/04/2026',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}