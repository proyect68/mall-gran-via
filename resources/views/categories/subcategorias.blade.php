@php
    use App\Models\Product;
    $availableStores = Product::select('tienda')->distinct()->pluck('tienda')->filter()->values()->toArray();
    $defaultPromoImage = 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=300&h=300&fit=crop&q=80';
@endphp

@extends('layouts.app-authenticated')

@section('title', $category->name . ' - Mall Gran Vía')

@section('styles')
    <style>
        .promo-card { background: #cac9ff; border-radius: 22px; overflow: hidden; padding: 18px; box-shadow: 0 20px 35px rgba(64,69,148,0.08); text-decoration: none; color: inherit; transition: transform 0.25s ease, box-shadow 0.25s ease; display: flex; flex-direction: column; height: 100%; }
        .promo-card:hover { transform: translateY(-8px); box-shadow: 0 30px 50px rgba(64,69,148,0.15); }
        .promo-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 16px; margin-bottom: 12px; }
        .category-title { font-weight: 700; font-size: 1.1rem; color: #3735af; margin-bottom: 8px; }
        .category-stats { display: flex; gap: 16px; margin-top: 12px; font-size: 0.9rem; color: #6c7190; }
        .stat-item { display: flex; align-items: center; gap: 4px; }
        .stat-item i { color: #3735af; }
        .categories-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        @media (max-width: 1400px) { .categories-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 1200px) { .categories-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .categories-grid { grid-template-columns: 1fr; } }
        .result-group { display: grid; grid-template-columns: repeat(7, 1fr); gap: 20px; }
        @media (max-width: 1400px) { .result-group { grid-template-columns: repeat(5, 1fr); } }
        @media (max-width: 1200px) { .result-group { grid-template-columns: repeat(4, 1fr); } }
        @media (max-width: 992px) { .result-group { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .result-group { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .result-group { grid-template-columns: 1fr; } }
        .product-card { background: #cac9ff; border-radius: 22px; overflow: hidden; padding: 0; box-shadow: 0 20px 35px rgba(64,69,148,0.08); transition: transform 0.25s ease; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-8px); }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card-body { padding: 18px; display: flex; flex-direction: column; height: 100%; }
        .product-card-title { font-weight: 700; margin-bottom: 8px; font-size: 1rem; color: #3735af; }
        .product-card-store { color: #3735af; font-size: 0.9rem; margin-bottom: 12px; }
        .product-card-prices { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .product-card-prices strong { font-size: 1.1rem; color: #3735af; font-weight: 700; }
        .product-card-prices del { color: #9ea0c4; font-size: 0.9rem; }
        .product-card-offer { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; align-self: flex-start; }
        .offer-red { background: #e9524c; }
        .offer-blue { background: #2b8fe0; }
        .offer-purple { background: #7d5cff; }
        .pagination-container { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; margin-bottom: 40px; flex-wrap: wrap; }
        .pagination-btn { background: #3735af; color: #fff; border: 2px solid #3735af; border-radius: 4px; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
        .pagination-btn:hover { background: #2f2a9b; border-color: #2f2a9b; }
        .pagination-btn.active { background: #3735af; color: #fff; border-color: #3735af; }
        .pagination-btn.disabled { opacity: 0.5; cursor: not-allowed; background: #8a88c2; border-color: #8a88c2; }
        .section-title { font-weight: 700; letter-spacing: 1px; margin-bottom: 12px; }
        .section-subtitle { color: #6c7190; margin-bottom: 24px; }
        .filter-field { margin-bottom: 22px; }
        .filter-field label { display: block; font-weight: 700; margin-bottom: 10px; }
        .filter-field input, .filter-field select { width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff; }
        .filter-field input::placeholder { color: #8f92b7; }
        .filter-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .filter-panel .btn-outline-secondary { color: #3735af; border-color: #3735af; background: transparent; }
        .filter-panel .btn-outline-secondary:hover, .filter-panel .btn-outline-secondary:focus { background: rgba(55,53,175,0.08); }
        .filter-panel .btn-primary { background: #3735af; border-color: #3735af; color: #ffffff; }
        .filter-panel .btn-primary:hover, .filter-panel .btn-primary:focus { background: #2f2a9b; border-color: #2f2a9b; }
        .filter-panel .form-check-input { width: 2.5em; height: 1.45em; background: #ff4d4d; border: 1px solid #ff4d4d; position: relative; }
        .filter-panel .form-check-input:checked { background: #28a745; border-color: #28a745; }
        .filter-panel .form-check-input:focus { box-shadow: 0 0 0 0.25rem rgba(55,53,175,0.18); }
        .filter-panel .form-check-input::before { content: "✗"; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: white; font-size: 0.8em; }
        .filter-panel .form-check-input:checked::before { content: "✓"; }
        .filter-panel .form-text { font-size: 0.85rem; }
        .filter-panel .text-danger { min-height: 18px; }
        .category-header { background: #cac9ff; padding: 30px; border-radius: 18px; margin-bottom: 40px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .category-header h1 { font-size: 2.2rem; font-weight: 800; color: #3735af; margin-bottom: 12px; }
        .category-header p { font-size: 1rem; color: #6c7190; line-height: 1.6; }
        .subcategoria-card { background: #44d6ce; border-radius: 22px; overflow: hidden; padding: 18px; box-shadow: 0 20px 35px rgba(64,69,148,0.08); text-decoration: none; color: inherit; transition: transform 0.25s ease, box-shadow 0.25s ease; display: flex; flex-direction: column; height: 100%; }
        .subcategoria-card:hover { transform: translateY(-8px); box-shadow: 0 30px 50px rgba(64,69,148,0.15); }
        .subcategoria-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 16px; margin-bottom: 12px; }
        .subcategoria-title { font-weight: 700; font-size: 1.1rem; color: #017470; margin-bottom: 8px; }
        .subcategoria-stats { display: flex; gap: 16px; margin-top: 12px; font-size: 0.9rem; color: #017470; }
        .subcategoria-stat-item { display: flex; align-items: center; gap: 4px; }
        .subcategoria-stat-item i { color: #017470; }
    </style>
@endsection

@section('content')
    <main class="container-fluid px-3 px-md-4 pt-4">
        <!-- Información de la categoría -->
        <section class="category-header">
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->description ?? 'Explora todas las subcategorías disponibles en esta categoría.' }}</p>
            <div class="d-flex gap-2 mt-3">
                <a href="#subcategorias-section" class="btn" style="background: #3735af; color: #fff; border-radius: 999px; padding: 8px 20px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#2f2a9b'" onmouseout="this.style.background='#3735af'">Ver subcategorías</a>
                @php
                    $isFoodCategory = stripos($category->name, 'comida') !== false || stripos($category->name, 'restaurante') !== false;
                    $isServiceCategory = stripos($category->name, 'servicio') !== false;
                @endphp
                <a href="#productos-section" class="btn" style="background: #3735af; color: #fff; border-radius: 999px; padding: 8px 20px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#2f2a9b'" onmouseout="this.style.background='#3735af'">
                    @if($isFoodCategory)
                        Ver comida
                    @elseif($isServiceCategory)
                        Ver servicios
                    @else
                        Ver productos
                    @endif
                </a>
            </div>
        </section>

        <!-- Sección de subcategorías -->
        <section class="mb-5" id="subcategorias-section">
            <div class="section-title" style="background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px;">Subcategorías</div>
            <div class="section-subtitle" style="color: #fff; margin-bottom: 24px;">Explora todas las subcategorías disponibles en {{ $category->name }}.</div>
            
            @if($subcategorias->count() > 0)
                <div class="categories-grid">
                    @foreach ($subcategorias as $subcategoria)
                        <a href="{{ route('subcategorias.show', $subcategoria->id) }}" class="subcategoria-card">
                            @if($subcategoria->imagen)
                                <img src="{{ $subcategoria->imagen }}" alt="{{ $subcategoria->nombre }}">
                            @else
                                <div style="width: 100%; height: 180px; background: #017470; border-radius: 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; color: #44d6ce;">
                                    <i class="bi bi-tag" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="subcategoria-title">{{ $subcategoria->nombre }}</div>
                            <div class="subcategoria-stats">
                                <div class="subcategoria-stat-item">
                                    <i class="bi bi-box"></i>
                                    @php
                                        $isFoodCategory = stripos($category->name, 'comida') !== false || stripos($category->name, 'restaurante') !== false;
                                        $isServiceCategory = stripos($category->name, 'servicio') !== false;
                                    @endphp
                                    <span>
                                        @if($isFoodCategory)
                                            {{ $subcategoriaProductCounts[$subcategoria->id] ?? 0 }} comida
                                        @elseif($isServiceCategory)
                                            {{ $subcategoriaProductCounts[$subcategoria->id] ?? 0 }} servicios
                                        @else
                                            {{ $subcategoriaProductCounts[$subcategoria->id] ?? 0 }} productos
                                        @endif
                                    </span>
                                </div>
                                <div class="subcategoria-stat-item">
                                    <i class="bi bi-shop"></i>
                                    <span>{{ $subcategoriaStoreCounts[$subcategoria->id] ?? 0 }} tiendas</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="background: #fff; padding: 40px; border-radius: 18px; text-align: center; color: #6c7190;">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #cac9ff; margin-bottom: 16px;"></i>
                    <p style="margin: 0;">No hay subcategorías disponibles en esta categoría en este momento.</p>
                </div>
            @endif

        <!-- Sección de Productos Relacionados -->
        <section id="productos-section" style="background: #6564bb; margin: 0; padding: 40px 0; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%);">
            <div class="container-fluid px-3 px-md-4">
                @php
                    $isFoodCategory = stripos($category->name, 'comida') !== false || stripos($category->name, 'restaurante') !== false;
                    $isServiceCategory = stripos($category->name, 'servicio') !== false;
                @endphp
                <div class="section-title" style="background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px; margin-bottom: 12px;">
                    @if($isFoodCategory)
                        Toda la comida disponible
                    @elseif($isServiceCategory)
                        Todos los servicios disponibles
                    @else
                        Productos relacionados
                    @endif
                </div>
                <div class="section-subtitle" style="color: rgba(255,255,255,0.9); margin-bottom: 24px;">
                    @if($isFoodCategory)
                        Descubre toda la comida de {{ $category->name }}.
                    @elseif($isServiceCategory)
                        Descubre todos los servicios de {{ $category->name }}.
                    @else
                        Descubre todos los productos de {{ $category->name }}.
                    @endif
                </div>
                
                @if($products->count() > 0)
                    <div class="result-group">
                        @php $defaultPromoImage = 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=300&h=300&fit=crop&q=80'; @endphp
                        @foreach ($products as $product)
                            <div class="product-card">
                                <img src="{{ $product->image ?? $defaultPromoImage }}" alt="{{ $product->name }}">
                                <div class="product-card-body">
                                    <div class="product-card-title">{{ $product->name }}</div>
                                    <div class="product-card-store">{{ $product->store }}</div>
                                    <div class="product-card-prices">
                                        @php
                                            $categoryProductPrice = $product->price;
                                            if (is_numeric($categoryProductPrice)) {
                                                $categoryProductPrice = $categoryProductPrice . ' Bs';
                                            }
                                            $categoryDiscountedPrice = null;
                                            if (!empty($product->offer) && is_numeric($product->offer)) {
                                                $discountPercent = (float)$product->offer;
                                                $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product->price);
                                                if ($currentPrice > 0 && $discountPercent > 0) {
                                                    $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                    $categoryDiscountedPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                                }
                                            }
                                        @endphp
                                        <strong>{{ $categoryProductPrice }}</strong>
                                        @if (!empty($categoryDiscountedPrice))
                                            <del>{{ $categoryDiscountedPrice }}</del>
                                        @elseif (!empty($product->old_price))
                                            <del>@php
                                                $categoryFallbackPrice = $product->old_price;
                                                if (strpos($categoryFallbackPrice, 'Bs') === false && is_numeric(str_replace(['.', ','], '', $categoryFallbackPrice))) {
                                                    $categoryFallbackPrice .= ' Bs';
                                                }
                                            @endphp {{ $categoryFallbackPrice }}</del>
                                        @endif
                                    </div>
                                    @if (!empty($product->offer))
                                        <span class="product-card-offer {{ $product->color ?? 'offer-red' }}">{{ $product->offer }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    @if ($products->lastPage() > 1)
                        <div class="pagination-container">
                            @if ($products->onFirstPage())
                                <span class="pagination-btn disabled">«</span>
                                <span class="pagination-btn disabled">‹</span>
                            @else
                                <a href="{{ $products->url(1) }}" class="pagination-btn" title="Primera página">«</a>
                                <a href="{{ $products->previousPageUrl() }}" class="pagination-btn" title="Página anterior">‹</a>
                            @endif
                            
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span class="pagination-btn active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                                @endif
                            @endforeach
                            
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="pagination-btn" title="Página siguiente">›</a>
                                <a href="{{ $products->url($products->lastPage()) }}" class="pagination-btn" title="Última página">»</a>
                            @else
                                <span class="pagination-btn disabled">›</span>
                                <span class="pagination-btn disabled">»</span>
                            @endif
                        </div>
                    @else
                        <div class="pagination-container">
                            <span class="pagination-btn active">1</span>
                        </div>
                    @endif
                @else
                    <div style="background: rgba(255,255,255,0.1); padding: 40px; border-radius: 18px; text-align: center; color: rgba(255,255,255,0.8);">
                        <i class="bi bi-box" style="font-size: 3rem; color: rgba(255,255,255,0.5); margin-bottom: 16px;"></i>
                        <p style="margin: 0;">
                            @php
                                $isFoodCategory = stripos($category->name, 'comida') !== false || stripos($category->name, 'restaurante') !== false;
                                $isServiceCategory = stripos($category->name, 'servicio') !== false;
                            @endphp
                            @if($isFoodCategory)
                                No hay comida disponible en esta categoría en este momento.
                            @elseif($isServiceCategory)
                                No hay servicios disponibles en esta categoría en este momento.
                            @else
                                No hay productos disponibles en esta categoría en este momento.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
