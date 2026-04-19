@extends('layouts.app-authenticated')

@section('title', $subcategoria->nombre . ' - Mall Gran Vía')

@section('styles')
    <style>
        * { font-family: 'Montserrat', sans-serif !important; }
        
        .search-results-header { background: linear-gradient(135deg, #6f62f0 0%, #4c5eff 100%); color: white; padding: 40px 0; margin: 0; width: 100%; font-family: 'Montserrat', sans-serif; }
        .search-results-header h2 { font-weight: 700; margin-bottom: 5px; font-family: 'Montserrat', sans-serif; }
        .search-results-header p { opacity: 0.9; }
        
        .result-section { margin-bottom: 40px; }
        .result-section h3 { font-weight: 700; color: #3735af; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #cac9ff; display: inline-block; }
        section[style*="background: #6564bb"] .result-section h3 { color: #fff; border-bottom-color: rgba(255,255,255,0.2); }
        
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
        
        .related-stores-section { margin-bottom: 50px; }
        .related-stores-title { font-weight: 700; color: #3735af; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #cac9ff; display: inline-block; }
        .stores-wrapper { position: relative; margin-bottom: 15px; }
        .stores-scroll-btns { position: absolute; top: -50px; right: 0; display: flex; gap: 8px; z-index: 2; }
        .stores-scroll-btns button { width: 34px; height: 34px; border-radius: 50%; border: none; background: rgba(111,98,240,0.15); color: #3735af; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.2s ease; font-weight: 700; }
        .stores-scroll-btns button:hover { background: rgba(111,98,240,0.25); }
        .stores-carousel { display: flex; gap: 16px; overflow-x: hidden; scroll-behavior: smooth; padding-bottom: 10px; }
        .store-card { flex: 0 0 320px; height: 360px; background: #cac9ff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.25s ease, box-shadow 0.25s ease; display: flex; flex-direction: column; }
        .store-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
        .store-card-image { width: 100%; height: 200px; background: linear-gradient(135deg, #cac9ff 0%, #a8a7d6 100%); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; position: relative; overflow: hidden; flex-shrink: 0; }
        .store-card-image::before { content: '🏪'; font-size: 4rem; opacity: 0.3; }
        .store-card-body { padding: 18px 18px 24px 18px; flex: 1; display: flex; flex-direction: column; }
        .store-card-name { font-weight: 700; margin-bottom: 12px; font-size: 1.05rem; color: #3735af; }
        .store-card-info { font-size: 0.95rem; color: #3735af; margin-bottom: 12px; font-weight: 500; }
        .store-card-status { display: inline-flex; align-items: center; gap: 5px; font-size: 0.78rem; font-weight: 600; padding: 6px 12px; border-radius: 999px; background: #e8f5e9; color: #2e7d32; align-self: flex-start; }
        .store-card-status.closed { background: #ffebee; color: #c62828; }
        
        .pagination-container { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; margin-bottom: 40px; flex-wrap: wrap; }
        .pagination-btn { background: #3735af; color: #fff; border: 2px solid #3735af; border-radius: 4px; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
        .pagination-btn:hover { background: #2f2a9b; border-color: #2f2a9b; }
        .pagination-btn.active { background: #3735af; color: #fff; border-color: #3735af; }
        .pagination-btn.disabled { opacity: 0.5; cursor: not-allowed; background: #8a88c2; border-color: #8a88c2; }
        
        .breadcrumb-link { color: rgba(255,255,255,0.9); text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 12px; font-size: 0.95rem; }
        .breadcrumb-link:hover { text-decoration: underline; }
        
        .header-description { color: rgba(255,255,255,0.85); font-size: 0.95rem; margin-bottom: 20px; max-width: 600px; }
        
        .header-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
        .header-buttons .btn { background: rgba(255,255,255,0.2); color: #fff; border: 2px solid rgba(255,255,255,0.3); padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.25s ease; }
        .header-buttons .btn:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); border-color: rgba(255,255,255,0.5); color: #fff; }
    </style>
@endsection

@section('content')
    <main id="inicio" style="width: 100%; padding: 0; margin: 0;">
        <!-- Header con formato de categoría -->
        <section style="background: transparent; padding: 0;">
            <div class="container-fluid px-3 px-md-4 pt-4">
                <div style="background: #cac9ff; padding: 30px; border-radius: 18px; margin-bottom: 40px; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
                    <a href="{{ route('categories.subcategorias', $category->id) }}" style="color: #3735af; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 12px; font-size: 0.95rem;">← {{ $category->name }}</a>
                    <h1 style="font-weight:800; color:#3735af; margin-bottom:12px; font-size: 2.2rem;">{{ $subcategoria->nombre }}</h1>
                    @php
                        $isFoodCategory = $subcategoria->categoria && (stripos($subcategoria->categoria->name, 'comida') !== false || stripos($subcategoria->categoria->name, 'restaurante') !== false);
                        $isServiceCategory = $subcategoria->categoria && stripos($subcategoria->categoria->name, 'servicio') !== false;
                    @endphp
                    <p style="font-size: 1rem; color: #6c7190; line-height: 1.6; margin-bottom:0;">
                        @if($isFoodCategory)
                            Explora toda la comida disponible en esta subcategoría y descubre las mejores ofertas de nuestros restaurantes asociados.
                        @elseif($isServiceCategory)
                            Explora todos los servicios disponibles en esta subcategoría y descubre las mejores ofertas de nuestros proveedores asociados.
                        @else
                            Explora todos los productos disponibles en esta subcategoría y descubre las mejores ofertas de nuestras tiendas asociadas.
                        @endif
                    </p>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px;">
                        <a href="#tiendas-section" style="background: #3735af; color: #fff; border-radius: 999px; padding: 8px 20px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#2f2a9b'" onmouseout="this.style.background='#3735af'">Ver tiendas</a>
                        <a href="#productos-section" style="background: #3735af; color: #fff; border-radius: 999px; padding: 8px 20px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#2f2a9b'" onmouseout="this.style.background='#3735af'">
                            @if($isFoodCategory)
                                Ver comida
                            @elseif($isServiceCategory)
                                Ver servicios
                            @else
                                Ver productos
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Sección de Tiendas con fondo teal -->
        <div style="background: #09b7b1; padding-top: 20px; padding-bottom: 20px; width: 100%; margin: 0;">
            <div class="container-fluid px-3 px-md-4">
        @if (count($relatedStores) > 0)
            <div class="related-stores-section" style="margin-bottom: 0;" id="tiendas-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 class="related-stores-title mb-0" style="color:#fff;"><i class="bi bi-shop me-2"></i>Tiendas relacionadas con {{ $subcategoria->nombre }} ({{ count($relatedStores) }})</h3>
                </div>
                <div class="stores-wrapper">
                    @if (count($relatedStores) > 5)
                        <div class="stores-scroll-btns">
                            <button type="button" class="stores-scroll-btn" data-direction="prev">‹</button>
                            <button type="button" class="stores-scroll-btn" data-direction="next">›</button>
                        </div>
                    @endif
                    <div class="stores-carousel" id="storesCarousel">
                        @foreach ($relatedStores as $store)
                            <div class="store-card">
                                <div class="store-card-image"></div>
                                <div class="store-card-body">
                                    <div class="store-card-name">{{ $store['name'] }}</div>
                                    <div class="store-card-info">
                                        @php
                                            $isFoodCategory = $subcategoria->categoria && (stripos($subcategoria->categoria->name, 'comida') !== false || stripos($subcategoria->categoria->name, 'restaurante') !== false);
                                            $isServiceCategory = $subcategoria->categoria && stripos($subcategoria->categoria->name, 'servicio') !== false;
                                        @endphp
                                        @if($isFoodCategory)
                                            Comida disponible: {{ $store['relatedProductsCount'] }}
                                        @elseif($isServiceCategory)
                                            Servicios disponibles: {{ $store['relatedProductsCount'] }}
                                        @else
                                            Productos relacionados: {{ $store['relatedProductsCount'] }}
                                        @endif
                                    </div>
                                    <span class="store-card-status">
                                        <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i>{{ $store['status'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        @else
            <div class="related-stores-section" style="margin-bottom: 0;" id="tiendas-section">
                <h3 class="related-stores-title mb-3" style="color:#fff;"><i class="bi bi-shop me-2"></i>Tiendas relacionadas con {{ $subcategoria->nombre }} (0)</h3>
                <div style="background: rgba(7, 109, 106, 0.85); border-radius: 12px; padding: 40px; text-align: center; margin-bottom: 20px;">
                    <i class="bi bi-emoji-frown" style="font-size: 3rem; color: #fff; margin-bottom: 12px; display: block;"></i>
                    <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px;">No hay tiendas disponibles en esta categoría en este momento</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-light" style="color: #076d6a; font-weight: 600;">Volver atrás</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light" style="color: #fff; border-color: #fff; font-weight: 600;" onmouseover="this.style.color='#076d6a'; this.style.background='#fff';" onmouseout="this.style.color='#fff'; this.style.background='transparent';">Ir al dashboard</a>
                    </div>
                </div>
            </div>
        @endif
        </div>

        <!-- Sección de Productos con fondo púrpura -->
        <section style="background: #6564bb; padding-top: 30px; font-family: 'Montserrat', sans-serif; width: 100%; margin: 0;" id="productos-section">
            <div class="container-fluid px-3 px-md-4" style="font-family: 'Montserrat', sans-serif;">
        @if ($products->count() > 0)
            <div class="result-section" style="padding-bottom: 30px;">
                @php
                    $isFoodCategory = $subcategoria->categoria && (stripos($subcategoria->categoria->name, 'comida') !== false || stripos($subcategoria->categoria->name, 'restaurante') !== false);
                    $isServiceCategory = $subcategoria->categoria && stripos($subcategoria->categoria->name, 'servicio') !== false;
                @endphp
                <h3 style="color:#fff;"><i class="bi bi-box"></i> 
                    @if($isFoodCategory)
                        Comida relacionada a {{ $subcategoria->nombre }} ({{ $products->total() }})
                    @elseif($isServiceCategory)
                        Servicios relacionados a {{ $subcategoria->nombre }} ({{ $products->total() }})
                    @else
                        Productos relacionados con {{ $subcategoria->nombre }} ({{ $products->total() }})
                    @endif
                </h3>
                <div class="result-group">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <img src="{{ $product->image ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}">
                            <div class="product-card-body">
                                <div class="product-card-title">{{ $product->name }}</div>
                                <div class="product-card-store">{{ $product->store }}</div>
                                <div class="product-card-prices">
                                    @php
                                        $productPrice = $product->price;
                                        if (strpos($productPrice, 'Bs') === false && !is_numeric($productPrice)) {
                                            $productPrice = number_format((float)$productPrice, 0, ',', '.') . ' Bs';
                                        } elseif (is_numeric($productPrice)) {
                                            $productPrice = number_format((float)$productPrice, 0, ',', '.') . ' Bs';
                                        }
                                        $discountedPrice = null;
                                        if (!empty($product->offer) && (int)$product->offer > 0) {
                                            $discountPercent = (int)$product->offer;
                                            $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product->price);
                                            if ($currentPrice > 0) {
                                                $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                $discountedPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                            }
                                        }
                                    @endphp
                                    <strong>{{ $productPrice }}</strong>
                                    @if (!empty($discountedPrice))
                                        <del>{{ $discountedPrice }}</del>
                                    @elseif (!empty($product->old_price) && (float)$product->old_price > 0)
                                        <del>{{ number_format((float)$product->old_price, 0, ',', '.') }} Bs</del>
                                    @endif
                                </div>
                                @if (!empty($product->offer) && (int)$product->offer > 0)
                                    <span class="product-card-offer offer-red">{{ (int)$product->offer }}% OFF</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @php
                    $filterParams = '';
                @endphp
                <div class="pagination-container">
                    @php $currentPage = $products->currentPage(); @endphp
                    @if ($products->lastPage() > 1)
                        @if ($currentPage > 1)
                            <a href="{{ $products->url(1) }}" class="pagination-btn" title="Primera página">«</a>
                            <a href="{{ $products->previousPageUrl() }}" class="pagination-btn" title="Página anterior">‹</a>
                        @else
                            <span class="pagination-btn disabled">«</span>
                            <span class="pagination-btn disabled">‹</span>
                        @endif
                    @endif
                    
                    @for ($p = max(1, $currentPage - 2); $p <= min($products->lastPage(), $currentPage + 2); $p++)
                        @if ($p == $currentPage)
                            <span class="pagination-btn active">{{ $p }}</span>
                        @else
                            <a href="{{ $products->url($p) }}" class="pagination-btn">{{ $p }}</a>
                        @endif
                    @endfor
                    
                    @if ($products->lastPage() > 1)
                        @if ($currentPage < $products->lastPage())
                            <a href="{{ $products->nextPageUrl() }}" class="pagination-btn" title="Página siguiente">›</a>
                            <a href="{{ $products->url($products->lastPage()) }}" class="pagination-btn" title="Última página">»</a>
                        @else
                            <span class="pagination-btn disabled">›</span>
                            <span class="pagination-btn disabled">»</span>
                        @endif
                    @endif
                </div>
            </div>
        @else
            <div class="result-section" style="padding-bottom: 30px;">
                @php
                    $isFoodCategory = $subcategoria->categoria && (stripos($subcategoria->categoria->name, 'comida') !== false || stripos($subcategoria->categoria->name, 'restaurante') !== false);
                    $isServiceCategory = $subcategoria->categoria && stripos($subcategoria->categoria->name, 'servicio') !== false;
                @endphp
                <h3 style="color:#fff;"><i class="bi bi-box"></i> 
                    @if($isFoodCategory)
                        Comida relacionada a {{ $subcategoria->nombre }} (0)
                    @elseif($isServiceCategory)
                        Servicios relacionados a {{ $subcategoria->nombre }} (0)
                    @else
                        Productos relacionados con {{ $subcategoria->nombre }} (0)
                    @endif
                </h3>
                <div style="background: rgba(125, 92, 255, 0.8); border-radius: 12px; padding: 40px; text-align: center; margin-bottom: 20px;">
                    <i class="bi bi-emoji-frown" style="font-size: 3rem; color: #fff; margin-bottom: 12px; display: block;"></i>
                    <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px;">
                        @php
                            $isFoodCategory = $subcategoria->categoria && (stripos($subcategoria->categoria->name, 'comida') !== false || stripos($subcategoria->categoria->name, 'restaurante') !== false);
                            $isServiceCategory = $subcategoria->categoria && stripos($subcategoria->categoria->name, 'servicio') !== false;
                        @endphp
                        @if($isFoodCategory)
                            No hay comida disponible en esta subcategoría en este momento
                        @elseif($isServiceCategory)
                            No hay servicios disponibles en esta subcategoría en este momento
                        @else
                            No hay productos disponibles en esta subcategoría en este momento
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-light" style="color: #6564bb; font-weight: 600;">Volver atrás</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light" style="color: #fff; border-color: #fff; font-weight: 600;" onmouseover="this.style.color='#6564bb'; this.style.background='#fff';" onmouseout="this.style.color='#fff'; this.style.background='transparent';">Ir al dashboard</a>
                    </div>
                </div>
            </div>
        @endif
            </div>
        </section>
@endsection

@section('scripts')
    <script>
        // Scroll de carrusel de tiendas
        document.querySelectorAll('.stores-scroll-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const direction = this.getAttribute('data-direction');
                const carousel = document.getElementById('storesCarousel');
                const scrollAmount = 320 + 16; // card width + gap
                carousel.scrollBy({
                    left: direction === 'next' ? scrollAmount : -scrollAmount,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
