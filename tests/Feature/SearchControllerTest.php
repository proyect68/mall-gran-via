<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_can_use_fastapi_when_enabled(): void
    {
        Config::set('services.fastapi.search_enabled', true);

        Http::fake([
            'http://127.0.0.1:8001/api/v1/busqueda*' => Http::response([
                'query' => 'auriculares',
                'productos' => [
                    [
                        'id' => 999,
                        'nombre' => 'Producto Remoto',
                        'tienda' => 'Tienda API',
                        'precio' => '100 BS',
                        'precio_anterior' => '120 BS',
                        'oferta' => '20%',
                        'color' => 'offer-red',
                        'imagen' => null,
                        'expira' => null,
                        'es_servicio' => false,
                        'categoria_id' => 1,
                        'subcategoria_id' => 1,
                    ],
                ],
                'servicios' => [],
                'tiendas_relacionadas' => [],
                'pagina_actual' => 1,
                'total_paginas_productos' => 1,
                'total_paginas_servicios' => 1,
                'total_productos' => 1,
                'total_servicios' => 0,
                'precio_minimo' => null,
                'precio_maximo' => null,
                'tienda' => null,
                'solo_ofertas' => false,
                'mostrando_todo' => false,
            ], 200),
        ]);

        $response = $this->get('/search?q=auriculares');

        $response->assertOk();
        $response->assertSee('Producto Remoto');
        $response->assertViewHas('searchSource', 'fastapi');
    }

    public function test_search_falls_back_to_laravel_when_fastapi_fails(): void
    {
        Config::set('services.fastapi.search_enabled', true);

        Product::create([
            'nombre' => 'Auriculares Locales',
            'tienda' => 'Tienda Local',
            'precio' => '150 BS',
            'precio_anterior' => '200 BS',
            'oferta' => '25%',
            'color' => 'offer-red',
            'imagen' => null,
            'expira' => null,
            'es_servicio' => false,
            'categoria_id' => null,
            'subcategoria_id' => null,
        ]);

        Http::fake([
            'http://127.0.0.1:8001/api/v1/busqueda*' => Http::response([], 500),
        ]);

        $response = $this->get('/search?q=auriculares');

        $response->assertOk();
        $response->assertSee('Auriculares Locales');
        $response->assertViewHas('searchSource', 'laravel');
    }
}
