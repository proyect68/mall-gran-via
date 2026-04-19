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
        // Limpiar productos existentes para evitar duplicados
        DB::table('products')->truncate();

        // Obtener categorías por nombre para asignarlas a los productos
        $categoryModa = Category::where('name', 'Moda y accesorios')->first();
        $categoryTecnologia = Category::where('name', 'Tecnologia y electronica')->first();
        $categoryBelleza = Category::where('name', 'Belleza y cuidado personal')->first();
        $categoryDeportes = Category::where('name', 'Deportes y entretenimiento')->first();
        $categoryHogar = Category::where('name', 'Hogar y decoración')->first();
        $categoryServicios = Category::where('name', 'Servicios')->first();
        $categoryComida = Category::where('name', 'Comida y restaurantes')->first();

        $products = [
            // Ofertas del día - Tienda Plaza (Tecnología)
            ['name' => 'Auriculares Pro', 'store' => 'Tienda Plaza', 'price' => '120 BS', 'old_price' => '180 BS', 'offer' => '25%', 'color' => 'offer-red', 'expires' => '12/04/2026', 'image' => 'https://via.placeholder.com/300x300/5a5a5a/ffffff?text=Auriculares+Pro', 'is_service' => false, 'category_id' => $categoryTecnologia->id ?? null],
            ['name' => 'Reloj Smart', 'store' => 'Tienda Plaza', 'price' => '350 BS', 'old_price' => '450 BS', 'offer' => '2x1', 'color' => 'offer-blue', 'expires' => '15/04/2026', 'image' => 'https://via.placeholder.com/300x300/3d3d3d/ffffff?text=Reloj+Smart', 'is_service' => false, 'category_id' => $categoryTecnologia->id ?? null],
            ['name' => 'Bolso Urbano', 'store' => 'Tienda Plaza', 'price' => '90 BS', 'old_price' => '120 BS', 'offer' => 'Especial', 'color' => 'offer-purple', 'expires' => '18/04/2026', 'image' => 'https://via.placeholder.com/300x300/8b7355/ffffff?text=Bolso+Urbano', 'is_service' => false, 'category_id' => $categoryModa->id ?? null],

            // Ofertas del día - Moda Express (Moda)
            ['name' => 'Zapatos Trend', 'store' => 'Moda Express', 'price' => '150 BS', 'old_price' => '190 BS', 'offer' => '20%', 'color' => 'offer-red', 'expires' => '14/04/2026', 'image' => 'https://via.placeholder.com/300x300/2c2c2c/ffffff?text=Zapatos+Trend', 'is_service' => false, 'category_id' => $categoryModa->id ?? null],
            ['name' => 'Camisa Casual', 'store' => 'Moda Express', 'price' => '80 BS', 'old_price' => '110 BS', 'offer' => '2x1', 'color' => 'offer-blue', 'expires' => '16/04/2026', 'image' => 'https://via.placeholder.com/300x300/4d4d4d/ffffff?text=Camisa+Casual', 'is_service' => false, 'category_id' => $categoryModa->id ?? null],
            ['name' => 'Set de Accesorios', 'store' => 'Moda Express', 'price' => '60 BS', 'old_price' => '80 BS', 'offer' => 'Especial', 'color' => 'offer-purple', 'expires' => '19/04/2026', 'image' => 'https://via.placeholder.com/300x300/6b6b6b/ffffff?text=Accesorios', 'is_service' => false, 'category_id' => $categoryModa->id ?? null],

            // Promos del día - Servicios y Comida
            ['name' => 'Masaje Relajante', 'store' => 'Spa & Bienestar', 'price' => 'Consultar', 'old_price' => null, 'offer' => '25%', 'color' => 'offer-red', 'expires' => '20/04/2026', 'image' => 'https://via.placeholder.com/300x300/d4a5a5/ffffff?text=Masaje+Relajante', 'is_service' => true, 'category_id' => $categoryServicios->id ?? null],
            ['name' => 'Combo Sabor Burger', 'store' => 'Patio de Comidas', 'price' => '65 BS', 'old_price' => null, 'offer' => '2x1', 'color' => 'offer-blue', 'expires' => '22/04/2026', 'image' => 'https://via.placeholder.com/300x300/8b6914/ffffff?text=Combo+Burger', 'is_service' => true, 'category_id' => $categoryComida->id ?? null],

            // Productos que pueden interesarte
            ['name' => 'Smart TV 55"', 'store' => 'ElectroMall', 'price' => '2,500 BS', 'old_price' => null, 'offer' => '15%', 'color' => 'offer-red', 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/1a1a1a/ffffff?text=Smart+TV', 'is_service' => false, 'category_id' => $categoryTecnologia->id ?? null],
            ['name' => 'Cámara deportiva', 'store' => 'FotoClick', 'price' => '450 BS', 'old_price' => null, 'offer' => null, 'color' => null, 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/4a4a4a/ffffff?text=Camara+Deportiva', 'is_service' => false, 'category_id' => $categoryDeportes->id ?? null],
            ['name' => 'Perfume Luxury', 'store' => 'Beauty Shop', 'price' => '220 BS', 'old_price' => null, 'offer' => 'Especial', 'color' => 'offer-purple', 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/c084a0/ffffff?text=Perfume+Luxury', 'is_service' => false, 'category_id' => $categoryBelleza->id ?? null],
            ['name' => 'Zapatillas Run', 'store' => 'Deportes Plus', 'price' => '310 BS', 'old_price' => null, 'offer' => '2x1', 'color' => 'offer-blue', 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/3a3a3a/ffffff?text=Zapatillas+Run', 'is_service' => false, 'category_id' => $categoryDeportes->id ?? null],
            ['name' => 'Auriculares Gaming', 'store' => 'TecnoShop', 'price' => '180 BS', 'old_price' => null, 'offer' => null, 'color' => null, 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/2a2a2a/ffffff?text=Auriculares+Gaming', 'is_service' => false, 'category_id' => $categoryTecnologia->id ?? null],
            ['name' => 'Set de maquillaje', 'store' => 'Beauty Shop', 'price' => '140 BS', 'old_price' => null, 'offer' => '25%', 'color' => 'offer-red', 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/e0a0d0/ffffff?text=Maquillaje', 'is_service' => false, 'category_id' => $categoryBelleza->id ?? null],
            ['name' => 'Silla Oficina', 'store' => 'Hogar Feliz', 'price' => '360 BS', 'old_price' => null, 'offer' => null, 'color' => null, 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/5a4a4a/ffffff?text=Silla+Oficina', 'is_service' => false, 'category_id' => $categoryHogar->id ?? null],
            ['name' => 'Laptop Ultra', 'store' => 'ElectroMall', 'price' => '4,200 BS', 'old_price' => null, 'offer' => '15%', 'color' => 'offer-red', 'expires' => null, 'image' => 'https://via.placeholder.com/300x300/0a0a0a/ffffff?text=Laptop+Ultra', 'is_service' => false, 'category_id' => $categoryTecnologia->id ?? null],
        ];

        // Insertar productos
        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
