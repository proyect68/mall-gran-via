<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DashboardProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->truncate();

        $categoryModa = Category::where('nombre', 'Moda y accesorios')->first();
        $categoryTecnologia = Category::where('nombre', 'Tecnologia y electronica')->first();
        $categoryBelleza = Category::where('nombre', 'Belleza y cuidado personal')->first();
        $categoryDeportes = Category::where('nombre', 'Deportes y entretenimiento')->first();
        $categoryHogar = Category::where('nombre', 'Hogar y decoracion')->first();
        $categoryServicios = Category::where('nombre', 'Servicios')->first();
        $categoryComida = Category::where('nombre', 'Comida y restaurantes')->first();

        $products = [
            ['nombre' => 'Auriculares Pro', 'tienda' => 'Tienda Plaza', 'precio' => '120 BS', 'precio_anterior' => '180 BS', 'oferta' => '25%', 'color' => 'offer-red', 'expira' => '12/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/5a5a5a/ffffff?text=Auriculares+Pro', 'es_servicio' => false, 'categoria_id' => $categoryTecnologia->id ?? null],
            ['nombre' => 'Reloj Smart', 'tienda' => 'Tienda Plaza', 'precio' => '350 BS', 'precio_anterior' => '450 BS', 'oferta' => '2x1', 'color' => 'offer-blue', 'expira' => '15/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/3d3d3d/ffffff?text=Reloj+Smart', 'es_servicio' => false, 'categoria_id' => $categoryTecnologia->id ?? null],
            ['nombre' => 'Bolso Urbano', 'tienda' => 'Tienda Plaza', 'precio' => '90 BS', 'precio_anterior' => '120 BS', 'oferta' => 'Especial', 'color' => 'offer-purple', 'expira' => '18/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/8b7355/ffffff?text=Bolso+Urbano', 'es_servicio' => false, 'categoria_id' => $categoryModa->id ?? null],
            ['nombre' => 'Zapatos Trend', 'tienda' => 'Moda Express', 'precio' => '150 BS', 'precio_anterior' => '190 BS', 'oferta' => '20%', 'color' => 'offer-red', 'expira' => '14/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/2c2c2c/ffffff?text=Zapatos+Trend', 'es_servicio' => false, 'categoria_id' => $categoryModa->id ?? null],
            ['nombre' => 'Camisa Casual', 'tienda' => 'Moda Express', 'precio' => '80 BS', 'precio_anterior' => '110 BS', 'oferta' => '2x1', 'color' => 'offer-blue', 'expira' => '16/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/4d4d4d/ffffff?text=Camisa+Casual', 'es_servicio' => false, 'categoria_id' => $categoryModa->id ?? null],
            ['nombre' => 'Set de Accesorios', 'tienda' => 'Moda Express', 'precio' => '60 BS', 'precio_anterior' => '80 BS', 'oferta' => 'Especial', 'color' => 'offer-purple', 'expira' => '19/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/6b6b6b/ffffff?text=Accesorios', 'es_servicio' => false, 'categoria_id' => $categoryModa->id ?? null],
            ['nombre' => 'Masaje Relajante', 'tienda' => 'Spa & Bienestar', 'precio' => 'Consultar', 'precio_anterior' => null, 'oferta' => '25%', 'color' => 'offer-red', 'expira' => '20/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/d4a5a5/ffffff?text=Masaje+Relajante', 'es_servicio' => true, 'categoria_id' => $categoryServicios->id ?? null],
            ['nombre' => 'Combo Sabor Burger', 'tienda' => 'Patio de Comidas', 'precio' => '65 BS', 'precio_anterior' => null, 'oferta' => '2x1', 'color' => 'offer-blue', 'expira' => '22/04/2026', 'imagen' => 'https://via.placeholder.com/300x300/8b6914/ffffff?text=Combo+Burger', 'es_servicio' => true, 'categoria_id' => $categoryComida->id ?? null],
            ['nombre' => 'Smart TV 55"', 'tienda' => 'ElectroMall', 'precio' => '2,500 BS', 'precio_anterior' => null, 'oferta' => '15%', 'color' => 'offer-red', 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/1a1a1a/ffffff?text=Smart+TV', 'es_servicio' => false, 'categoria_id' => $categoryTecnologia->id ?? null],
            ['nombre' => 'Camara deportiva', 'tienda' => 'FotoClick', 'precio' => '450 BS', 'precio_anterior' => null, 'oferta' => null, 'color' => null, 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/4a4a4a/ffffff?text=Camara+Deportiva', 'es_servicio' => false, 'categoria_id' => $categoryDeportes->id ?? null],
            ['nombre' => 'Perfume Luxury', 'tienda' => 'Beauty Shop', 'precio' => '220 BS', 'precio_anterior' => null, 'oferta' => 'Especial', 'color' => 'offer-purple', 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/c084a0/ffffff?text=Perfume+Luxury', 'es_servicio' => false, 'categoria_id' => $categoryBelleza->id ?? null],
            ['nombre' => 'Zapatillas Run', 'tienda' => 'Deportes Plus', 'precio' => '310 BS', 'precio_anterior' => null, 'oferta' => '2x1', 'color' => 'offer-blue', 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/3a3a3a/ffffff?text=Zapatillas+Run', 'es_servicio' => false, 'categoria_id' => $categoryDeportes->id ?? null],
            ['nombre' => 'Auriculares Gaming', 'tienda' => 'TecnoShop', 'precio' => '180 BS', 'precio_anterior' => null, 'oferta' => null, 'color' => null, 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/2a2a2a/ffffff?text=Auriculares+Gaming', 'es_servicio' => false, 'categoria_id' => $categoryTecnologia->id ?? null],
            ['nombre' => 'Set de maquillaje', 'tienda' => 'Beauty Shop', 'precio' => '140 BS', 'precio_anterior' => null, 'oferta' => '25%', 'color' => 'offer-red', 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/e0a0d0/ffffff?text=Maquillaje', 'es_servicio' => false, 'categoria_id' => $categoryBelleza->id ?? null],
            ['nombre' => 'Silla Oficina', 'tienda' => 'Hogar Feliz', 'precio' => '360 BS', 'precio_anterior' => null, 'oferta' => null, 'color' => null, 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/5a4a4a/ffffff?text=Silla+Oficina', 'es_servicio' => false, 'categoria_id' => $categoryHogar->id ?? null],
            ['nombre' => 'Laptop Ultra', 'tienda' => 'ElectroMall', 'precio' => '4,200 BS', 'precio_anterior' => null, 'oferta' => '15%', 'color' => 'offer-red', 'expira' => null, 'imagen' => 'https://via.placeholder.com/300x300/0a0a0a/ffffff?text=Laptop+Ultra', 'es_servicio' => false, 'categoria_id' => $categoryTecnologia->id ?? null],
        ];

        foreach ($products as $product) {
            DB::table('productos')->insert(array_merge($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
