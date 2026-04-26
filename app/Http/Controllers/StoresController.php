<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function index()
    {
        // Obtener todas las tiendas con sus categorías
        $stores = Product::select('tienda')
            ->distinct()
            ->pluck('tienda')
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        // Obtener todas las categorías
        $categories = Category::with('products')->get();

        // Agrupar tiendas por categoría
        $storesByCategory = [];
        foreach ($categories as $category) {
            $categoryStores = $category->products()
                ->select('tienda')
                ->distinct()
                ->pluck('tienda')
                ->filter()
                ->sort()
                ->values()
                ->toArray();

            if (!empty($categoryStores)) {
                $storesByCategory[$category->id] = [
                    'category' => $category,
                    'stores' => $categoryStores,
                    'store_count' => count($categoryStores),
                    'product_count' => $category->products()->count(),
                ];
            }
        }

        return view('stores.index', [
            'storesByCategory' => $storesByCategory,
            'totalStores' => count($stores),
            'totalCategories' => count($storesByCategory),
        ]);
    }

    public function show($storeName)
    {
        // Obtener todos los productos de una tienda específica
        $products = Product::where('tienda', $storeName)
            ->with('category')
            ->paginate(28);

        // Obtener información de la tienda
        $storeData = [
            'name' => $storeName,
            'categories' => Product::where('tienda', $storeName)
                ->distinct('categoria_id')
                ->pluck('categoria_id')
                ->toArray(),
            'product_count' => Product::where('tienda', $storeName)->count(),
        ];

        return view('stores.show', [
            'store' => $storeData,
            'products' => $products,
        ]);
    }
}
