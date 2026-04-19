<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías con conteo de productos y tiendas
        $categories = Category::all();
        
        $categoryStats = [];
        foreach ($categories as $category) {
            $products = $category->products();
            $categoryStats[$category->id] = [
                'products_count' => $products->count(),
                'stores_count' => $products->distinct('store')->count('store'),
            ];
        }
        
        return view('categories.index', [
            'categories' => $categories,
            'categoryStats' => $categoryStats,
            'availableStores' => Product::select('store')->distinct()->pluck('store')->filter()->values()->toArray(),
        ]);
    }

    public function showSubcategorias($id)
    {
        $category = Category::findOrFail($id);
        $subcategorias = $category->subcategorias()->get();
        
        // Calcular conteos de productos y tiendas por subcategoría
        $subcategoriaProductCounts = [];
        $subcategoriaStoreCounts = [];
        
        foreach ($subcategorias as $subcategoria) {
            $subcategoriaProductCounts[$subcategoria->id] = $subcategoria->productos()->count();
            $subcategoriaStoreCounts[$subcategoria->id] = $subcategoria->productos()->distinct('store')->count('store');
        }
        
        // Obtener productos de la categoría
        $products = $category->products()->paginate(14);
        
        return view('categories.subcategorias', [
            'category' => $category,
            'subcategorias' => $subcategorias,
            'subcategoriaProductCounts' => $subcategoriaProductCounts,
            'subcategoriaStoreCounts' => $subcategoriaStoreCounts,
            'products' => $products,
            'availableStores' => Product::select('store')->distinct()->pluck('store')->filter()->values()->toArray(),
        ]);
    }

    public function showSubcategoria($subcategoriaId)
    {
        $subcategoria = Subcategoria::findOrFail($subcategoriaId);
        $category = $subcategoria->categoria;
        
        // Obtener tiendas relacionadas a la subcategoría
        $relatedStores = $subcategoria->productos()
            ->select('store')
            ->distinct()
            ->get()
            ->map(function ($product) use ($subcategoria) {
                $storeProducts = $subcategoria->productos()->where('store', $product->store)->count();
                return [
                    'name' => $product->store,
                    'relatedProductsCount' => $storeProducts,
                    'status' => 'Abierto',
                ];
            })
            ->toArray();
        
        // Obtener productos de la subcategoría - 28 productos por página (4 filas de 7)
        $products = $subcategoria->productos()->paginate(28);
        
        return view('subcategorias.show', [
            'subcategoria' => $subcategoria,
            'category' => $category,
            'relatedStores' => $relatedStores,
            'products' => $products,
            'availableStores' => Product::select('store')->distinct()->pluck('store')->filter()->values()->toArray(),
        ]);
    }
}
