<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategoria;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
                'stores_count' => $products->distinct('tienda')->count('tienda'),
            ];
        }
        
        return view('categories.index', [
            'categories' => $categories,
            'categoryStats' => $categoryStats,
            'availableStores' => Product::select('tienda')->distinct()->pluck('tienda')->filter()->values()->toArray(),
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
            $subcategoriaStoreCounts[$subcategoria->id] = $subcategoria->productos()->distinct('tienda')->count('tienda');
        }
        
        // Obtener productos de la categoría
        $products = $category->products()->paginate(14);
        
        return view('categories.subcategorias', [
            'category' => $category,
            'subcategorias' => $subcategorias,
            'subcategoriaProductCounts' => $subcategoriaProductCounts,
            'subcategoriaStoreCounts' => $subcategoriaStoreCounts,
            'products' => $products,
            'availableStores' => Product::select('tienda')->distinct()->pluck('tienda')->filter()->values()->toArray(),
        ]);
    }

    public function showSubcategoria($subcategoriaId)
    {
        $subcategoria = Subcategoria::findOrFail($subcategoriaId);
        $category = $subcategoria->categoria;
        
        // Obtener tiendas relacionadas a la subcategoría
        $storeNames = $subcategoria->productos()
            ->select('tienda')
            ->distinct()
            ->get()
            ->pluck('store')
            ->filter();

        $relatedStores = Tienda::query()
            ->whereIn('nombre', $storeNames)
            ->orderBy('nombre')
            ->get();

        $relatedStores->each(function (Tienda $tienda) use ($subcategoria) {
            $productos = Product::query()
                ->where('subcategoria_id', $subcategoria->id)
                ->where(function ($query) use ($tienda) {
                    if (Schema::hasColumn('productos', 'tienda_id') && $tienda->getKey()) {
                        $query->where('tienda_id', $tienda->getKey());
                    }

                    $query->orWhere('tienda', $tienda->nombre);
                })
                ->with(['categoria', 'subcategoria'])
                ->get();

            $tienda->setRelation('productos', $productos);
            $tienda->setAttribute('related_products_count', $productos->count());
        });
        
        // Obtener productos de la subcategoría - 28 productos por página (4 filas de 7)
        $products = $subcategoria->productos()->paginate(28);
        
        return view('subcategorias.show', [
            'subcategoria' => $subcategoria,
            'category' => $category,
            'relatedStores' => $relatedStores,
            'products' => $products,
            'availableStores' => Product::select('tienda')->distinct()->pluck('tienda')->filter()->values()->toArray(),
        ]);
    }
}
