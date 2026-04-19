<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SuperOfertasController extends Controller
{
    /**
     * Mostrar la página de superofertas
     */
    public function index(Request $request)
    {
        // Cargar todos los productos de la BD
        $allProducts = Product::all()->toArray();

        // Obtener parámetros de filtrado
        $priceMin = $request->query('priceMin');
        $priceMax = $request->query('priceMax');
        $storeFilter = $request->query('storeFilter');
        $offerOnly = $request->query('offerOnly');

        // Filtrar solo productos con oferta
        $productsWithOffer = array_filter($allProducts, function($p) use ($priceMin, $priceMax, $storeFilter) {
            // Debe tener oferta
            if (empty($p['offer'])) return false;
            // No debe ser servicio
            if ((int)$p['is_service'] === 1) return false;
            
            // Aplicar filtro de precio mínimo
            if (!empty($priceMin) && (float)$p['price'] < (float)$priceMin) return false;
            
            // Aplicar filtro de precio máximo
            if (!empty($priceMax) && (float)$p['price'] > (float)$priceMax) return false;
            
            // Aplicar filtro de tienda
            if (!empty($storeFilter) && stripos($p['store'], $storeFilter) === false) return false;
            
            return true;
        });

        // Agrupar productos con oferta por tienda
        $storeGroupedProducts = [];
        foreach ($productsWithOffer as $product) {
            if (!isset($storeGroupedProducts[$product['store']])) {
                $storeGroupedProducts[$product['store']] = [];
            }
            $storeGroupedProducts[$product['store']][] = $product;
        }

        // Crear ofertas por tienda
        $tiendas = [];
        foreach ($storeGroupedProducts as $storeName => $products) {
            $tiendas[] = [
                'store' => $storeName,
                'products' => array_slice($products, 0, 6),
            ];
        }

        // Obtener servicios con oferta
        $servicesWithOffer = array_filter($allProducts, function($p) use ($priceMin, $priceMax, $storeFilter) {
            // Debe tener oferta
            if (empty($p['offer'])) return false;
            // Debe ser servicio
            if ((int)$p['is_service'] !== 1) return false;
            
            // Aplicar filtro de precio mínimo
            if (!empty($priceMin) && (float)$p['price'] < (float)$priceMin) return false;
            
            // Aplicar filtro de precio máximo
            if (!empty($priceMax) && (float)$p['price'] > (float)$priceMax) return false;
            
            // Aplicar filtro de tienda
            if (!empty($storeFilter) && stripos($p['store'], $storeFilter) === false) return false;
            
            return true;
        });

        $servicios = array_map(function($p) {
            return [
                'title' => $p['name'],
                'category' => $p['store'],
                'description' => 'Promoción especial: ' . ($p['offer'] ?: 'Oferta disponible'),
                'price' => $p['price'],
                'old_price' => $p['old_price'] ?? null,
                'badge' => $p['offer'] ?? 'Oferta',
                'color' => $p['color'] ?? 'offer-red',
                'image' => $p['image'] ?? 'https://via.placeholder.com/400x300/cccccc/666666?text=Servicio',
                'expires' => $p['expires'] ?? null,
            ];
        }, array_slice(array_filter($servicesWithOffer, function($p) {
            return stripos($p['name'] ?? '', 'combo') === false;
        }), 0, 12));

        // Obtener comidas (productos de tiendas de comida con oferta)
        $comidasRaw = array_filter($allProducts, function($p) use ($priceMin, $priceMax, $storeFilter) {
            $storeName = strtolower($p['store'] ?? '');
            $productName = strtolower($p['name'] ?? '');
            $isFoodStore = stripos($storeName, 'comida') !== false || 
                          stripos($storeName, 'restaurante') !== false ||
                          stripos($storeName, 'comidas') !== false ||
                          stripos($storeName, 'food') !== false ||
                          stripos($productName, 'combo') !== false;
            
            // Debe tener oferta y ser producto de comida
            if (empty($p['offer']) || (int)$p['is_service'] === 1 || !$isFoodStore) return false;
            
            // Aplicar filtro de precio mínimo
            if (!empty($priceMin) && (float)$p['price'] < (float)$priceMin) return false;
            
            // Aplicar filtro de precio máximo
            if (!empty($priceMax) && (float)$p['price'] > (float)$priceMax) return false;
            
            // Aplicar filtro de tienda
            if (!empty($storeFilter) && stripos($p['store'], $storeFilter) === false) return false;
            
            return true;
        });

        // Agrupar comidas por tienda
        $storeGroupedComidas = [];
        foreach ($comidasRaw as $product) {
            if (!isset($storeGroupedComidas[$product['store']])) {
                $storeGroupedComidas[$product['store']] = [];
            }
            $storeGroupedComidas[$product['store']][] = $product;
        }

        // Crear ofertas de comida por tienda
        $comidas = [];
        foreach ($storeGroupedComidas as $storeName => $products) {
            $comidas[] = [
                'store' => $storeName,
                'products' => array_slice($products, 0, 6),
            ];
        }
        
        // Agregar servicios que son combos a comidas
        $combosFromServices = array_filter($servicesWithOffer, function($p) {
            return stripos($p['name'] ?? '', 'combo') !== false;
        });
        if (!empty($combosFromServices)) {
            $combosByStore = [];
            foreach ($combosFromServices as $combo) {
                if (!isset($combosByStore[$combo['store']])) {
                    $combosByStore[$combo['store']] = [];
                }
                $combosByStore[$combo['store']][] = $combo;
            }
            foreach ($combosByStore as $storeName => $products) {
                $comidas[] = [
                    'store' => $storeName,
                    'products' => array_slice($products, 0, 6),
                ];
            }
        }

        // Carrusel de información
        $carouselSlides = [
            [
                'title' => 'SuperOfertas',
                'text' => 'Descubre las mejores ofertas de nuestro mall: descuentos, 2x1, combos especiales y promociones imperdibles.',
                'image' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1200&h=600&fit=crop&q=80'
            ],
            [
                'title' => 'Tiendas con Ofertas',
                'text' => 'Explora nuestras tiendas con productos en promoción. Descuentos especiales esperándote.',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=600&fit=crop&q=80'
            ],
            [
                'title' => 'Servicios Especiales',
                'text' => 'Disfruta de servicios con ofertas exclusivas. Promociones que no puedes perderte.',
                'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&h=600&fit=crop&q=80'
            ],
            [
                'title' => 'Comidas Deliciosas',
                'text' => 'Las mejores comidas del mall con promociones especiales. ¡Ahorra mientras disfrutas!',
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=1200&h=600&fit=crop&q=80'
            ],
        ];

        // Obtener tiendas disponibles
        $availableStores = array_values(array_unique(array_map(fn($p) => $p['store'], $allProducts)));

        return view('superofertas', [
            'heroSlides' => $carouselSlides,
            'tiendas' => $tiendas,
            'servicios' => $servicios,
            'comidas' => $comidas,
            'availableStores' => $availableStores,
        ]);
    }
}
