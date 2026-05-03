<?php

namespace Database\Seeders;

use App\Models\Tienda;
use Illuminate\Database\Seeder;

class TiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiendas = [
            [
                'nombre' => 'Moda Express',
                'descripcion' => 'Tienda de moda casual y accesorios con las mejores tendencias del momento.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FF6B9D/FFFFFF?text=Moda+Express',
                'logo_url' => 'https://via.placeholder.com/200x200/FF6B9D/FFFFFF?text=ME',
                'ubicacion' => 'Piso 1, Local 105',
                'estado' => 'activa',
                'horario' => '10:00 - 20:00',
            ],
            [
                'nombre' => 'Spa & Bienestar',
                'descripcion' => 'Centro de relajación y bienestar con servicios de masajes y tratamientos spa.',
                'banner_url' => 'https://via.placeholder.com/1200x300/9D4EDD/FFFFFF?text=Spa+Bienestar',
                'logo_url' => 'https://via.placeholder.com/200x200/9D4EDD/FFFFFF?text=SB',
                'ubicacion' => 'Piso 2, Local 210',
                'estado' => 'activa',
                'horario' => '09:00 - 18:00',
            ],
            [
                'nombre' => 'ElectroMall',
                'descripcion' => 'Tu destino para electrónica, gadgets y accesorios de última tecnología.',
                'banner_url' => 'https://via.placeholder.com/1200x300/00BBF9/FFFFFF?text=ElectroMall',
                'logo_url' => 'https://via.placeholder.com/200x200/00BBF9/FFFFFF?text=EM',
                'ubicacion' => 'Piso 1, Local 110',
                'estado' => 'activa',
                'horario' => '10:00 - 21:00',
            ],
            [
                'nombre' => 'Spa Relax',
                'descripcion' => 'Oasis de tranquilidad con servicios de masaje terapéutico y aromaterapia.',
                'banner_url' => 'https://via.placeholder.com/1200x300/06FFA5/FFFFFF?text=Spa+Relax',
                'logo_url' => 'https://via.placeholder.com/200x200/06FFA5/FFFFFF?text=SR',
                'ubicacion' => 'Piso 3, Local 305',
                'estado' => 'activa',
                'horario' => '09:00 - 19:00',
            ],
            [
                'nombre' => 'Tienda Plaza',
                'descripcion' => 'Variedad de productos de calidad para toda la familia.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FFFB00/FFFFFF?text=Tienda+Plaza',
                'logo_url' => 'https://via.placeholder.com/200x200/FFFB00/FFFFFF?text=TP',
                'ubicacion' => 'Piso 1, Local 115',
                'estado' => 'activa',
                'horario' => '10:00 - 20:00',
            ],
            [
                'nombre' => 'TecnoShop',
                'descripcion' => 'Tecnología de punta con los mejores precios y atención profesional.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FF006E/FFFFFF?text=TecnoShop',
                'logo_url' => 'https://via.placeholder.com/200x200/FF006E/FFFFFF?text=TS',
                'ubicacion' => 'Piso 2, Local 215',
                'estado' => 'activa',
                'horario' => '10:00 - 20:00',
            ],
            [
                'nombre' => 'Beauty Shop',
                'descripcion' => 'Cosméticos y productos de belleza de las mejores marcas internacionales.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FB5607/FFFFFF?text=Beauty+Shop',
                'logo_url' => 'https://via.placeholder.com/200x200/FB5607/FFFFFF?text=BS',
                'ubicacion' => 'Piso 1, Local 120',
                'estado' => 'activa',
                'horario' => '10:00 - 20:00',
            ],
            [
                'nombre' => 'Studio Wellness',
                'descripcion' => 'Centro de salud integral con yoga, pilates y terapias alternativas.',
                'banner_url' => 'https://via.placeholder.com/1200x300/3A86FF/FFFFFF?text=Studio+Wellness',
                'logo_url' => 'https://via.placeholder.com/200x200/3A86FF/FFFFFF?text=SW',
                'ubicacion' => 'Piso 3, Local 310',
                'estado' => 'activa',
                'horario' => '08:00 - 18:00',
            ],
            [
                'nombre' => 'Hogar Feliz',
                'descripcion' => 'Decoración, muebles y artículos para hacer tu hogar más acogedor.',
                'banner_url' => 'https://via.placeholder.com/1200x300/8338EC/FFFFFF?text=Hogar+Feliz',
                'logo_url' => 'https://via.placeholder.com/200x200/8338EC/FFFFFF?text=HF',
                'ubicacion' => 'Piso 2, Local 220',
                'estado' => 'activa',
                'horario' => '10:00 - 19:00',
            ],
            [
                'nombre' => 'FotoClick',
                'descripcion' => 'Servicios fotográficos profesionales y accesorios para fotógrafos.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FFBE0B/FFFFFF?text=FotoClick',
                'logo_url' => 'https://via.placeholder.com/200x200/FFBE0B/FFFFFF?text=FC',
                'ubicacion' => 'Piso 1, Local 125',
                'estado' => 'activa',
                'horario' => '10:00 - 18:00',
            ],
            [
                'nombre' => 'Deportes Plus',
                'descripcion' => 'Equipamiento deportivo y ropa atlética de marcas reconocidas.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FF006E/FFFFFF?text=Deportes+Plus',
                'logo_url' => 'https://via.placeholder.com/200x200/FF006E/FFFFFF?text=DP',
                'ubicacion' => 'Piso 2, Local 225',
                'estado' => 'activa',
                'horario' => '10:00 - 20:00',
            ],
            [
                'nombre' => 'Patio de Comidas',
                'descripcion' => 'Variedad de sabores internacionales y comida rápida de calidad.',
                'banner_url' => 'https://via.placeholder.com/1200x300/FF4500/FFFFFF?text=Patio+Comidas',
                'logo_url' => 'https://via.placeholder.com/200x200/FF4500/FFFFFF?text=PC',
                'ubicacion' => 'Piso 3, Local 315',
                'estado' => 'activa',
                'horario' => '11:00 - 21:00',
            ],
        ];

        foreach ($tiendas as $tienda) {
            Tienda::updateOrCreate(
                ['nombre' => $tienda['nombre']],
                $tienda
            );
        }
    }
}
