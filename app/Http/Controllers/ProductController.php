<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
public function index()
{
    $productos = Product::all();

    $availableStores = Product::select('tienda')
        ->distinct()
        ->pluck('tienda');

    $heroSlides = collect([
    (object)[
        'image' => asset('images/hero1.jpg'),
        'title' => 'Explora miles de productos',
        'text' => 'Encuentra ofertas exclusivas en todo el Mall Gran Vía'
    ],
    (object)[
        'image' => asset('images/hero2.jpg'),
        'title' => 'Ofertas del día',
        'text' => 'Descuentos especiales en tiendas seleccionadas'
    ],
    (object)[
        'image' => asset('images/hero3.jpg'),
        'title' => 'Servicios y promociones',
        'text' => 'Accede a servicios con promociones activas'
    ],
]);

    // 🔥 1. OFERTAS: solo productos con oferta REAL (limitado a 2 tiendas)
    $offers = Product::whereNotNull('oferta')
    ->where('oferta', '!=', '')
    ->get()
    ->groupBy('tienda')
    ->take(2)
    ->map(function ($items, $tienda) {
        return (object)[
            'store' => $tienda,
            'products' => $items->take(4)->map(function ($p) {
    return (object)[
        'name' => $p->nombre,
        'price_display' => $p->precio,
        'old_price_display' => $p->precio_anterior,
        'expires_display' => $p->expira ?? 'Sin fecha',
        'badge_display' => $p->oferta ?? '',
        'color_display' => $p->color ?? 'offer-purple',
        'image_display' => $p->imagen,
        'store' => $p->tienda,
    ];
})
        ];
    });

    // 🔥 2. PROMOS: SOLO SERVICIOS
    $promos = Product::whereNotNull('oferta')
    ->where('oferta', '!=', '')
    ->where('es_servicio', true)
    ->take(8)
    ->get();

    // 🔥 3. RECOMENDACIONES: solo productos normales (no servicios)
    $recommendations = Product::where('es_servicio', false)
        ->latest()
        ->take(12)
        ->get();

    return view('client', compact(
        'productos',
        'availableStores',
        'heroSlides',
        'offers',
        'promos',
        'recommendations'
    ));
}

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);

        $galleryImages = collect();

        if ($product->imagen) {
            $galleryImages->push((object)[
                'url' => $product->imagen,
                'title' => $product->nombre ?? 'Producto',
                'alt' => $product->nombre ?? 'Producto'
            ]);
        }

        if ($product->images) {
            foreach ($product->images as $img) {
                if ($img->url && $img->url !== $product->imagen) {
                    $galleryImages->push((object)[
                        'url' => $img->url,
                        'title' => $product->nombre ?? 'Producto',
                        'alt' => $product->nombre ?? 'Producto'
                    ]);
                }
            }
        }

        if ($galleryImages->isEmpty()) {
            $galleryImages->push((object)[
                'url' => 'https://via.placeholder.com/600',
                'title' => $product->nombre ?? 'Producto',
                'alt' => $product->nombre ?? 'Producto'
            ]);
        }

        $mainImage = $galleryImages->first();
        $variants = collect();

        return view('product.show', compact('product', 'galleryImages', 'mainImage', 'variants'));
    }
}