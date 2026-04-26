@php
    use App\Models\Product;

    $heroSlides = [
        [
            'title' => 'Bienvenido al Mall Gran Vía',
            'text' => 'Descubre tiendas, promociones y servicios en un solo lugar. Desliza para encontrar lo que quieres.',
            'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=600&fit=crop&q=80'
        ],
        [
            'title' => 'Ofertas destacadas cada día',
            'text' => 'Las mejores promociones de tu mall están aquí: descuentos, 2x1, combos y productos imperdibles.',
            'image' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1200&h=600&fit=crop&q=80'
        ],
        [
            'title' => 'Recomendaciones personalizadas',
            'text' => 'Encuentra productos según tus búsquedas y lo más visitado en la plataforma.',
            'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&h=600&fit=crop&q=80'
        ],
    ];

    // Cargar todos los productos de la BD
    $allProducts = Product::all();

    // OFERTAS: Solo productos (NO servicios), agrupados por tienda
    $offers = [];
    $storeGrouped = [];
    foreach ($allProducts as $product) {
        // Solo incluir productos, NO servicios (es_servicio debe ser 0 o false)
        if ((int)$product->es_servicio === 1) continue;
        
        if (!isset($storeGrouped[$product->tienda])) {
            $storeGrouped[$product->tienda] = [];
        }
        $storeGrouped[$product->tienda][] = $product;
    }

    // Crear ofertas: Primera tienda genérica + ElectroMall como segunda
    $storeCount = 0;
    foreach ($storeGrouped as $storeName => $products) {
        if ($storeCount >= 1 && $storeName !== 'ElectroMall') continue; // Saltar otras tiendas hasta ElectroMall
        
        // Filtrar solo productos con oferta para ElectroMall
        if ($storeName === 'ElectroMall') {
            $productsWithOffer = array_filter($products, function($p) {
                return !empty($p->oferta);
            });
            if (empty($productsWithOffer)) continue; // Si ElectroMall no tiene ofertas, saltar
            $products = array_values($productsWithOffer);
        }
        
        $offers[] = [
            'store' => $storeName,
            'products' => array_slice($products, 0, 6),
        ];
        $storeCount++;
        if ($storeCount >= 2) break;
    }

    // PROMOS: Solo servicios (es_servicio=true) con ofertas, mínimo 4 servicios
    $promosRaw = $allProducts->filter(function($p) {
        // Solo servicios (es_servicio debe ser 1)
        if ((int)$p->es_servicio !== 1) return false;
        // Que tenga oferta
        if (empty($p->oferta)) return false;
        return true;
    });
    
    $promos = $promosRaw->take(4)->map(function($p) {
        return [
            'title' => $p->nombre,
            'category' => $p->tienda,
            'description' => 'Promoción especial: ' . ($p->oferta ?: 'Oferta disponible'),
            'price' => $p->precio,
            'old_price' => $p->precio_anterior ?? null,
            'badge' => $p->oferta ?? 'Oferta',
            'color' => $p->color ?? 'offer-red',
            'image' => $p->imagen ?? 'https://via.placeholder.com/400x300/cccccc/666666?text=Promo',
            'expires' => $p->expira ?? null,
        ];
    })->values()->toArray();

    // Recomendaciones (solo productos, NO servicios)
    $productsOnly = $allProducts->filter(function($p) {
        return !$p->es_servicio;
    });
    $recommendations = $productsOnly->take(14);

    $availableStores = $allProducts->pluck('tienda')->unique()->values();
