<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tienda;
use App\Services\FastApi\SearchApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SearchController extends Controller
{
    /**
     * Busca productos, tiendas y servicios con búsqueda inteligente
     */
    public function search(Request $request)
    {
        $params = [
            'q' => $request->input('q'),
            'page' => (int) $request->input('page', 1),
            'priceMin' => $request->input('priceMin'),
            'priceMax' => $request->input('priceMax'),
            'storeFilter' => $request->input('storeFilter'),
            'offerOnly' => $request->input('offerOnly'),
        ];

        $remoteResult = $this->searchUsingFastApi($params);

        if ($remoteResult !== null) {
            return view('search.results', $remoteResult);
        }

        $query = $params['q'];
        $page = $params['page'];
        $priceMin = $params['priceMin'];
        $priceMax = $params['priceMax'];
        $storeFilter = $params['storeFilter'];
        $offerOnly = $params['offerOnly'];
        
        $perPage = 28; // 4 filas × 7 columnas
        
        // Iniciar query builder en lugar de traer todo a memoria
        $productQuery = Product::query();

        // Aplicar filtros básicos en la base de datos (más profesional y rápido)
        if ($storeFilter) {
            $productQuery->where('tienda', 'ilike', "%{$storeFilter}%");
        }

        if ($offerOnly === 'on' || $offerOnly === '1' || $offerOnly === true) {
            $productQuery->whereNotNull('oferta')->where('oferta', '!=', '');
        }

        $allProducts = $productQuery
            ->get()
            ->map(fn (Product $product) => $this->normalizeProductModel($product))
            ->all();
        
        // Si no hay query válida, mostrar todos los productos
        if (!$query || strlen($query) < 2) {
            $searchResults = $allProducts;
        } else {
            // Buscar productos con coincidencias inteligentes
            $searchResults = $this->intelligentSearch($allProducts, $query, $storeFilter);
        }

        // Separar servicios de productos
        $productsOnly = array_filter($searchResults, function($p) { return !$p['is_service']; });
        $servicesOnly = array_filter($searchResults, function($p) { return $p['is_service']; });
        
        // Aplicar filtros a productos
        $filteredProducts = array_filter($productsOnly, function ($product) use ($priceMin, $priceMax, $storeFilter, $offerOnly) {
            // Filtro de precio mínimo
            if ($priceMin !== null && $priceMin !== '') {
                $productPrice = $this->extractPrice($product['price']);
                if ($productPrice < floatval($priceMin)) {
                    return false;
                }
            }
            
            // Filtro de precio máximo
            if ($priceMax !== null && $priceMax !== '') {
                $productPrice = $this->extractPrice($product['price']);
                if ($productPrice > floatval($priceMax)) {
                    return false;
                }
            }
            
            // Filtro de tienda específica
            if ($storeFilter !== null && $storeFilter !== '') {
                if (stripos($product['store'], $storeFilter) === false) {
                    return false;
                }
            }
            
            // Filtro solo ofertas
            if ($offerOnly === 'on' || $offerOnly === '1' || $offerOnly === true) {
                if (empty($product['offer'])) {
                    return false;
                }
            }
            
            return true;
        });
        
        // Aplicar filtros a servicios
        $filteredServices = array_filter($servicesOnly, function ($service) use ($priceMin, $priceMax, $storeFilter, $offerOnly) {
            // Filtro de precio mínimo (no aplica si precio es "Consultar")
            if ($priceMin !== null && $priceMin !== '' && $service['price'] !== 'Consultar') {
                $servicePrice = $this->extractPrice($service['price']);
                if ($servicePrice < floatval($priceMin)) {
                    return false;
                }
            }
            
            // Filtro de precio máximo (no aplica si precio es "Consultar")
            if ($priceMax !== null && $priceMax !== '' && $service['price'] !== 'Consultar') {
                $servicePrice = $this->extractPrice($service['price']);
                if ($servicePrice > floatval($priceMax)) {
                    return false;
                }
            }
            
            // Filtro de tienda específica
            if ($storeFilter !== null && $storeFilter !== '') {
                if (stripos($service['store'], $storeFilter) === false) {
                    return false;
                }
            }
            
            // Filtro solo ofertas
            if ($offerOnly === 'on' || $offerOnly === '1' || $offerOnly === true) {
                if (empty($service['offer'])) {
                    return false;
                }
            }
            
            return true;
        });
        
        // Re-indexar arrays después del filter
        $filteredProducts = array_values($filteredProducts);
        $filteredServices = array_values($filteredServices);

        // Calcular paginación para productos
        $totalProducts = count($filteredProducts);
        $totalPages = ceil($totalProducts / $perPage);
        $page = max(1, min($page, $totalPages ?: 1)); // Asegurar que la página sea válida
        
        // Obtener productos para la página actual
        $start = ($page - 1) * $perPage;
        $products = array_slice($filteredProducts, $start, $perPage);
        
        // Calcular paginación para servicios
        $totalServices = count($filteredServices);
        $totalPages_services = ceil($totalServices / $perPage);
        $services = array_slice($filteredServices, $start, $perPage);

        // Agrupar tiendas con sus productos relacionados (de TODOS los resultados, no solo de la página actual)
        $allFilteredResults = array_merge($filteredProducts, $filteredServices);
        $storesByName = collect($allFilteredResults)->groupBy('store');
        
        $relatedStores = collect();
        if ($page == 1) { // Solo mostrar tiendas en la página 1
            $relatedStores = $this->storesFromNames($storesByName->keys(), $storesByName);
        }

        return view('search.results', [
            'query' => $query,
            'products' => $products,
            'services' => $services,
            'relatedStores' => $relatedStores,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPages_services' => $totalPages_services,
            'totalProducts' => $totalProducts,
            'totalServices' => $totalServices,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
            'storeFilter' => $storeFilter,
            'offerOnly' => $offerOnly,
            'isShowingAll' => !$query || strlen($query) < 2,
            'searchSource' => 'laravel',
        ]);
    }

    private function searchUsingFastApi(array $params): ?array
    {
        if (! config('services.fastapi.search_enabled')) {
            return null;
        }

        try {
            $payload = app(SearchApiClient::class)->search($params);

            $normalizedStores = $this->normalizeStores($payload['tiendas_relacionadas'] ?? []);

            return [
                'query' => $payload['query'] ?? $params['q'],
                'products' => $this->normalizeProducts($payload['productos'] ?? []),
                'services' => $this->normalizeProducts($payload['servicios'] ?? []),
                'relatedStores' => $this->storesFromNames(collect($normalizedStores)->pluck('name')->filter()),
                'currentPage' => $payload['pagina_actual'] ?? ($params['page'] ?? 1),
                'totalPages' => $payload['total_paginas_productos'] ?? 1,
                'totalPages_services' => $payload['total_paginas_servicios'] ?? 1,
                'totalProducts' => $payload['total_productos'] ?? 0,
                'totalServices' => $payload['total_servicios'] ?? 0,
                'priceMin' => $payload['precio_minimo'] ?? $params['priceMin'],
                'priceMax' => $payload['precio_maximo'] ?? $params['priceMax'],
                'storeFilter' => $payload['tienda'] ?? $params['storeFilter'],
                'offerOnly' => ($payload['solo_ofertas'] ?? false) ? 'on' : null,
                'isShowingAll' => $payload['mostrando_todo'] ?? false,
                'searchSource' => 'fastapi',
            ];
        } catch (Throwable $exception) {
            report($exception);

            return null;
        }
    }

    private function normalizeProducts(array $items): array
    {
        return array_map(function (array $item) {
            return [
                'id' => $item['id'] ?? null,
                'name' => $item['nombre'] ?? null,
                'store' => $item['tienda'] ?? null,
                'price' => $item['precio'] ?? null,
                'old_price' => $item['precio_anterior'] ?? null,
                'offer' => $item['oferta'] ?? null,
                'color' => $item['color'] ?? null,
                'image' => $item['imagen'] ?? null,
                'expires' => $item['expira'] ?? null,
                'is_service' => $item['es_servicio'] ?? false,
                'category_id' => $item['categoria_id'] ?? null,
                'subcategoria_id' => $item['subcategoria_id'] ?? null,
            ];
        }, $items);
    }

    private function normalizeProductModel(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'store' => $product->store,
            'price' => $product->price,
            'old_price' => $product->old_price,
            'offer' => $product->offer,
            'color' => $product->color,
            'image' => $product->image,
            'expires' => $product->expires,
            'is_service' => $product->is_service,
            'category_id' => $product->category_id,
            'subcategoria_id' => $product->subcategoria_id,
        ];
    }

    private function normalizeStores(array $stores): array
    {
        return array_map(function (array $store) {
            return [
                'name' => $store['nombre'] ?? null,
                'image' => $store['imagen'] ?? null,
                'relatedProductsCount' => $store['cantidad_productos_relacionados'] ?? 0,
                'products' => $this->normalizeProducts($store['productos'] ?? []),
                'status' => $store['estado'] ?? 'Abierto',
            ];
        }, $stores);
    }

    private function storesFromNames($storeNames, ?Collection $relatedProductsByStore = null): Collection
    {
        $names = collect($storeNames)->filter()->unique()->values();

        if ($names->isEmpty()) {
            return collect();
        }

        $stores = Tienda::query()
            ->whereIn('nombre', $names)
            ->orderBy('nombre')
            ->get();

        $stores->each(function (Tienda $tienda) use ($relatedProductsByStore) {
            $productos = Product::query()
                ->where(function ($query) use ($tienda) {
                    if (Schema::hasColumn('productos', 'tienda_id') && $tienda->getKey()) {
                        $query->where('tienda_id', $tienda->getKey());
                    }

                    $query->orWhere('tienda', $tienda->nombre);
                })
                ->with(['categoria', 'subcategoria'])
                ->get();

            $tienda->setRelation('productos', $productos);

            if ($relatedProductsByStore && $relatedProductsByStore->has($tienda->nombre)) {
                $tienda->setAttribute('related_products_count', $relatedProductsByStore->get($tienda->nombre)->count());
            }
        });

        return $stores;
    }
    
    /**
     * Búsqueda inteligente que maneja palabras relacionadas, plurales y combos tienda+producto
     */
    private function intelligentSearch($products, $query, $storeFilter = null)
    {
        // Normalizar query
        $query = trim($query);
        $queryLower = strtolower($query);
        $queryWords = preg_split('/\s+/', $queryLower, -1, PREG_SPLIT_NO_EMPTY);
        
        // Detectar si el usuario está buscando tienda + producto
        $availableStores = collect($products)->pluck('store')->filter()->unique()->toArray();
        $mentionedStore = null;
        $productKeywords = $queryWords;
        
        // Buscar si alguna tienda está mencionada en la query
        foreach ($availableStores as $storeName) {
            $storeNameLower = strtolower($storeName);
            if (stripos($queryLower, $storeNameLower) !== false) {
                $mentionedStore = $storeName;
                // Remover el nombre de la tienda de los keywords de producto
                $productKeywords = array_filter($queryWords, function($word) use ($storeNameLower) {
                    return stripos($storeNameLower, $word) === false;
                });
                $productKeywords = array_values($productKeywords); // Re-indexar
                break;
            }
        }
        
        // Si encontramos una tienda mencionada pero sin palabras de producto, aplicar filtro automático
        if ($mentionedStore && empty($productKeywords)) {
            return array_filter($products, function($product) use ($mentionedStore) {
                return stripos($product['store'], $mentionedStore) !== false;
            });
        }
        
        // Mapeo de palabras relacionadas (plural -> singular, etc)
        $wordRelations = [
            'camisas' => ['camisa'],
            'zapatos' => ['zapato'],
            'auriculares' => ['auricular'],
            'productos' => ['producto'],
            'tiendas' => ['tienda'],
            'ofertas' => ['oferta'],
            'ofertas' => ['oferta', 'promoción'],
        ];
        
        // Expandir keywords con palabras relacionadas
        $expandedKeywords = [];
        foreach ($queryWords as $word) {
            $expandedKeywords[$word] = [$word];
            
            // Agregar variaciones de palabras
            if (strlen($word) > 3) {
                // Si termina en 's', agregar la versión sin 's'
                if (substr($word, -1) === 's') {
                    $singularForm = substr($word, 0, -1);
                    $expandedKeywords[$word][] = $singularForm;
                }
                // Si no termina en 's', agregar la versión con 's'
                else {
                    $pluralForm = $word . 's';
                    $expandedKeywords[$word][] = $pluralForm;
                }
            }
            
            // Agregar relaciones pre-definidas
            if (isset($wordRelations[$word])) {
                $expandedKeywords[$word] = array_merge($expandedKeywords[$word], $wordRelations[$word]);
            }
        }
        
        // Buscar productos que coincidan con palabras expandidas
        $scoredProducts = [];
        
        foreach ($products as $product) {
            $score = 0;
            $productNameLower = strtolower($product['name']);
            $productStoreLower = strtolower($product['store']);
            $productOfferLower = strtolower($product['offer'] ?? '');
            
            // Si hay tienda mencionada, priorizar productos de esa tienda
            if ($mentionedStore && stripos($product['store'], $mentionedStore) !== false) {
                $score += 100;
            }
            
            // Buscar coincidencias de palabras
            foreach ($expandedKeywords as $originalWord => $relatedWords) {
                foreach ($relatedWords as $keyword) {
                    // Búsqueda en nombre (más importante)
                    if (stripos($productNameLower, $keyword) !== false) {
                        $score += 50;
                    }
                    // Búsqueda en tienda
                    if (stripos($productStoreLower, $keyword) !== false) {
                        $score += 30;
                    }
                    // Búsqueda en oferta
                    if (stripos($productOfferLower, $keyword) !== false) {
                        $score += 10;
                    }
                }
            }
            
            // Solo incluir productos con puntuación > 0
            if ($score > 0) {
                $product['_search_score'] = $score;
                $scoredProducts[] = $product;
            }
        }
        
        // Ordenar por puntuación descendente
        usort($scoredProducts, function($a, $b) {
            return $b['_search_score'] <=> $a['_search_score'];
        });
        
        // Remover campo de puntuación
        foreach ($scoredProducts as &$product) {
            unset($product['_search_score']);
        }
        
        return $scoredProducts;
    }
    
    /**
     * Extrae el valor numérico del precio
     */
    private function extractPrice($price)
    {
        // Elimina caracteres no numéricos excepto el punto decimal
        $cleaned = preg_replace('/[^0-9.]/', '', $price);
        return floatval($cleaned) ?: 0;
    }
}
