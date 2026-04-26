@extends('layouts.app-authenticated')

@section('title', 'SuperOfertas - Mall Gran Vía')

@section('styles')
    <style>
        html { scrollbar-gutter: stable; overflow-y: scroll; }
        html, body { width: 100%; }
        body { font-family: 'Montserrat', sans-serif; background: #09b7b1; color: #1f1f4e; padding: 0 !important; }
        main { width: 100%; }
        .app-header { background: #cac9ff; color: #fff; padding: 18px 0; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .app-header .menu-btn img { width: 30px; height: auto; }
        .app-header .search-box { background: #fff; border-radius: 999px; padding: 10px 18px; padding-right: 48px; border: none; width: 100%; font-size: 0.9rem; }
        .app-header .search-box:focus { outline: none; box-shadow: 0 0 0 3px rgba(111,98,240,0.18); }
        .search-submit-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent !important; border: none !important; padding: 8px !important; color: #3735af !important; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; }
        .app-header .user-chip { background: rgba(255,255,255,0.16); border-radius: 999px; padding: 8px 16px; display: inline-flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; }
        .app-header .user-chip img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.35); }

        .hero-carousel { max-width: 100%; margin-bottom: 0; }
        .hero-carousel .carousel-inner,
        .hero-carousel .carousel-item { height: 520px; border-radius: 24px; overflow: hidden; position: relative; }
        .hero-carousel .carousel-item img { object-fit: cover; width: 100%; height: 100%; filter: brightness(0.56); }
        .hero-carousel .carousel-caption { position: absolute; top: 52%; left: 6%; transform: translateY(-52%); max-width: 700px; text-align: left; padding-bottom: 20px; }
        .hero-carousel .carousel-caption h1 { font-size: clamp(2.2rem, 3vw, 3.4rem); line-height: 1.05; font-weight: 800; margin-bottom: 14px; }
        .hero-carousel .carousel-caption p { font-size: 1rem; margin-bottom: 18px; max-width: 420px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 56px; height: 56px; background: rgba(0,0,0,0.4); border-radius: 50%; top: auto; bottom: 18px; }

        .section-title { font-weight: 700; letter-spacing: 1px; margin-bottom: 12px; }
        .section-subtitle { color: #6c7190; margin-bottom: 24px; }

        /* Sección de ofertas */
        #tiendas-superofertas { background: #c15bbc; padding: 60px 0; margin: 0 -12px 60px -12px; }
        #tiendas-superofertas .section-title { font-size: 1.5rem; background: #fff; color: #c15bbc; display: inline-block; padding: 10px 24px; border-radius: 999px; margin-bottom: 20px; }
        #tiendas-superofertas .section-subtitle { color: #fff; }
        #tiendas-superofertas .container-fluid { padding-left: 20px; padding-right: 20px; }

        /* Sección de servicios */
        #servicios-superofertas { background: #4c5eff; padding: 40px 0; margin: 0 -12px 0 -12px; }
        #servicios-superofertas .section-title { font-size: 1.5rem; background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px; margin-bottom: 20px; }
        #servicios-superofertas .section-subtitle { color: #fff; }
        #servicios-superofertas .container-fluid { padding-left: 20px; padding-right: 20px; }

        /* Sección de comidas */
        #comidas-superofertas { background: #6564bb; padding: 60px 0; margin: 0 -12px 40px -12px; }
        #comidas-superofertas .section-title { font-size: 1.5rem; background: #fff; color: #6564bb; display: inline-block; padding: 10px 24px; border-radius: 999px; margin-bottom: 20px; }
        #comidas-superofertas .section-subtitle { color: #fff; }
        #comidas-superofertas .container-fluid { padding-left: 20px; padding-right: 20px; }

        /* Estilo de tarjeta de ofertas */
        .offer-card { border-radius: 24px; padding: 26px; height: 425px; display: flex; flex-direction: column; box-shadow: 0 20px 42px rgba(60,63,106,0.09); color: #1f1f4e; }
        
        #tiendas-superofertas .row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin: 0; width: 100%; }
        #tiendas-superofertas .col-lg-6 { padding: 0; }
        #tiendas-superofertas .col-12 { padding: 0; }
        .tiendas-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; margin: 0; width: 100%; }
        .tienda-card-wrapper { width: 100%; }
        @media (max-width: 1024px) {
            .tiendas-grid { grid-template-columns: 1fr; }
        }
        #comidas-superofertas .row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin: 0; width: 100%; }
        #comidas-superofertas .col-lg-6 { padding: 0; }
        #comidas-superofertas .col-12 { padding: 0; }
        
        .offer-card.color-1 { background: #6f62f0; color: #fff; }
        .offer-card.color-2 { background: #2b8fe0; color: #fff; }
        .offer-card.color-3 { background: #7d5cff; color: #fff; }
        .offer-card.color-4 { background: #ff6b35; color: #fff; }
        .offer-card.color-1 .store-title { color: #fff; }
        .offer-card.color-2 .store-title { color: #fff; }
        .offer-card.color-3 .store-title { color: #fff; }
        .offer-card.color-4 .store-title { color: #fff; }
        .offer-card.color-1 .product-promo { background: rgba(255,255,255,0.15); color: #fff; }
        .offer-card.color-2 .product-promo { background: rgba(255,255,255,0.15); color: #fff; }
        .offer-card.color-3 .product-promo { background: rgba(255,255,255,0.15); color: #fff; }
        .offer-card.color-4 .product-promo { background: rgba(255,255,255,0.15); color: #fff; }
        .offer-card.color-1 .product-promo .prices del,
        .offer-card.color-2 .product-promo .prices del,
        .offer-card.color-3 .product-promo .prices del,
        .offer-card.color-4 .product-promo .prices del { color: rgba(255,255,255,0.7); }
        .offer-card.color-1 .product-promo .expires,
        .offer-card.color-2 .product-promo .expires,
        .offer-card.color-3 .product-promo .expires,
        .offer-card.color-4 .product-promo .expires { color: rgba(255,255,255,0.8); }
        .offer-card .store-title { font-size: 1.35rem; font-weight: 700; margin-bottom: 24px; flex-shrink: 0; }
        .offer-products-wrapper { position: relative; flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .offer-scroll-btns { position: absolute; top: 14px; right: 14px; display: flex; gap: 8px; z-index: 2; }
        .offer-scroll-btns button { width: 34px; height: 34px; border-radius: 50%; border: none; background: rgba(255,255,255,0.92); color: #4c5eff; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .offer-carousel { display: flex; gap: 16px; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 8px; margin: 0 -18px 0 -18px; padding: 0 18px 8px 18px; flex: 1; scrollbar-width: thin; }
        .offer-carousel::-webkit-scrollbar { height: 8px; }
        .offer-carousel::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.32); border-radius: 10px; }
        .offer-item { flex: 0 0 280px; scroll-snap-align: start; min-width: 280px; }
        .offer-item .product-promo { min-height: 170px; }
        .product-promo { background: #f6f7ff; border-radius: 18px; padding: 18px; margin-bottom: 18px; color: #1f1f4e; transition: transform .25s ease, box-shadow .25s ease; }
        .product-promo img { width: 100%; height: 140px; object-fit: cover; border-radius: 16px; margin-bottom: 14px; }
        .product-promo:hover { transform: translateY(-4px); box-shadow: 0 16px 30px rgba(0,0,0,0.12); }
        .product-promo .product-name { font-weight: 700; margin-bottom: 8px; }
        .product-promo .prices { font-size: 0.95rem; display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap; }
        .product-promo .prices del { color: #9ea0c4; order: 1; }
        .product-promo .prices strong { order: 0; }
        .product-promo .expires { color: #7c7fa1; font-size: 0.88rem; margin-bottom: 10px; }
        .product-promo .badge-label { display: inline-flex; margin-top: 8px; }
.badge-label { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; }
        .offer-red { background: #e9524c; }
        .offer-blue { background: #2b8fe0; }
        .offer-purple { background: #7d5cff; }
        .offer-green { background: #28a745; }
        .offer-orange { background: #ff6b35; }

        /* Promo cards */
        .promo-card { border-radius: 24px; padding: 30px; min-height: 360px; position: relative; overflow: hidden; color: #1f1f4e; background: #cac9ff !important; transition: transform .25s ease, box-shadow .25s ease; }
        .promo-card:hover { transform: translateY(-6px); box-shadow: 0 18px 34px rgba(0,0,0,0.16); }
        .promo-card h3 { color: #1f1f4e; font-weight: 700; margin-bottom: 8px; }
        .promo-card .category { color: #6c7190; font-size: 0.9rem; margin-bottom: 8px; }
        .promo-card .promo-text { color: #4d4d7a; font-size: 0.9rem; margin-bottom: 10px; }
        .promo-card .prices { color: #1f1f4e; font-weight: 700; margin-bottom: 10px; }
        .promo-card .prices del { color: #9ea0c4; margin-left: 8px; }
        .promo-card .expires { color: #7c7f9c; font-size: 0.88rem; margin-bottom: 8px; }
        .promo-card .promo-badge { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; margin-top: 8px; }



        /* Footer */
        .app-footer { background: #1f1f4e; color: #fff; padding: 30px 0; text-align: center; font-size: 0.9rem; }
        .app-footer a { color: #cac9ff; text-decoration: none; }
        .app-footer a:hover { text-decoration: underline; }

        @media (max-width: 991px) {
            .carousel-nav-buttons { flex-direction: column; gap: 8px; }
            .carousel-nav-buttons button { padding: 10px 20px; font-size: 0.85rem; }
        }
        @media (max-width: 768px) {
            .hero-carousel .carousel-item { height: 380px; }
            .hero-carousel .carousel-caption { left: 20px; right: 20px; max-width: none; }
            .hero-carousel .carousel-caption h1 { font-size: 1.8rem; }
            .section-title { font-size: 1.2rem; }
            .offer-card { padding: 18px; }
            .promo-card { padding: 18px; min-height: auto; }
            .carousel-nav-buttons { bottom: 12px; }
            .carousel-nav-buttons button { padding: 8px 16px; font-size: 0.8rem; }
            #tiendas-superofertas .row { grid-template-columns: 1fr !important; }
            #comidas-superofertas .row { grid-template-columns: 1fr !important; }
        }
    </style>
@endsection

@section('content')
    <main class="container-fluid px-3 px-md-4 pt-4" style="padding-bottom: 40px;">
        <!-- Carrusel Principal -->
        <section class="hero-carousel mb-5" style="position: relative;">
            <div id="heroSlides" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($heroSlides as $index => $slide)
                        <button type="button" data-bs-target="#heroSlides" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($heroSlides as $index => $slide)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $slide['image'] }}" class="d-block w-100" alt="{{ $slide['title'] }}">
                            <div class="carousel-caption text-start">
                                <h1>{{ $slide['title'] }}</h1>
                                <p>{{ $slide['text'] }}</p>
                                <div class="d-flex flex-nowrap gap-2" style="flex-wrap: nowrap !important;">
                                    <a href="#tiendas-superofertas" class="btn btn-light btn-lg rounded-pill px-4">Ver Tiendas</a>
                                    <a href="#servicios-superofertas" class="btn btn-outline-light btn-lg rounded-pill px-4">Ver Servicios</a>
                                    <a href="#comidas-superofertas" class="btn btn-light btn-lg rounded-pill px-4">Ver Comidas</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroSlides" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroSlides" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Sección: Tiendas con SuperOfertas -->
        <section id="tiendas-superofertas">
            <div class="container-fluid">
                <h2 class="section-title">Tiendas con SuperOfertas</h2>
                <p class="section-subtitle">Descubre nuestras tiendas con las mejores promociones y descuentos.</p>
                
                @if (count($tiendas) > 0)
                    <div class="tiendas-grid">
                        @foreach ($tiendas as $index => $tienda)
                            <div class="tienda-card-wrapper">
                                <div class="offer-card color-{{ ($index % 4) + 1 }}">
                                    <div class="store-title">{{ $tienda['store'] }}</div>
                                    <div class="offer-products-wrapper">
                                        <div class="offer-scroll-btns">
                                            <button type="button" class="offer-scroll-btn" data-direction="prev">‹</button>
                                            <button type="button" class="offer-scroll-btn" data-direction="next">›</button>
                                        </div>
                                        <div class="offer-carousel" id="offer-carousel-tiendas-{{ $index }}">
                                            @foreach ($tienda['products'] as $product)
                                                @php
                                                    $productPrice = $product['price'];
                                                    if (is_numeric($productPrice)) {
                                                        $productPrice = $productPrice . ' Bs';
                                                    }
                                                    $discountedPrice = null;
                                                    if (!empty($product['offer']) && is_numeric($product['offer'])) {
                                                        $discountPercent = (float)$product['offer'];
                                                        $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product['price']);
                                                        if ($currentPrice > 0 && $discountPercent > 0) {
                                                            $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                            $discountedPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                                        }
                                                    }
                                                @endphp
                                                <div class="offer-item">
                                                    <div class="product-promo">
                                                        @php
                                                            $productImage = $product['image'] ?? 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=600&h=400&fit=crop&q=80';
                                                        @endphp
                                                        <img src="{{ $productImage }}" alt="{{ $product['name'] }}">
                                                        <div class="product-name">{{ $product['name'] }}</div>
                                                        <div class="prices">
                                                            <strong>{{ $productPrice }}</strong>
                                                            @if (!empty($discountedPrice))
                                                                <del>{{ $discountedPrice }}</del>
                                                            @elseif (!empty($product['old_price']))
                                                                <del>@php
                                                                    $fallbackPrice = $product['old_price'];
                                                                    if (strpos($fallbackPrice, 'Bs') === false && is_numeric(str_replace(['.', ','], '', $fallbackPrice))) {
                                                                        $fallbackPrice .= ' Bs';
                                                                    }
                                                                @endphp {{ $fallbackPrice }}</del>
                                                            @endif
                                                        </div>
                                                        <div class="expires">Vence: {{ $product['expires'] ?? '31/05/2026' }}</div>
                                                        @if (!empty($product['offer']))
                                                            <span class="badge-label {{ $product['color'] ?? 'offer-red' }}">{{ $product['offer'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">No hay tiendas con superofertas en este momento.</p>
                @endif
            </div>
        </section>

        <!-- Sección: Servicios con SuperOfertas -->
        <section id="servicios-superofertas">
            <div class="container-fluid">
                <h2 class="section-title">Servicios con SuperOfertas</h2>
                <p class="section-subtitle">Servicios especiales con promociones que no puedes perderte.</p>
                
                @if (count($servicios) > 0)
                    <div class="row g-4 promo-row">
                        @foreach ($servicios as $servicio)
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="promo-card">
                                    @php
                                        $servicioImage = $servicio['image'] ?? 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=400&fit=crop&q=80';
                                    @endphp
                                    <img src="{{ $servicioImage }}" alt="{{ $servicio['title'] }}" class="promo-image" style="width: 100%; height: 220px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;">
                                    <h3 style="margin-bottom: 8px; font-size: 1.1rem;">{{ $servicio['title'] }}</h3>
                                    <div class="category">{{ $servicio['category'] }}</div>
                                    <p class="promo-text">{{ substr($servicio['description'], 0, 60) }}{{ strlen($servicio['description']) > 60 ? '...' : '' }}</p>
                                    <div class="prices">
                                        @php
                                            $servicePrice = $servicio['price'];
                                            if (strpos($servicePrice, 'Bs') === false) {
                                                $servicePrice .= ' Bs';
                                            }
                                            $servicioDiscountedPrice = null;
                                            if (!empty($servicio['badge']) && strpos($servicio['badge'], '%') !== false) {
                                                $discountPercent = (int)str_replace('%', '', $servicio['badge']);
                                                $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $servicio['price']);
                                                if ($currentPrice > 0 && $discountPercent > 0) {
                                                    $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                    $servicioDiscountedPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                                }
                                            }
                                        @endphp
                                        <strong>{{ $servicePrice }}</strong>
                                        @if (!empty($servicioDiscountedPrice))
                                            <del>{{ $servicioDiscountedPrice }}</del>
                                        @elseif (!empty($servicio['old_price']))
                                            <del>{{ $servicio['old_price'] }}</del>
                                        @endif
                                    </div>
                                    @if (!empty($servicio['badge']))
                                        <span class="promo-badge {{ $servicio['color'] ?? 'offer-red' }}">{{ $servicio['badge'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-white text-center py-4">No hay servicios con superofertas en este momento.</p>
                @endif
            </div>
        </section>

        <!-- Sección: Comidas con SuperOfertas -->
        <section id="comidas-superofertas">
            <div class="container-fluid">
                <h2 class="section-title">Comidas con SuperOfertas</h2>
                <p class="section-subtitle">Las mejores comidas del mall con promociones especiales.</p>
                
                @if (count($comidas) > 0)
                    <div class="row g-4">
                        @foreach ($comidas as $index => $comida)
                            <div class="col-12 col-lg-6">
                                <div class="offer-card color-{{ ($index % 4) + 1 }}">
                                    <div class="store-title">{{ $comida['store'] }}</div>
                                    <div class="offer-products-wrapper">
                                        <div class="offer-scroll-btns">
                                            <button type="button" class="offer-scroll-btn" data-direction="prev">‹</button>
                                            <button type="button" class="offer-scroll-btn" data-direction="next">›</button>
                                        </div>
                                        <div class="offer-carousel" id="offer-carousel-comidas-{{ $index }}">
                                            @foreach ($comida['products'] as $product)
                                        @php
                                            $comidaPrice = $product['price'];
                                            if (is_numeric($comidaPrice)) {
                                                $comidaPrice = $comidaPrice . ' Bs';
                                            }
                                            $comidaDiscountedPrice = null;
                                            if (!empty($product['offer']) && is_numeric($product['offer'])) {
                                                $discountPercent = (float)$product['offer'];
                                                $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product['price']);
                                                if ($currentPrice > 0 && $discountPercent > 0) {
                                                    $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                    $comidaDiscountedPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                                }
                                            }
                                        @endphp
                                                <div class="offer-item">
                                                    <div class="product-promo">
                                                        @php
                                                            $comidaImage = $product['image'] ?? 'https://images.unsplash.com/photo-1495521821757-a1efb6729352?w=600&h=400&fit=crop&q=80';
                                                        @endphp
                                                        <img src="{{ $comidaImage }}" alt="{{ $product['name'] }}">
                                                        <div class="product-name">{{ $product['name'] }}</div>
                                                        <div class="prices">
                                                            <strong>{{ $comidaPrice }}</strong>
                                                            @if (!empty($comidaDiscountedPrice))
                                                                <del>{{ $comidaDiscountedPrice }}</del>
                                                            @elseif (!empty($product['old_price']))
                                                                <del>@php
                                                                    $comidaFallbackPrice = $product['old_price'];
                                                                    if (strpos($comidaFallbackPrice, 'Bs') === false && is_numeric(str_replace(['.', ','], '', $comidaFallbackPrice))) {
                                                                        $comidaFallbackPrice .= ' Bs';
                                                                    }
                                                                @endphp {{ $comidaFallbackPrice }}</del>
                                                            @endif
                                                        </div>
                                                        <div class="expires">Vence: {{ $product['expires'] ?? '31/05/2026' }}</div>
                                                        @if (!empty($product['offer']))
                                                            <span class="badge-label {{ $product['color'] ?? 'offer-red' }}">{{ $product['offer'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                    @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">No hay comidas con superofertas en este momento.</p>
                @endif
            </div>
        </section>
    </main>

@endsection

@section('scripts')

<script>
        // Interceptor para offcanvas
        const body = document.body;
        const offcanvasEl = document.getElementById('mainMenu');
        
        if (offcanvasEl) {
            offcanvasEl.addEventListener('show.bs.offcanvas', () => {
                body.classList.add('offcanvas-open');
            });
            offcanvasEl.addEventListener('hide.bs.offcanvas', () => {
                body.classList.remove('offcanvas-open');
            });
        }

        // Hacer que el carrusel avance al hacer clic en él
        const carouselElement = document.getElementById('heroSlides');
        if (carouselElement) {
            const carousel = new bootstrap.Carousel(carouselElement);
            carouselElement.addEventListener('click', (e) => {
                // Verificar que no sea un clic en los botones de control
                if (e.target.closest('.carousel-control-prev') || e.target.closest('.carousel-control-next') || e.target.closest('.carousel-indicators')) {
                    return;
                }
                carousel.next();
            });
        }

        // Manejo de botones de scroll para carrusel de ofertas
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.offer-scroll-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const direction = button.getAttribute('data-direction');
                    const carousel = button.closest('.offer-products-wrapper').querySelector('.offer-carousel');
                    const scrollAmount = carousel.clientWidth * 0.7;
                    carousel.scrollBy({ left: direction === 'next' ? scrollAmount : -scrollAmount, behavior: 'smooth' });
                });
            });
        });
    </script>
@endsection