@endphp


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mall Gran Vía</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        html { scrollbar-gutter: stable; overflow-y: scroll; }
        html, body { width: 100%; }
        body { font-family: 'Montserrat', sans-serif; background: #09b7b1; color: #1f1f4e; overflow-x: hidden; padding: 0 !important; overflow: hidden !important; }
        body.offcanvas-open { overflow: hidden !important; padding-right: 0 !important; }
        main { width: 100%; }
        .app-header { background: #cac9ff; color: #fff; padding: 18px 0; position: sticky; top: 0; z-index: 1030; }
        .app-header .menu-btn img { width: 30px; height: auto; }
        .app-header .search-box { background: #fff; border-radius: 999px; padding: 10px 18px; padding-right: 48px; border: none; width: 100%; }
        .app-header .search-box:focus { outline: none; box-shadow: 0 0 0 3px rgba(111,98,240,0.18); }
        .search-submit-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent !important; border: none !important; padding: 8px !important; color: #3735af !important; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; }
        .search-submit-btn:hover { color: #2f2a9b !important; }
        .app-header .user-chip { background: rgba(255,255,255,0.16); border-radius: 999px; padding: 8px 16px; display: inline-flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; }
        .app-header .user-chip img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.35); }
        .hero-carousel { max-width: 100%; }
        .hero-carousel .carousel-inner,
        .hero-carousel .carousel-item { height: 520px; max-height: 520px; border-radius: 24px; overflow: hidden; position: relative; }
        .hero-carousel .carousel-item img { object-fit: cover; width: 100%; height: 100%; filter: brightness(0.56); }
        .hero-carousel .carousel-caption { position: absolute; top: 52%; left: 6%; transform: translateY(-52%); max-width: 520px; text-align: left; padding-bottom: 20px; }
        .hero-carousel .carousel-caption h1 { font-size: clamp(2.2rem, 3vw, 3.4rem); line-height: 1.05; font-weight: 800; margin-bottom: 14px; }
        .hero-carousel .carousel-caption p { font-size: 1rem; margin-bottom: 18px; max-width: 420px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 56px; height: 56px; background: rgba(0,0,0,0.5); border-radius: 50%; top: auto; bottom: 22px; }
        .hero-carousel .carousel-caption .d-flex { margin-top: 10px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 56px; height: 56px; background: rgba(0,0,0,0.4); border-radius: 50%; top: auto; bottom: 18px; }

        .hero-carousel .carousel-indicators [data-bs-target] { background-color: rgba(255,255,255,0.9); }
        .section-title { font-weight: 700; letter-spacing: 1px; margin-bottom: 12px; }
        .section-subtitle { color: #6c7190; margin-bottom: 24px; }
        #ofertas .section-title { background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px; margin-bottom: 20px; }
        #ofertas .section-subtitle { color: #fff; }
        #ofertas { background: #4c5eff; padding: 40px 0; margin: 0 -12px 0 -12px; }
        #promos { background: #4c5eff; padding: 40px 0; margin: 0 -12px 40px -12px; }
        #ofertas .container-fluid { padding-left: 20px; padding-right: 20px; }
        #promos .container-fluid { padding-left: 20px; padding-right: 20px; }
        .promo-card { border-radius: 24px; padding: 30px; min-height: 360px; position: relative; overflow: hidden; color: #1f1f4e; background: #cac9ff !important; transition: transform .25s ease, box-shadow .25s ease; }
        .promo-card:hover { transform: translateY(-6px); box-shadow: 0 18px 34px rgba(0,0,0,0.16); }
        .promo-card .promo-badge { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; margin-top: 8px; }
        .promo-card h3 { color: #1f1f4e; }
        .promo-card .category { color: #6c7190; font-size: 0.9rem; }
        .promo-card .promo-text { color: #4d4d7a; }
        .promo-card .prices { color: #1f1f4e; font-weight: 700; margin-bottom: 10px; }
        .promo-card .expires { color: #7c7f9c; font-size: 0.88rem; }
        #promos .section-title { background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px; margin-bottom: 20px; }
        #promos .section-subtitle { color: #fff; }
        .offer-card { border-radius: 24px; padding: 26px; min-height: 425px; box-shadow: 0 20px 42px rgba(60,63,106,0.09); color: #1f1f4e; }
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
        .offer-card .store-title { font-size: 1.35rem; font-weight: 700; margin-bottom: 24px; }
        .offer-products-wrapper { position: relative; }
        .offer-scroll-btns { position: absolute; top: 14px; right: 14px; display: flex; gap: 8px; z-index: 2; }
        .offer-scroll-btns button { width: 34px; height: 34px; border-radius: 50%; border: none; background: rgba(255,255,255,0.92); color: #4c5eff; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .offer-carousel { display: flex; gap: 16px; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 8px; margin: 0 -18px 0 -18px; padding: 0 18px 8px 18px; }
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
        .promo-row { gap: 24px; margin-bottom: 30px; }
        .promo-card { border-radius: 24px; padding: 30px; min-height: 360px; position: relative; overflow: hidden; color: #fff; }
        .promo-card.service { background: linear-gradient(135deg, #7d5cff, #4f3bcb); }
        .promo-card.food { background: linear-gradient(135deg, #2d90e2, #1a58c2); }
        .promo-card.tech { background: linear-gradient(135deg, #ff6b35, #e55a2b); }
        .promo-card.fashion { background: linear-gradient(135deg, #ff4081, #e91e63); }
        .promo-card .promo-image { width: 100%; height: 150px; object-fit: cover; border-radius: 12px; margin-bottom: 16px; }
        .recommendation-section { background: #6564bb; padding: 60px 0; }
        .recommendation-card { background: #cac9ff; border-radius: 18px; padding: 18px; color: #1f1f4e; box-shadow: 0 4px 12px rgba(0,0,0,0.1); height: 100%; }
        .recommendation-card:hover { transform: translateY(-8px); }
        .recommendation-card img { object-fit: cover !important; height: 190px !important; background: #fff; border-radius: 12px; padding: 8px; }
        .recommendation-group { display: flex; flex-wrap: wrap; gap: 18px; margin-bottom: 24px; }
        .recommendation-item { flex: 0 0 calc((100% - 108px) / 7); max-width: calc((100% - 108px) / 7); }
        @media (max-width: 1600px) { .recommendation-item { flex: 0 0 calc((100% - 90px) / 6); max-width: calc((100% - 90px) / 6); } }
        @media (max-width: 1400px) { .recommendation-item { flex: 0 0 calc((100% - 72px) / 5); max-width: calc((100% - 72px) / 5); } }
        @media (max-width: 1200px) { .recommendation-item { flex: 0 0 calc((100% - 60px) / 4); max-width: calc((100% - 60px) / 4); } }
        @media (max-width: 992px) { .recommendation-item { flex: 0 0 calc((100% - 48px) / 3); max-width: calc((100% - 48px) / 3); } }
        @media (max-width: 768px) { .recommendation-item { flex: 0 0 calc((100% - 32px) / 2); max-width: calc((100% - 32px) / 2); } }
        @media (max-width: 576px) { .recommendation-item { flex: 0 0 100%; max-width: 100%; } }
        .recommendation-card .title { font-weight: 700; margin-bottom: 10px; }
        .recommendation-card .store-name { color: #7c7f9c; margin-bottom: 12px; font-size: 0.9rem; }
        .recommendation-card .price { font-size: 1.15rem; font-weight: 700; margin-bottom: 14px; color: #1f1f4e; }
        .recommendation-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; }
        .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 18px; }
        .footer-app a { color: #d2d4ff; text-decoration: none; }
        .footer-app a:hover { color: #fff; }
        .filter-panel { width: 340px; padding: 24px; background: #cac9ff; color: #3735af; }
        .filter-panel .offcanvas-header { background: #cac9ff; color: #3735af; border-bottom: 1px solid rgba(55,53,175,0.2); }
        .filter-panel .offcanvas-body { background: #cac9ff; }
        .offcanvas.filter-offcanvas { width: 340px !important; }
        .offcanvas.filter-offcanvas .offcanvas-header { background: #cac9ff; border-bottom: 1px solid rgba(55,53,175,0.2); color: #3735af; }
        .offcanvas.filter-offcanvas .offcanvas-header .offcanvas-title { color: #3735af; font-weight: 700; }
        .offcanvas.filter-offcanvas .btn-close { color: #3735af; opacity: 0.7; }
        .offcanvas.filter-offcanvas .offcanvas-body { background: #cac9ff; padding: 24px; }
        .offcanvas.menu-offcanvas .offcanvas-header { background: #cac9ff; border-bottom: 1px solid rgba(55,53,175,0.2); color: #3735af; }
        .offcanvas.menu-offcanvas .offcanvas-header .offcanvas-title { color: #3735af; font-weight: 700; }
        .offcanvas.menu-offcanvas .btn-close { color: #3735af; opacity: 0.7; }
        .offcanvas.menu-offcanvas .offcanvas-body { background: #cac9ff; color: #3735af; }
        .offcanvas.menu-offcanvas .offcanvas-body ul li a { color: #3735af; text-decoration: none; }
        .offcanvas.menu-offcanvas .offcanvas-body ul li a i { opacity: 0.7; }
        .filter-panel .form-label.fw-bold { font-weight: 700 !important; }
        .filter-field { margin-bottom: 22px; }
        .filter-field label { display: block; font-weight: 700; margin-bottom: 10px; }
        .filter-field input, .filter-field select { width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff; }
        .filter-field input::placeholder { color: #8f92b7; }
        .filter-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .filter-panel .btn-outline-secondary { color: #3735af; border-color: #3735af; background: transparent; }
        .filter-panel .btn-outlinesecondary:hover, .filter-panel .btn-outline-secondary:focus { background: rgba(55,53,175,0.08); }
        .filter-panel .btn-primary { background: #3735af; border-color: #3735af; color: #ffffff; }
        .filter-panel .btn-primary:hover, .filter-panel .btn-primary:focus { background: #2f2a9b; border-color: #2f2a9b; }
        .filter-panel .form-check-input { width: 2.5em; height: 1.45em; background: #ff4d4d; border: 1px solid #ff4d4d; position: relative; }
        .filter-panel .form-check-input:checked { background: #28a745; border-color: #28a745; }
        .filter-panel .form-check-input:focus { box-shadow: 0 0 0 0.25rem rgba(55,53,175,0.18); }
        .filter-panel .form-check-input::before { content: "✗"; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: white; font-size: 0.8em; }
        .filter-panel .form-check-input:checked::before { content: "✓"; }
        .filter-panel .form-text { font-size: 0.85rem; }
        .filter-panel .text-danger { min-height: 18px; }
        .carousel-controls { margin-top: 22px; display: flex; justify-content: center; gap: 14px; }
        .filter-success-message { position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 14px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-weight: 600; z-index: 9999; animation: slideDown 0.3s ease-out, slideUp 0.3s ease-out 2.7s; }
        @keyframes slideDown { from { transform: translateX(-50%) translateY(-20px); opacity: 0; } to { transform: translateX(-50%) translateY(0); opacity: 1; } }
        @keyframes slideUp { from { transform: translateX(-50%) translateY(0); opacity: 1; } to { transform: translateX(-50%) translateY(-20px); opacity: 0; } }
        @media (max-width: 991px) {
            .hero-carousel .carousel-caption { left: 20px; right: 20px; max-width: none; }
            .promo-row { flex-direction: column; }
        }
    </style>
</head>
<body>
    @include('components.app-header')
    <!--
    <header class="app-header shadow-sm">
        <div class="container-fluid px-3 px-md-4">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn p-0 menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                        <img src="{{ asset('images/menu.png') }}" alt="Menú" />
                    </button>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Mall Gran Vía" width="44" />
                        <div>
                            <div style="font-weight:700; font-size:1rem;">Mall Gran Vía</div>
                            <small style="color: rgba(255,255,255,.85);">Centro comercial digital</small>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <form id="mainSearchForm" action="{{ route('search') }}" method="GET" class="d-flex align-items-center gap-2">
                        <div style="position: relative; flex-grow: 1;">
                            <input type="text" name="q" class="search-box" placeholder="Buscar productos, tiendas o servicios..." aria-label="Buscar" />
                            <-- Hidden inputs para mantener filtros al hacer nueva búsqueda ---
                            <input type="hidden" id="hiddenPriceMin" name="priceMin" />
                            <input type="hidden" id="hiddenPriceMax" name="priceMax" />
                            <input type="hidden" id="hiddenStoreFilter" name="storeFilter" />
                            <input type="hidden" id="hiddenOfferOnly" name="offerOnly" />
                            <button type="submit" class="search-submit-btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <button type="button" class="btn btn-white border rounded-circle p-2" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas" title="Filtros de búsqueda">
                            <img src="{{ asset('images/filtros.png') }}" alt="Filtros" width="24" />
                        </button>
                    </form>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link user-chip dropdown-toggle" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; cursor: pointer; background: transparent;">
                        <img src="{{ asset('images/sinfoto.png') }}" alt="Perfil" />
                        <div class="text-start">
                            <div style="font-size:.95rem;">¡Bienvenido!</div>
                            <div style="font-size:.85rem; opacity:.85;">@auth {{ Auth::user()->name }} @else Invitado @endauth</div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn" style="background: #cac9ff; border: 1px solid rgba(55,53,175,0.2); border-radius: 16px; min-width: 200px;">
                        @auth
                            <li>
                                <a class="dropdown-item" href="#" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                    <i class="bi bi-person-circle" style="margin-right: 10px;"></i> Mi Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" style="margin: 6px 0; border-color: rgba(55,53,175,0.2);"></li>
                            <li>
                                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color: #d32f2f; padding: 12px 16px; border-radius: 12px; margin: 6px; width: 100%; text-align: left; border: none; background: transparent; cursor: pointer;">
                                        <i class="bi bi-box-arrow-right" style="margin-right: 10px;"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                    <i class="bi bi-box-arrow-in-right" style="margin-right: 10px;"></i> Iniciar Sesión
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                    <i class="bi bi-person-plus" style="margin-right: 10px;"></i> Registrarse
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </header>
-->
    <div class="offcanvas offcanvas-start menu-offcanvas" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menú</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">                
                <li><a href="{{ route('profile.show') }}" class="d-block py-2"><img src="{{ asset('images/perfil_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Mi perfil</a></li>
                <li><a href="{{ route('categories.index') }}" class="d-block py-2"><img src="{{ asset('images/categoria_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Todas las categorías</a></li>
                <li><a href="{{ route('superofertas.index') }}" class="d-block py-2"><img src="{{ asset('images/superofertas_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">SuperOfertas</a></li>
                <li><a href="{{ route('stores.index') }}" class="d-block py-2"><img src="{{ asset('images/tienda_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Ver tiendas</a></li>
                <li><a href="{{ route('search', ['q' => '']) }}" class="d-block py-2"><img src="{{ asset('images/busqueda_inteligente_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Búsqueda inteligente</a></li>
                <li><a href="{{ route('wishlist.index') }}" class="d-block py-2"><img src="{{ asset('images/listadeseos_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Lista de deseos</a></li>
                <li><a href="{{ route('history.index') }}" class="d-block py-2"><img src="{{ asset('images/historial_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Historial</a></li>
                <li><a href="{{ route('notifications.index') }}" class="d-block py-2"><img src="{{ asset('images/notificacion_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Notificaciones</a></li>
            </ul>
        </div>
    </div>

    <div class="offcanvas offcanvas-end filter-offcanvas" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filtros de búsqueda</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body filter-panel">
            <form id="searchFilterForm" novalidate>
                <div id="filterError" class="text-danger small mb-3"></div>
                <div class="filter-field">
                    <label for="priceMin">Precio mínimo</label>
                    <input type="number" id="priceMin" placeholder="Desde" class="form-control" min="0" max="999999" maxlength="7" />
                </div>
                <div class="filter-field">
                    <label for="priceMax">Precio máximo</label>
                    <input type="number" id="priceMax" placeholder="Hasta" class="form-control" min="0" max="999999" maxlength="7" />
                </div>
                <div class="filter-field">
                    <label for="storeFilter">Tienda específica</label>
                    <input type="text" id="storeFilter" list="storesList" placeholder="Ej: Moda Express" class="form-control" autocomplete="off" />
                    <datalist id="storesList">
                        @foreach ($availableStores as $storeName)
                            <option value="{{ $storeName }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="filter-field">
                    <label class="form-label fw-bold mb-3">Mostrar solo resultados con ofertas</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="offerOnly">
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="button" id="clearFiltersBtn" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Descartar</button>
                    <button type="button" id="applyFiltersBtn" class="btn btn-primary">Aplicar</button>
                </div>
            </form>
        </div>
    </div>

    <main class="container-fluid px-3 px-md-4 pt-4" id="inicio">
        <section class="hero-carousel mb-5">
            <div id="heroSlides" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6500" data-bs-pause="hover">
                <div class="carousel-indicators">
                    @foreach ($heroSlides as $index => $slide)
                        <button type="button" data-bs-target="#heroSlides" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner rounded-4 overflow-hidden shadow-lg">
                    @foreach ($heroSlides as $index => $slide)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $slide['image'] }}" class="d-block w-100" alt="{{ $slide['title'] }}">
                            <div class="carousel-caption text-start">
                                <h1>{{ $slide['title'] }}</h1>
                                <p>{{ $slide['text'] }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#ofertas" class="btn btn-light btn-lg rounded-pill px-4">Ver ofertas</a>
                                    <a href="#recomendaciones" class="btn btn-outline-light btn-lg rounded-pill px-4">Ver recomendaciones</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroSlides" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroSlides" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </section>

            @guest
            <div class="alert alert-info alert-dismissible fade show mt-4" role="alert" style="background: #6f62f0; border: none; color: white;">
                <div class="text-center">
                    <h5 class="alert-heading mb-3">¿Listo para explorar?</h5>
                    <p class="mb-3">Inicia sesión o crea una cuenta para acceder a todas nuestras ofertas y productos.</p>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">Registrarse</a>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endguest
        </section>

        <section id="ofertas">
            <div class="container-fluid px-4">
                <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
                    <div>
                        <div class="section-title">Ofertas del día</div>
                        <div class="section-subtitle">Las tiendas con mejores estadísticas y sus productos más atractivos.</div>
                    </div>
                    <div class="text-md-end">
                        <span class="badge bg-white text-primary rounded-pill px-3 py-2">Mejores visitas y reseñas</span>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($offers as $index => $offer)
                        <div class="col-12 col-lg-6">
                            <div class="offer-card color-{{ ($index % 4) + 1 }}">
                                <div class="store-title">{{ $offer['store'] }}</div>
                                <div class="offer-products-wrapper">
                                    <div class="offer-scroll-btns">
                                        <button type="button" class="offer-scroll-btn" data-direction="prev">‹</button>
                                        <button type="button" class="offer-scroll-btn" data-direction="next">›</button>
                                    </div>
                                    <div class="offer-carousel" id="offer-carousel-{{ $index }}">
                                        @foreach ($offer['products'] as $product)
                                            @php
                                                $productImage = $product->imagen ?? 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=600&h=400&fit=crop&q=80';
                                                
                                                // Calcular old_price si no existe pero hay descuento porcentual
                                                $oldPrice = $product->precio_anterior;
                                                if (empty($oldPrice) && strpos($product->oferta ?? '', '%') !== false) {
                                                    $discountPercent = (int)str_replace('%', '', $product->oferta);
                                                    $currentPrice = (float)str_replace([' BS', '.', ','], '', $product->precio);
                                                    $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                    $oldPrice = number_format($originalPrice, 0, '', '.') . ' BS';
                                                }
                                            @endphp
                                            <div class="offer-item">
                                                <a href="{{ route('products.show', $product->id) }}" style="text-decoration:none; color:inherit;">
                                                <div class="product-promo">
                                                    <img src="{{ $productImage }}" alt="{{ $product->nombre }}">
                                                    <div class="product-name">{{ $product->nombre }}</div>
                                                    <div class="prices">
                                                        @php
                                                            $priceDisplay = $product->precio;
                                                            if (strpos($priceDisplay, 'Bs') === false) {
                                                                $priceDisplay .= ' Bs';
                                                            }
                                                            $discountedOldPrice = null;
                                                            if (!empty($product->oferta) && strpos($product->oferta, '%') !== false) {
                                                                $discountPercent = (int)str_replace('%', '', $product->oferta);
                                                                $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product->precio);
                                                                if ($currentPrice > 0 && $discountPercent > 0) {
                                                                    $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                                    $discountedOldPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                                                }
                                                            }
                                                            $oldPrice = null;
                                                            if (!empty($product->precio_anterior)) {
                                                                $oldPrice = $product->precio_anterior;
                                                                if (strpos($oldPrice, 'Bs') === false && is_numeric(str_replace(['.', ','], '', $oldPrice))) {
                                                                    $oldPrice .= ' Bs';
                                                                }
                                                            }
                                                        @endphp
                                                        <strong>{{ $priceDisplay }}</strong>
                                                        @if (!empty($discountedOldPrice))
                                                            <del>{{ $discountedOldPrice }}</del>
                                                        @elseif (!empty($oldPrice))
                                                            <del>{{ $oldPrice }}</del>
                                                        @endif
                                                    </div>
                                                    <div class="expires">Vence: {{ $product->expira ?? '31/04/2026' }}</div>
                                                    <span class="badge-label {{ $product->color ?? 'offer-red' }}">{{ $product->oferta ?? '-' }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="promos">
            <div class="container-fluid px-4">
                <div class="section-title">Promos del día</div>
                <div class="section-subtitle">Promociones destacadas con servicios y combos de comida.</div>
                <div class="row g-4">
                    @foreach ($promos as $promo)
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="promo-card">
                                <img src="{{ $promo['image'] }}" alt="{{ $promo['title'] }}" class="promo-image" style="width: 100%; height: 220px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;">
                                <h3 style="margin-bottom: 8px; font-size: 1.1rem;">{{ $promo['title'] }}</h3>
                                <div class="category" style="margin-bottom: 8px;">{{ $promo['category'] }}</div>
                                <p class="promo-text" style="margin-bottom: 10px; font-size: 0.9rem;">{{ $promo['description'] }}</p>
                                <div class="prices" style="margin-bottom: 10px; font-weight: 700; color: #1f1f4e;">
                                    @php
                                        $promoPrice = $promo['price'];
                                        if (strpos($promoPrice, 'Bs') === false) {
                                            $promoPrice .= ' Bs';
                                        }
                                        $promoOldPrice = $promo['old_price'] ?? null;
                                        if (empty($promoOldPrice) && !empty($promo['badge']) && strpos($promo['badge'], '%') !== false) {
                                            $discountPercent = (int)str_replace('%', '', $promo['badge']);
                                            $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $promo['price']);
                                            if ($currentPrice > 0 && $discountPercent > 0) {
                                                $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                $promoOldPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                            }
                                        }
                                    @endphp
                                    Precio: {{ $promoPrice }}
                                    @if (!empty($promoOldPrice))
                                        <del style="color: #9ea0c4; margin-left: 8px;">{{ $promoOldPrice }}</del>
                                    @endif
                                </div>
                                <div class="expires">Vence: {{ $promo['expires'] }}</div>
                                <div class="promo-badge {{ $promo['color'] }}" style="margin-top: 8px;">{{ $promo['badge'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-lg rounded-pill px-5" style="background: #3735af; color: #FFFFFF;">Ver súper ofertas</a>
                </div>
            </div>
        </section>

        <section id="recomendaciones" class="recommendation-section mb-5">
            <div class="container-fluid px-4">
                <div class="section-title" style="background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px;">Productos que pueden interesarte</div>
                <div class="section-subtitle" style="color: #fff; margin-bottom: 24px;">Basado en búsquedas populares y lo más visto del mall.</div>
                <div class="recommendation-group mb-4">
                    @foreach ($recommendations as $item)
                        <div class="recommendation-item">
                            <article class="recommendation-card">
                                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-100 rounded mb-3">
                                <div class="title" style="font-size: 0.95rem;">{{ $item->nombre }}</div>
                                <div class="store-name">{{ $item->tienda }}</div>
                                <div class="price" style="margin-bottom: 10px;">
                                    @php
                                        $clientItemPrice = $item->precio;
                                        if (strpos($clientItemPrice, 'Bs') === false) {
                                            $clientItemPrice .= ' Bs';
                                        }
                                        $oldPrice = $item->precio_anterior;
                                        if (empty($oldPrice) && strpos($item->oferta ?? '', '%') !== false) {
                                            $discountPercent = (int)str_replace('%', '', $item->oferta);
                                            $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $item->precio);
                                            if ($currentPrice > 0 && $discountPercent > 0) {
                                                $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                $oldPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                            }
                                        }
                                    @endphp
                                    <strong>{{ $clientItemPrice }}</strong>
                                    @if (!empty($oldPrice))
                                        <del style="color:#8f92b7; margin-left:8px;">{{ $oldPrice }}</del>
                                    @endif
                                </div>
                                @if ($item->oferta)
                                    <span class="badge-label {{ $item->color }}" style="font-size: 0.75rem;">{{ $item->oferta }}</span>
                                @endif
                            </article>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="#inicio" class="btn btn-lg rounded-pill px-5 me-2" style="background: #3735af; color: #ffffff;">Volver arriba</a>
                    <a href="#" class="btn btn-lg rounded-pill px-5" style="background: #3735af; color: #ffffff;">Ver más</a>
                </div>
            </div>
    </main>

    <footer class="footer-app" id="footer" style="background: #17193a; color: #d8d8ff; padding: 60px 0;">
        <div class="container-fluid px-4">
            <div class="row gy-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 style="color: #fff; font-weight: 700; margin-bottom: 18px;">Sobre la plataforma</h5>
                    <p>Plataforma web orientada a la organización y visualización de productos dentro del Mall Gran Vía. Encuentra información de tiendas y promociones en un solo lugar.</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 style="color: #fff; font-weight: 700; margin-bottom: 18px;">Explorar</h5>
                    <ul class="list-unstyled">
                        <li><a href="#ofertas" style="color: #d2d4ff; text-decoration: none;">Buscar productos</a></li>
                        <li><a href="{{ route('stores.index') }}" style="color: #d2d4ff; text-decoration: none;">Ver tiendas</a></li>
                        <li><a href="#ofertas" style="color: #d2d4ff; text-decoration: none;">Categorías</a></li>
                        <li><a href="#promos" style="color: #d2d4ff; text-decoration: none;">Productos destacados</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 style="color: #fff; font-weight: 700; margin-bottom: 18px;">Para comerciantes</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">Registrar mi tienda</a></li>
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">Solicitar rol de comerciante</a></li>
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">Gestionar productos</a></li>
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">Ver estadísticas</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 style="color: #fff; font-weight: 700; margin-bottom: 18px;">Contáctanos</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">Facebook - +123-456-7890</a></li>
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">Instagram - @mallgravia</a></li>
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">WhatsApp - +123-456-7890</a></li>
                        <li><a href="#" style="color: #d2d4ff; text-decoration: none;">E-Mail - hello@mallgravia.site</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-4 opacity-75">© 2026 Mall Gran Vía. Plataforma web para mejorar la experiencia comercial.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const heroCarousel = document.getElementById('heroSlides');
        if (heroCarousel) {
            const carousel = new bootstrap.Carousel(heroCarousel, {
                interval: 5000,
                pause: false
            });

            let isPaused = false;

            heroCarousel.addEventListener('mouseenter', () => {
                if (!isPaused) {
                    carousel.pause();
                }
            });

            heroCarousel.addEventListener('mouseleave', () => {
                if (!isPaused) {
                    carousel.cycle();
                }
            });

            heroCarousel.addEventListener('click', () => {
                carousel.next();
            });
        }

        document.querySelectorAll('.offer-scroll-btn').forEach(button => {
            button.addEventListener('click', () => {
                const direction = button.getAttribute('data-direction');
                const carousel = button.closest('.offer-products-wrapper').querySelector('.offer-carousel');
                const scrollAmount = carousel.clientWidth * 0.7;
                carousel.scrollBy({ left: direction === 'next' ? scrollAmount : -scrollAmount, behavior: 'smooth' });
            });
        });

        // Validación de Filtros
        const availableStores = @json($availableStores);
        const priceMinInput = document.getElementById('priceMin');
        const priceMaxInput = document.getElementById('priceMax');
        const storeFilterInput = document.getElementById('storeFilter');
        const offerOnlySwitch = document.getElementById('offerOnly');
        const filterError = document.getElementById('filterError');
        const applyFiltersBtn = document.getElementById('applyFiltersBtn');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
        
        // Hidden inputs para mantener filtros
        const hiddenPriceMin = document.getElementById('hiddenPriceMin');
        const hiddenPriceMax = document.getElementById('hiddenPriceMax');
        const hiddenStoreFilter = document.getElementById('hiddenStoreFilter');
        const hiddenOfferOnly = document.getElementById('hiddenOfferOnly');
        
        // Restaurar filtros guardados al cargar la página
        const restoreSavedFilters = () => {
            const savedFilters = JSON.parse(localStorage.getItem('searchFilters') || '{}');
            if (savedFilters.priceMin) priceMinInput.value = savedFilters.priceMin;
            if (savedFilters.priceMax) priceMaxInput.value = savedFilters.priceMax;
            if (savedFilters.storeFilter) storeFilterInput.value = savedFilters.storeFilter;
            if (savedFilters.offerOnly) offerOnlySwitch.checked = true;
        };

        // Guardar filtros en localStorage
        const saveFilters = () => {
            const filters = {
                priceMin: priceMinInput.value,
                priceMax: priceMaxInput.value,
                storeFilter: storeFilterInput.value,
                offerOnly: offerOnlySwitch.checked
            };
            localStorage.setItem('searchFilters', JSON.stringify(filters));
        };
        
        // Función para mostrar mensaje de éxito
        const showSuccessMessage = (message = 'Filtros aplicados con éxito') => {
            // Remover mensaje anterior si existe
            const existingMessage = document.querySelector('.filter-success-message');
            if (existingMessage) existingMessage.remove();
            
            const successMsg = document.createElement('div');
            successMsg.className = 'filter-success-message';
            successMsg.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
            document.body.appendChild(successMsg);
            
            // Remover después de 3 segundos
            setTimeout(() => successMsg.remove(), 3000);
        };

        const clearError = () => {
            filterError.innerHTML = '';
        };

        const validateFilters = () => {
            clearError();
            const minValue = priceMinInput.value.trim();
            const maxValue = priceMaxInput.value.trim();
            const storeValue = storeFilterInput.value.trim();
            const errors = [];

            // Validar precios
            if (minValue !== '' && maxValue !== '') {
                const minNum = parseFloat(minValue);
                const maxNum = parseFloat(maxValue);

                if (isNaN(minNum) || isNaN(maxNum)) {
                    errors.push('Los valores de precio deben ser números válidos.');
                } else {
                    if (minNum < 0 || maxNum < 0) {
                        errors.push('Los precios no pueden ser negativos. Por favor, ingresa valores positivos.');
                    }
                    if (minNum > maxNum) {
                        errors.push('El valor del precio mínimo no debe ser mayor al valor del precio máximo.');
                    }
                }
            }

            // Validar tienda
            if (storeValue !== '' && !availableStores.includes(storeValue)) {
                errors.push(`La tienda "${storeValue}" no está registrada en nuestro sistema. Verifica el nombre e intenta de nuevo con una tienda disponible.`);
            }

            // Mostrar errores si existen
            if (errors.length > 0) {
                const errorList = errors.map(error => `<li>${error}</li>`).join('');
                filterError.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 12px;">
                    <strong>¡Oops!</strong> Parece que ocurrieron algunos errores:
                    <ul class="mb-0 mt-2">${errorList}</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>`;
                return false;
            }

            return true;
        };

        // Obtener el elemento del offcanvas de filtros
        const filterOffcanvas = document.getElementById('filterOffcanvas');
        let filtersAppliedFlag = false;

        // Botón Aplicar
        applyFiltersBtn.addEventListener('click', () => {
            if (validateFilters()) {
                // Actualizar hidden inputs
                const minValue = priceMinInput.value.trim();
                const maxValue = priceMaxInput.value.trim();
                const storeValue = storeFilterInput.value.trim();
                const offerChecked = offerOnlySwitch.checked ? 'on' : '';
                
                hiddenPriceMin.value = minValue;
                hiddenPriceMax.value = maxValue;
                hiddenStoreFilter.value = storeValue;
                hiddenOfferOnly.value = offerChecked;
                
                // Guardar filtros en localStorage
                saveFilters();
                
                filtersAppliedFlag = true; // Marcar que se aplicaron
                
                // Mostrar mensaje de éxito
                showSuccessMessage('Filtros aplicados con éxito');
                
                // Cerrar offcanvas después de mostrar el mensaje
                setTimeout(() => {
                    const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                    if (offcanvas) offcanvas.hide();
                }, 500);
            }
        });

        // Botón Descartar
        clearFiltersBtn.addEventListener('click', () => {
            clearError();
            priceMinInput.value = '';
            priceMaxInput.value = '';
            storeFilterInput.value = '';
            offerOnlySwitch.checked = false;
            
            // Limpiar hidden inputs
            hiddenPriceMin.value = '';
            hiddenPriceMax.value = '';
            hiddenStoreFilter.value = '';
            hiddenOfferOnly.value = '';
            
            // Limpiar filtros guardados
            localStorage.removeItem('searchFilters');
            
            filtersAppliedFlag = true; // Marcar que se aplicaron cambios (limpios)
            
            // Mostrar mensaje de éxito
            showSuccessMessage('Filtros descartados');
            
            // Cerrar el offcanvas después de mostrar el mensaje
            setTimeout(() => {
                const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                if (offcanvas) offcanvas.hide();
            }, 500);
        });

        // Limpieza automática al cerrar el offcanvas sin aplicar
        filterOffcanvas.addEventListener('hidden.bs.offcanvas', () => {
            // Si no se presionó "Aplicar", limpiar automáticamente
            if (!filtersAppliedFlag) {
                // Restaurar a los valores guardados
                const savedFilters = JSON.parse(localStorage.getItem('searchFilters') || '{}');
                priceMinInput.value = savedFilters.priceMin || '';
                priceMaxInput.value = savedFilters.priceMax || '';
                storeFilterInput.value = savedFilters.storeFilter || '';
                offerOnlySwitch.checked = savedFilters.offerOnly || false;
            }
            filtersAppliedFlag = false; // Resetear el flag
            clearError();
        });

        // Restaurar filtros al cargar la página
        restoreSavedFilters();

        // Evitar que se ingrese cero al inicio del número en campos de precio
        priceMinInput.addEventListener('input', function() {
            if (this.value.length > 1 && this.value.charAt(0) === '0') {
                this.value = this.value.substring(1);
            }
            // Limitar a 7 caracteres (máximo 999999)
            if (this.value.length > 7) {
                this.value = this.value.substring(0, 7);
            }
        });

        priceMaxInput.addEventListener('input', function() {
            if (this.value.length > 1 && this.value.charAt(0) === '0') {
                this.value = this.value.substring(1);
            }
            // Limitar a 7 caracteres (máximo 999999)
            if (this.value.length > 7) {
                this.value = this.value.substring(0, 7);
            }
        });

        // Evitar que se ingrese cero al inicio del número en campos de precio
        priceMinInput.addEventListener('input', function() {
            if (this.value.length > 1 && this.value.charAt(0) === '0') {
                this.value = this.value.substring(1);
            }
            // Limitar a 7 caracteres (máximo 999999)
            if (this.value.length > 7) {
                this.value = this.value.substring(0, 7);
            }
        });

        priceMaxInput.addEventListener('input', function() {
            if (this.value.length > 1 && this.value.charAt(0) === '0') {
                this.value = this.value.substring(1);
            }
            // Limitar a 7 caracteres (máximo 999999)
            if (this.value.length > 7) {
                this.value = this.value.substring(0, 7);
            }
        });

        // Interceptar eventos de offcanvas para prevenir que Bootstrap agregue padding-right al body
        document.addEventListener('show.bs.offcanvas', function(e) {
            document.body.style.paddingRight = '0 !important';
            document.body.style.overflow = 'hidden !important';
            document.documentElement.style.overflow = 'hidden !important';
            // Remover el padding-right que Bootstrap intenta agregar
            setTimeout(() => {
                document.body.style.paddingRight = '0';
                document.body.style.removeProperty('padding-right');
            }, 0);
        });

        document.addEventListener('hidden.bs.offcanvas', function(e) {
            document.body.style.paddingRight = '';
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
        });

        // Observer para detectar cambios de estilo en el body y corregirlos
        const bodyStyleObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'style') {
                    const body = mutation.target;
                    if (body.style.paddingRight && body.classList.contains('offcanvas-open')) {
                        body.style.paddingRight = '0 !important';
                    }
                }
            });
        });

        bodyStyleObserver.observe(document.body, {
            attributes: true,
            attributeFilter: ['style']
        });
    </script>
</body>
</html>