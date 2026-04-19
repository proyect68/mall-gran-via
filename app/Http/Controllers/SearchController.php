<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Busca productos, tiendas y servicios con búsqueda inteligente
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $page = $request->input('page', 1);
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $storeFilter = $request->input('storeFilter');
        $offerOnly = $request->input('offerOnly');
        
        $perPage = 28; // 4 filas × 7 columnas
        
        // Obtener todos los productos de la base de datos
        $allProducts = Product::all()->toArray();
        
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
        
        $relatedStores = [];
        if ($page == 1) { // Solo mostrar tiendas en la página 1
            $relatedStores = $storesByName->map(function ($storeProducts, $storeName) {
                return [
                    'name' => $storeName,
                    'image' => 'https://images.unsplash.com/photo-1555632238-c47966bcbe66?w=400&h=400&fit=crop&q=80',
                    'relatedProductsCount' => count($storeProducts),
                    'products' => $storeProducts->take(3)->toArray(),
                    'status' => 'Abierto',
                ];
            })->values()->all();
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
        ]);
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
        $availableStores = collect($products)->pluck('store')->unique()->toArray();
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
