@php
    $heroSlides = [
        [
            'title' => 'Bienvenido al Mall Gran Vía',
            'text' => 'Descubre tiendas, promociones y servicios en un solo lugar. Desliza para encontrar lo que quieres.',
            'image' => 'https://via.placeholder.com/1200x600/5930c1/ffffff?text=Bienvenido+al+Mall+Gran+V%C3%ADa'
        ],
        [
            'title' => 'Ofertas destacadas cada día',
            'text' => 'Las mejores promociones de tu mall están aquí: descuentos, 2x1, combos y productos imperdibles.',
            'image' => 'https://via.placeholder.com/1200x600/1d9ebd/ffffff?text=Ofertas+del+D%C3%ADa'
        ],
        [
            'title' => 'Recomendaciones personalizadas',
            'text' => 'Encuentra productos según tus búsquedas y lo más visitado en la plataforma.',
            'image' => 'https://via.placeholder.com/1200x600/ce46ae/ffffff?text=Recomendaciones'
        ],
    ];

    $offers = [
        [
            'store' => 'Tienda Plaza',
            'products' => [
                ['name' => 'Auriculares Pro', 'price' => '120 BS', 'old' => '180 BS', 'expires' => '12/04/2026', 'badge' => '25%', 'color' => 'offer-red'],
                ['name' => 'Reloj Smart', 'price' => '350 BS', 'old' => '450 BS', 'expires' => '15/04/2026', 'badge' => '2x1', 'color' => 'offer-blue'],
                ['name' => 'Bolso Urbano', 'price' => '90 BS', 'old' => '120 BS', 'expires' => '18/04/2026', 'badge' => 'Especial', 'color' => 'offer-purple'],
            ],
        ],
        [
            'store' => 'ElectroMall',
            'products' => [
                ['name' => 'Smart TV 55"', 'price' => '2,500 BS', 'old' => '2,950 BS', 'expires' => '14/04/2026', 'badge' => '15%', 'color' => 'offer-red'],
                ['name' => 'Laptop Ultra', 'price' => '4,200 BS', 'old' => '4,950 BS', 'expires' => '16/04/2026', 'badge' => '15%', 'color' => 'offer-red'],
                ['name' => 'Tablet Pro', 'price' => '580 BS', 'old' => '720 BS', 'expires' => '19/04/2026', 'badge' => '2x1', 'color' => 'offer-blue'],
            ],
        ],
    ];

    $promos = [
        [
            'type' => 'Servicio',
            'title' => 'Masaje Relajante',
            'category' => 'Spa & Bienestar',
            'description' => 'Masaje terapéutico relajante de 60 minutos con promoción especial para clientes VIP del mall.',
            'expires' => '20/04/2026',
            'badge' => '25%',
            'color' => 'offer-red',
        ],
        [
            'type' => 'Servicio',
            'title' => 'Peluquería Premium',
            'category' => 'Salón de Belleza',
            'description' => 'Corte, peinado y tratamiento capilar con productos premium en nuestro salón de cinco estrellas.',
            'expires' => '22/04/2026',
            'badge' => '2x1',
            'color' => 'offer-blue',
        ],
    ];

    $recommendations = [
        ['name' => 'Smart TV 55"', 'store' => 'ElectroMall', 'price' => '2,500 BS', 'offer' => '15%', 'color' => 'offer-red'],
        ['name' => 'Cámara deportiva', 'store' => 'FotoClick', 'price' => '450 BS', 'offer' => null, 'color' => null],
        ['name' => 'Zapatillas Run', 'store' => 'Deportes Plus', 'price' => '310 BS', 'offer' => '2x1', 'color' => 'offer-blue'],
        ['name' => 'Auriculares Gaming', 'store' => 'TecnoShop', 'price' => '180 BS', 'offer' => null, 'color' => null],
        ['name' => 'Silla Oficina', 'store' => 'Hogar Feliz', 'price' => '360 BS', 'offer' => null, 'color' => null],
        ['name' => 'Laptop Ultra', 'store' => 'ElectroMall', 'price' => '4,200 BS', 'offer' => '15%', 'color' => 'offer-red'],
    ];
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
    <style>
        html, body { width: 100%; overflow-x: hidden; }
        body { font-family: 'Montserrat', sans-serif; background: #eef0ff; color: #1f1f4e; }
        main { width: 100%; overflow-x: hidden; }
        .app-header { background: #6f62f0; color: #fff; padding: 18px 0; position: sticky; top: 0; z-index: 1030; }
        .app-header .menu-btn img { width: 30px; height: auto; }
        .app-header .search-box { background: #fff; border-radius: 999px; padding: 10px 18px; border: none; width: 100%; }
        .app-header .search-box:focus { outline: none; box-shadow: 0 0 0 3px rgba(111,98,240,0.18); }
        .app-header .user-chip { background: rgba(255,255,255,0.16); border-radius: 999px; padding: 8px 16px; display: inline-flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; }
        .app-header .user-chip img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.35); }
        .hero-carousel .carousel-item { min-height: 500px; border-radius: 24px; overflow: hidden; position: relative; }
        .hero-carousel .carousel-item img { object-fit: cover; width: 100%; height: 100%; filter: brightness(0.6); }
        .hero-carousel .carousel-caption { position: absolute; top: 55%; left: 6%; transform: translateY(-50%); max-width: 560px; text-align: left; }
        .hero-carousel .carousel-caption h1 { font-size: clamp(2.5rem, 4vw, 4.2rem); line-height: 1.03; font-weight: 800; margin-bottom: 18px; }
        .hero-carousel .carousel-caption p { font-size: 1.05rem; margin-bottom: 22px; max-width: 440px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 56px; height: 56px; background: rgba(0,0,0,0.4); border-radius: 50%; bottom: 18px; }
        .hero-carousel .carousel-indicators [data-bs-target] { background-color: rgba(255,255,255,0.9); }
        .section-title { font-weight: 700; letter-spacing: 1px; margin-bottom: 12px; }
        .section-subtitle { color: #6c7190; margin-bottom: 24px; }
        .offer-card { border-radius: 24px; padding: 26px; background: #fff; min-height: 425px; box-shadow: 0 20px 42px rgba(60,63,106,0.09); }
        .offer-card .store-title { font-size: 1.35rem; font-weight: 700; margin-bottom: 24px; }
        .product-promo { background: #f6f7ff; border-radius: 18px; padding: 18px; margin-bottom: 18px; }
        .product-promo .product-name { font-weight: 700; margin-bottom: 8px; }
        .product-promo .prices { font-size: 0.95rem; display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .product-promo .prices del { color: #9ea0c4; }
        .product-promo .expires { color: #7c7fa1; font-size: 0.88rem; }
        .badge-label { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; }
        .offer-red { background: #e9524c; }
        .offer-blue { background: #2b8fe0; }
        .offer-purple { background: #7d5cff; }
        .promo-row { gap: 24px; }
        .promo-card { border-radius: 24px; padding: 30px; min-height: 360px; position: relative; overflow: hidden; color: #fff; }
        .promo-card.service { background: linear-gradient(135deg, #7d5cff, #4f3bcb); }
        .promo-card.food { background: linear-gradient(135deg, #2d90e2, #1a58c2); }
        .promo-card h3 { font-size: 2rem; margin-bottom: 12px; }
        .promo-card .category { font-size: 0.92rem; opacity: 0.95; margin-bottom: 16px; }
        .promo-card .promo-text { font-size: 1rem; line-height: 1.7; margin-bottom: 18px; }
        .promo-card .expires { font-size: 0.9rem; margin-bottom: 20px; display: inline-flex; align-items: center; gap: 10px; }
        .promo-card .btn { border-radius: 999px; }
        .recommendation-card { background: #fff; border-radius: 22px; padding: 22px; box-shadow: 0 20px 35px rgba(64,69,148,0.08); min-height: 220px; transition: transform .25s ease; }
        .recommendation-card:hover { transform: translateY(-8px); }
        .recommendation-card .title { font-weight: 700; margin-bottom: 10px; }
        .recommendation-card .store-name { color: #7c7f9c; margin-bottom: 12px; }
        .recommendation-card .price { font-size: 1.15rem; font-weight: 700; margin-bottom: 14px; }
        .recommendation-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; }
        .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 18px; }
        .footer-app a { color: #d2d4ff; text-decoration: none; }
        .footer-app a:hover { color: #fff; }
        .filter-panel { width: 340px; padding: 24px; }
        .filter-field { margin-bottom: 22px; }
        .filter-field label { display: block; font-weight: 700; margin-bottom: 10px; }
        .filter-field input, .filter-field select { width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; }
        .filter-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .btn-link-white { color: #fff; text-decoration: none; }
        .btn-link-white:hover { text-decoration: underline; color: #f6f7ff; }
        .carousel-controls { margin-top: 22px; display: flex; justify-content: center; gap: 14px; }
        @media (max-width: 991px) {
            .hero-carousel .carousel-caption { left: 20px; right: 20px; max-width: none; }
            .promo-row { flex-direction: column; }
        }
    </style>
</head>
<body>
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
                    <form action="#" method="GET" class="d-flex align-items-center gap-2">
                        <input type="text" class="search-box" placeholder="Buscar productos, tiendas o servicios..." aria-label="Buscar" />
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
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn" style="background: #6f62f0; border: 1px solid rgba(111,98,240,0.3); border-radius: 16px; min-width: 200px;">
                        @auth
                            <li>
                                <a class="dropdown-item" href="#" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                    <i class="bi bi-person-circle" style="margin-right: 10px;"></i> Mi Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" style="margin: 6px 0; border-color: rgba(255,255,255,0.2);"></li>
                            <li>
                                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px; width: 100%; text-align: left; border: none; background: transparent; cursor: pointer;">
                                        <i class="bi bi-box-arrow-right" style="margin-right: 10px;"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                    <i class="bi bi-box-arrow-in-right" style="margin-right: 10px;"></i> Iniciar Sesión
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                    <i class="bi bi-person-plus" style="margin-right: 10px;"></i> Registrarse
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menú</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">
                <li id="backToDashboardLink" style="display: none;"><a href="/dashboard" class="d-block py-2"><i class="bi bi-house me-2"></i>Volver al dashboard</a></li>
                <li><a href="#inicio" class="d-block py-2">Inicio</a></li>
                <li><a href="#ofertas" class="d-block py-2">Ofertas del día</a></li>
                <li><a href="#promos" class="d-block py-2">Promociones</a></li>
                <li><a href="#recomendaciones" class="d-block py-2">Recomendaciones</a></li>
                <li><a href="#footer" class="d-block py-2">Contacto</a></li>
            </ul>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filtros de búsqueda</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body filter-panel">
            <div class="filter-field">
                <label for="priceMin">Precio mínimo</label>
                <input type="number" id="priceMin" placeholder="Desde" />
            </div>
            <div class="filter-field">
                <label for="priceMax">Precio máximo</label>
                <input type="number" id="priceMax" placeholder="Hasta" />
            </div>
            <div class="filter-field">
                <label for="storeFilter">Tienda específica</label>
                <input type="text" id="storeFilter" placeholder="Ej: Moda Express" />
            </div>
            <div class="filter-field">
                <label class="form-check-label d-flex align-items-center gap-2">
                    <input class="form-check-input" type="checkbox" id="offerOnly"> Solo resultados con oferta
                </label>
            </div>
            <div class="filter-actions">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Descartar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas">Aplicar</button>
            </div>
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
            <div class="carousel-controls text-center">
                <button class="btn btn-outline-secondary" id="pauseSlide">Pausar rotación</button>
                <button class="btn btn-outline-secondary" id="resumeSlide">Continuar</button>
            </div>
        </section>

        <section id="ofertas" class="mb-5">
            <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
                <div>
                    <div class="section-title">Ofertas del día</div>
                    <div class="section-subtitle">Las tiendas con mejores estadísticas y sus productos más atractivos.</div>
                </div>
                <div class="text-md-end">
                    <span class="badge bg-primary rounded-pill px-3 py-2">Mejores visitas y reseñas</span>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($offers as $offer)
                    <div class="col-12 col-lg-6">
                        <div class="offer-card">
                            <div class="store-title">{{ $offer['store'] }}</div>
                            @foreach ($offer['products'] as $product)
                                @php
                                    $welcomePrice = $product['price'];
                                    if (strpos($welcomePrice, 'Bs') === false) {
                                        $welcomePrice .= ' Bs';
                                    }
                                    $welcomeOldPrice = $product['old'] ?? '';
                                    if (empty($welcomeOldPrice) && !empty($product['badge']) && strpos($product['badge'], '%') !== false) {
                                        $discountPercent = (int)str_replace('%', '', $product['badge']);
                                        $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product['price']);
                                        if ($currentPrice > 0 && $discountPercent > 0) {
                                            $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                            $welcomeOldPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                        }
                                    }
                                @endphp
                                <div class="product-promo">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="product-name">{{ $product['name'] }}</div>
                                            <div class="prices"><strong>{{ $welcomePrice }}</strong><del>{{ $welcomeOldPrice }}</del></div>
                                            <div class="expires">Vence: {{ $product['expires'] }}</div>
                                        </div>
                                        <span class="badge-label {{ $product['color'] }}">{{ $product['badge'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="promos" class="mb-5">
            <div class="section-title">Promos del día</div>
            <div class="section-subtitle">Promociones destacadas con servicios y combos de comida.</div>
            <div class="row promo-row">
                <div class="col-12 col-xl-6">
                    <div class="promo-card service">
                        <span class="badge-label offer-red mb-3">{{ $promos[0]['badge'] }}</span>
                        <h3>{{ $promos[0]['title'] }}</h3>
                        <div class="category">{{ $promos[0]['category'] }}</div>
                        <p class="promo-text">{{ $promos[0]['description'] }}</p>
                        <div class="expires">Vence: {{ $promos[0]['expires'] }}</div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="promo-card food">
                        <span class="badge-label offer-blue mb-3">{{ $promos[1]['badge'] }}</span>
                        <h3>{{ $promos[1]['title'] }}</h3>
                        <div class="category">{{ $promos[1]['category'] }}</div>
                        <p class="promo-text">{{ $promos[1]['description'] }}</p>
                        <div class="expires">Vence: {{ $promos[1]['expires'] }}</div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-lg btn-primary rounded-pill px-5">Ver súper ofertas</a>
            </div>
        </section>

        <section id="recomendaciones" class="mb-5">
            <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
                <div>
                    <div class="section-title">Productos que pueden interesarte</div>
                    <div class="section-subtitle">Basado en búsquedas populares y lo más visto del mall.</div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#inicio" class="btn btn-outline-secondary rounded-pill">Volver arriba</a>
                    <a href="#" class="btn btn-primary rounded-pill">Ver más</a>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($recommendations as $item)
                    <div class="col-12 col-md-6 col-xl-3">
                        <article class="recommendation-card">
                            <div class="title">{{ $item['name'] }}</div>
                            <div class="store-name">{{ $item['store'] }}</div>
                            <div class="price">@php
                                $recPrice = $item['price'];
                                if (strpos($recPrice, 'Bs') === false && is_numeric($recPrice)) {
                                    $recPrice .= ' Bs';
                                }
                            @endphp {{ $recPrice }}</div>
                            @if ($item['offer'])
                                <span class="badge-label {{ $item['color'] }}">{{ $item['offer'] }}</span>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
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
                        <li><a href="#recomendaciones" style="color: #d2d4ff; text-decoration: none;">Ver tiendas</a></li>
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
        document.addEventListener('DOMContentLoaded', function () {
            const heroCarousel = document.querySelector('#heroSlides');
            const carousel = new bootstrap.Carousel(heroCarousel, { interval: 6500, pause: 'hover' });
            document.getElementById('pauseSlide').addEventListener('click', function () { carousel.pause(); });
            document.getElementById('resumeSlide').addEventListener('click', function () { carousel.cycle(); });

            // Mostrar/ocultar opción "Volver al inicio" basado en la ubicación actual
            const backToDashboardLink = document.getElementById('backToDashboardLink');
            const currentPath = window.location.pathname;
            if (currentPath !== '/' && currentPath !== '') {
                backToDashboardLink.style.display = 'block';
            }
        });
    </script>
</body>
</html>
@php
    $heroSlides = [
        [
            'title' => 'Bienvenido al Mall Gran Vía',
            'text' => 'Descubre tiendas, promociones y servicios en un solo lugar. Desliza para encontrar lo que quieres.',
            'image' => 'https://via.placeholder.com/1200x600/5930c1/ffffff?text=Bienvenido+al+Mall+Gran+V%C3%ADa'
        ],
        [
            'title' => 'Ofertas destacadas cada día',
            'text' => 'Las mejores promociones de tu mall están aquí: descuentos, 2x1, combos y productos imperdibles.',
            'image' => 'https://via.placeholder.com/1200x600/1d9ebd/ffffff?text=Ofertas+del+D%C3%ADa'
        ],
        [
            'title' => 'Recomendaciones personalizadas',
            'text' => 'Encuentra productos según tus búsquedas y lo más visitado en la plataforma.',
            'image' => 'https://via.placeholder.com/1200x600/ce46ae/ffffff?text=Recomendaciones'
        ],
    ];

    $offers = [
        [
            'store' => 'Tienda Plaza',
            'products' => [
                ['name' => 'Auriculares Pro', 'price' => '120 BS', 'old' => '180 BS', 'expires' => '12/04/2026', 'type' => 'Porcentaje', 'badge' => '25%', 'color' => 'offer-red'],
                ['name' => 'Reloj Smart', 'price' => '350 BS', 'old' => '450 BS', 'expires' => '15/04/2026', 'type' => 'Combo', 'badge' => '2x1', 'color' => 'offer-blue'],
                ['name' => 'Bolso Urbano', 'price' => '90 BS', 'old' => '120 BS', 'expires' => '18/04/2026', 'type' => 'Exclusivo', 'badge' => 'Especial', 'color' => 'offer-purple'],
            ],
        ],
        [
            'store' => 'Moda Express',
            'products' => [
                ['name' => 'Zapatos Trend', 'price' => '150 BS', 'old' => '190 BS', 'expires' => '14/04/2026', 'type' => 'Porcentaje', 'badge' => '20%', 'color' => 'offer-red'],
                ['name' => 'Camisa Casual', 'price' => '80 BS', 'old' => '110 BS', 'expires' => '16/04/2026', 'type' => 'Combo', 'badge' => '2x1', 'color' => 'offer-blue'],
                ['name' => 'Set de Accesorios', 'price' => '60 BS', 'old' => '80 BS', 'expires' => '19/04/2026', 'type' => 'Exclusivo', 'badge' => 'Especial', 'color' => 'offer-purple'],
            ],
        ],
    ];

    $promos = [
        [
            'type' => 'Servicio',
            'title' => 'Spa Relax',
            'category' => 'Belleza y bienestar',
            'description' => 'Promoción destacada para masajes relajantes y tratamientos exprés en el spa del mall.',
            'expires' => '20/04/2026',
            'badge' => '25%',
            'color' => 'offer-red',
        ],
        [
            'type' => 'Comida',
            'title' => 'Combo Sabor',
            'category' => 'Patio de comidas',
            'description' => 'Combo especial de hamburguesa, papas y bebida con descuento exclusivo para clientes.',
            'expires' => '22/04/2026',
            'badge' => '2x1',
            'color' => 'offer-blue',
        ],
    ];

    $recommendations = [
        ['name' => 'Smart TV 55"', 'store' => 'ElectroMall', 'price' => '2,500 BS', 'offer' => '15%', 'color' => 'offer-red'],
        ['name' => 'Cámara deportiva', 'store' => 'FotoClick', 'price' => '450 BS', 'offer' => null, 'color' => null],
        ['name' => 'Zapatillas Run', 'store' => 'Deportes Plus', 'price' => '310 BS', 'offer' => '2x1', 'color' => 'offer-blue'],
        ['name' => 'Auriculares Gaming', 'store' => 'TecnoShop', 'price' => '180 BS', 'offer' => null, 'color' => null],
        ['name' => 'Silla Oficina', 'store' => 'Hogar Feliz', 'price' => '360 BS', 'offer' => null, 'color' => null],
        ['name' => 'Laptop Ultra', 'store' => 'ElectroMall', 'price' => '4,200 BS', 'offer' => '15%', 'color' => 'offer-red'],
    ];
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
    <style>
        html, body { width: 100%; overflow-x: hidden; }
        body { font-family: 'Montserrat', sans-serif; background: #eef0ff; color: #1f1f4e; }
        main { width: 100%; overflow-x: hidden; }
        .app-header { background: #6f62f0; color: #fff; padding: 20px 0; position: sticky; top: 0; z-index: 1020; }
        .app-header .menu-btn img { width: 30px; height: auto; }
        .app-header .search-box { background: #fff; border-radius: 999px; padding: 8px 16px; border: none; width: 100%; }
        .app-header .search-box:focus { outline: none; box-shadow: 0 0 0 3px rgba(111,98,240,0.18); }
        .app-header .user-chip { background: rgba(255,255,255,0.15); border-radius: 999px; padding: 8px 14px; display: inline-flex; align-items: center; gap: 10px; color: #fff; }
        .app-header .user-chip img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.35); }
        .hero-carousel .carousel-item { min-height: 460px; border-radius: 24px; overflow: hidden; background: #2e2bd7; color: #fff; position: relative; }
        .hero-carousel .carousel-item img { object-fit: cover; width: 100%; height: 100%; filter: brightness(0.7); }
        .hero-carousel .carousel-caption { position: absolute; top: 50%; left: 8%; transform: translateY(-50%); max-width: 520px; text-align: left; }
        .hero-carousel .carousel-caption h1 { font-size: clamp(2.3rem, 4vw, 3.8rem); line-height: 1.05; font-weight: 700; }
        .hero-carousel .carousel-caption p { font-size: 1rem; margin-top: 14px; margin-bottom: 18px; max-width: 420px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 60px; height: 60px; background: rgba(0,0,0,0.5); border-radius: 50%; top: auto; bottom: 25px; }
        .hero-carousel .carousel-indicators [data-bs-target] { background-color: rgba(255,255,255,0.75); }
        .hero-card { border-radius: 24px; background: #7d5cff; padding: 30px; color: #fff; position: relative; overflow: hidden; }
        .hero-card .slide-controls { display: inline-flex; gap: 12px; margin-top: 18px; }
        .hero-card .slide-controls button { border: none; border-radius: 999px; padding: 10px 18px; background: rgba(255,255,255,0.18); color: #fff; }
        .section-title { font-weight: 700; letter-spacing: 1px; margin-bottom: 24px; }
        .section-subtitle { color: #66698d; margin-bottom: 18px; }
        .offer-card { border-radius: 24px; padding: 22px; background: #f4f5ff; min-height: 420px; }
        .offer-card .store-title { font-size: 1.15rem; font-weight: 700; margin-bottom: 20px; }
        .product-promo { background: rgba(111,98,240,0.1); border-radius: 18px; padding: 16px; margin-bottom: 16px; }
        .product-promo .product-name { font-weight: 700; margin-bottom: 8px; }
        .product-promo .prices { font-size: 0.95rem; display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .product-promo .prices del { color: #a5a7c9; }
        .product-promo .expires { color: #7d7ec9; font-size: 0.86rem; }
        .badge-label { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 6px 12px; font-size: 0.78rem; font-weight: 700; color: #fff; }
        .offer-red { background: #e9524c; }
        .offer-blue { background: #2b8fe0; }
        .offer-purple { background: #7d5cff; }
        .promo-row { gap: 24px; }
        .promo-card { border-radius: 24px; padding: 28px; color: #fff; min-height: 360px; position: relative; overflow: hidden; }
        .promo-card.service { background: linear-gradient(135deg, #7d5cff, #4f3bcb); }
        .promo-card.food { background: linear-gradient(135deg, #2d90e2, #1a58c2); }
        .promo-card h3 { font-size: 1.8rem; margin-bottom: 10px; }
        .promo-card .category { font-size: 0.9rem; opacity: 0.9; margin-bottom: 18px; }
        .promo-card .promo-text { font-size: 1rem; line-height: 1.55; margin-bottom: 16px; }
        .promo-card .expires { font-size: 0.9rem; margin-bottom: 18px; display: inline-flex; align-items: center; gap: 8px; }
        .recommendation-card { background: #fff; border-radius: 20px; padding: 18px; box-shadow: 0 12px 30px rgba(72,76,131,0.08); min-height: 220px; transition: transform .3s ease; }
        .recommendation-card:hover { transform: translateY(-6px); }
        .recommendation-card .title { font-weight: 700; margin-bottom: 10px; }
        .recommendation-card .store-name { font-size: 0.92rem; color: #7b7eab; margin-bottom: 10px; }
        .recommendation-card .price { font-size: 1.15rem; font-weight: 700; margin-bottom: 10px; }
        .recommendation-footer { display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; }
        .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; }
        .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 16px; }
        .footer-app a { color: #cfd0ff; text-decoration: none; }
        .footer-app a:hover { color: #fff; }
        .filter-panel { width: 360px; padding: 24px; }
        .filter-field { margin-bottom: 18px; }
        .filter-field label { display: block; font-weight: 600; margin-bottom: 8px; }
        .filter-field input, .filter-field select { width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d0d0e8; }
        .filter-actions { display: flex; justify-content: space-between; gap: 12px; }
        .filter-actions .btn { width: 100%; }
        .btn-link-white { color: #fff; text-decoration: none; }
        .btn-link-white:hover { text-decoration: underline; color: #f4f6ff; }
        .badge-offer { text-transform: uppercase; letter-spacing: .6px; }
        .carousel-controls { margin-top: 20px; display: flex; justify-content: center; gap: 12px; }
        .carousel-controls button { min-width: 140px; }
        @media (max-width: 991px) {
            .hero-carousel .carousel-caption { left: 15px; right: 15px; max-width: none; }
            .promo-row { flex-direction: column; }
        }
    </style>
</head>
<body>
    <header class="app-header shadow-sm">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn p-0 menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                        <img src="{{ asset('images/menu.png') }}" alt="Menú" />
                    </button>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Mall Gran Vía" width="42" />
                        <div>
                            <div style="font-weight:700; font-size:1rem;">Mall Gran Vía</div>
                            <small style="color: rgba(255,255,255,.85);">Tu centro comercial digital</small>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="position-relative flex-grow-1">
                        <form action="#" method="GET" class="d-flex align-items-center gap-2">
                            <input type="text" class="search-box" placeholder="Buscar productos, tiendas o servicios..." aria-label="Buscar" />
                            <button type="button" class="btn btn-white border rounded-circle p-2" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas" title="Filtros de búsqueda">
                                <img src="{{ asset('images/filtros.png') }}" alt="Filtros" width="24" />
                            </button>
                        </form>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn btn-link user-chip dropdown-toggle" type="button" id="userMenuBtn2" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; cursor: pointer; background: transparent;">
                            <img src="{{ asset('images/sinfoto.png') }}" alt="Perfil" />
                            <div class="text-start">
                                <div style="font-size:.95rem;">¡Bienvenido!</div>
                                <div style="font-size:.85rem; opacity:.85;">@auth {{ Auth::user()->name }} @else Invitado @endauth</div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn2" style="background: #6f62f0; border: 1px solid rgba(111,98,240,0.3); border-radius: 16px; min-width: 200px;">
                            @auth
                                <li>
                                    <a class="dropdown-item" href="#" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                        <i class="bi bi-person-circle" style="margin-right: 10px;"></i> Mi Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="margin: 6px 0; border-color: rgba(255,255,255,0.2);"></li>
                                <li>
                                    <form id="logoutForm2" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px; width: 100%; text-align: left; border: none; background: transparent; cursor: pointer;">
                                            <i class="bi bi-box-arrow-right" style="margin-right: 10px;"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                        <i class="bi bi-box-arrow-in-right" style="margin-right: 10px;"></i> Iniciar Sesión
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}" style="color: #fff; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                                        <i class="bi bi-person-plus" style="margin-right: 10px;"></i> Registrarse
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menú</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled">
                <li id="backToDashboardLink" style="display: none;"><a href="/dashboard" class="d-block py-2"><i class="bi bi-house me-2"></i>Volver al dashboard</a></li>
                <li><a href="#inicio" class="d-block py-2">Inicio</a></li>
                <li><a href="#ofertas" class="d-block py-2">Ofertas del día</a></li>
                <li><a href="#promos" class="d-block py-2">Promociones</a></li>
                <li><a href="#recomendaciones" class="d-block py-2">Recomendaciones</a></li>
                <li><a href="#footer" class="d-block py-2">Contacto</a></li>
            </ul>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filtros de búsqueda</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body filter-panel">
            <div class="filter-field">
                <label for="priceRange">Rango de precio</label>
                <div class="d-flex gap-2">
                    <input type="number" id="priceMin" class="form-control" placeholder="Desde" min="0">
                    <input type="number" id="priceMax" class="form-control" placeholder="Hasta" min="0">
                </div>
            </div>
            <div class="filter-field">
                <label for="storeFilter">Tienda específica</label>
                <input type="text" id="storeFilter" class="form-control" placeholder="Ej: Moda Express">
            </div>
            <div class="filter-field">
                <label for="offerOnly" class="form-check-label d-flex align-items-center gap-2">
                    <input class="form-check-input" type="checkbox" value="" id="offerOnly"> Solo ofertas y promociones
                </label>
            </div>
            <div class="filter-actions">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Descartar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas">Aplicar</button>
            </div>
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
            <div class="carousel-controls text-center">
                <button class="btn btn-outline-secondary" id="pauseSlide">Pausar rotación</button>
                <button class="btn btn-outline-secondary" id="resumeSlide">Continuar</button>
            </div>
        </section>

        <section id="ofertas" class="mb-5">
            <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
                <div>
                    <div class="section-title">Ofertas del día</div>
                    <div class="section-subtitle">Las tiendas con mejores estadísticas y sus productos más atractivos.</div>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary rounded-pill px-3 py-2">Mejores visitas y reseñas</span>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($offers as $offer)
                    <div class="col-12 col-lg-6">
                        <div class="offer-card">
                            <div class="store-title">{{ $offer['store'] }}</div>
                            @foreach ($offer['products'] as $product)
                                @php
                                    $welcomePrice2 = $product['price'];
                                    if (strpos($welcomePrice2, 'Bs') === false) {
                                        $welcomePrice2 .= ' Bs';
                                    }
                                    $welcomeOldPrice2 = $product['old'] ?? '';
                                    if (empty($welcomeOldPrice2) && !empty($product['badge']) && strpos($product['badge'], '%') !== false) {
                                        $discountPercent2 = (int)str_replace('%', '', $product['badge']);
                                        $currentPrice2 = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product['price']);
                                        if ($currentPrice2 > 0 && $discountPercent2 > 0) {
                                            $originalPrice2 = round($currentPrice2 / (1 - $discountPercent2 / 100));
                                            $welcomeOldPrice2 = number_format($originalPrice2, 0, ',', '.') . ' Bs';
                                        }
                                    }
                                @endphp
                                <div class="product-promo">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="product-name">{{ $product['name'] }}</div>
                                            <div class="prices"><strong>{{ $welcomePrice2 }}</strong><del>{{ $welcomeOldPrice2 }}</del></div>
                                            <div class="expires">Vence: {{ $product['expires'] }}</div>
                                        </div>
                                        <span class="badge-label badge-offer {{ $product['color'] }}">{{ $product['badge'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="promos" class="mb-5">
            <div class="section-title">Promos del día</div>
            <div class="section-subtitle">Promociones destacadas con servicios y combos de comida.</div>
            <div class="row promo-row">
                <div class="col-12 col-xl-6">
                    <div class="promo-card service">
                        <div class="badge-label offer-red mb-3">{{ $promos[0]['badge'] }}</div>
                        <h3>{{ $promos[0]['title'] }}</h3>
                        <div class="category">{{ $promos[0]['category'] }}</div>
                        <p class="promo-text">{{ $promos[0]['description'] }}</p>
                        <div class="expires">Vence: {{ $promos[0]['expires'] }}</div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="promo-card food">
                        <div class="badge-label offer-blue mb-3">{{ $promos[1]['badge'] }}</div>
                        <h3>{{ $promos[1]['title'] }}</h3>
                        <div class="category">{{ $promos[1]['category'] }}</div>
                        <p class="promo-text">{{ $promos[1]['description'] }}</p>
                        <div class="expires">Vence: {{ $promos[1]['expires'] }}</div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-lg btn-primary rounded-pill px-5">Ver súper ofertas</a>
            </div>
        </section>

        <section id="recomendaciones" class="mb-5">
            <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
                <div>
                    <div class="section-title">Productos que pueden interesarte</div>
                    <div class="section-subtitle">Basado en búsquedas populares y lo más visto del mall.</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="#inicio" class="btn btn-outline-secondary rounded-pill">Volver arriba</a>
                    <a href="#" class="btn btn-primary rounded-pill">Ver más</a>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($recommendations as $item)
                    <div class="col-12 col-md-6 col-xl-3">
                        <article class="recommendation-card">
                            <div class="title">{{ $item['name'] }}</div>
                            <div class="store-name">{{ $item['store'] }}</div>
                            <div class="price">@php
                                $recPrice2 = $item['price'];
                                if (strpos($recPrice2, 'Bs') === false && is_numeric($recPrice2)) {
                                    $recPrice2 .= ' Bs';
                                }
                            @endphp {{ $recPrice2 }}</div>
                            @if ($item['offer'])
                                <span class="badge-label badge-offer {{ $item['color'] }}">{{ $item['offer'] }}</span>
                            @endif
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
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
                        <li><a href="#recomendaciones" style="color: #d2d4ff; text-decoration: none;">Ver tiendas</a></li>
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
        document.addEventListener('DOMContentLoaded', function () {
            const heroCarousel = document.querySelector('#heroSlides');
            const carousel = new bootstrap.Carousel(heroCarousel, { interval: 6500, pause: 'hover' });
            document.getElementById('pauseSlide').addEventListener('click', function () { carousel.pause(); });
            document.getElementById('resumeSlide').addEventListener('click', function () { carousel.cycle(); });

            // Mostrar/ocultar opción "Volver al inicio" basado en la ubicación actual
            const backToDashboardLink = document.getElementById('backToDashboardLink');
            const currentPath = window.location.pathname;
            if (currentPath !== '/' && currentPath !== '') {
                backToDashboardLink.style.display = 'block';
            }
        });
    </script>
</body>
</html>
