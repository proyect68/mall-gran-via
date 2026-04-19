<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Moda y accesorios',
                'description' => 'Ropa, zapatos, bolsos y accesorios de moda para hombres, mujeres y niños.',
                'image' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Tecnologia y electronica',
                'description' => 'Smartphones, laptops, computadoras, tablets y accesorios tecnológicos.',
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Electrodomésticos',
                'description' => 'Refrigeradores, lavadoras, microondas y otros electrodomésticos para el hogar.',
                'image' => 'https://images.unsplash.com/photo-1584622181563-430f63602d4b?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Hogar y decoración',
                'description' => 'Muebles, cortinas, cuadros, plantas y elementos decorativos para tu hogar.',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Belleza y cuidado personal',
                'description' => 'Cosméticos, perfumes, cuidado de la piel y productos de higiene personal.',
                'image' => 'https://images.unsplash.com/photo-1596462502278-af242a95ab2b?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Deportes y entretenimiento',
                'description' => 'Equipos deportivos, videojuegos, juguetes y artículos de entretenimiento.',
                'image' => 'https://images.unsplash.com/photo-1552810519-7a41ec4a3932?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Niños y bebés',
                'description' => 'Ropa para bebés, juguetes, puericultura y artículos para el cuidado de los niños.',
                'image' => 'https://images.unsplash.com/photo-1515488846472-f151bc41816d?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Comida y restaurantes',
                'description' => 'Alimentos, bebidas, comida rápida, restaurantes y servicios de catering.',
                'image' => 'https://images.unsplash.com/photo-1495523821757-a1efb6729352?w=400&h=300&fit=crop&q=80',
            ],
            [
                'name' => 'Servicios',
                'description' => 'Servicios diversos: spa, consultoría, asesoramiento y otros servicios profesionales.',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop&q=80',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
