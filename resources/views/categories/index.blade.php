@php
    $categoryCarouselSlides = [
        [
            'title' => 'Explora por Categorías',
            'text' => 'Encuentra los productos y servicios que necesitas navegando por nuestras categorías principales.',
            'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=600&fit=crop&q=80'
        ],
        [
            'title' => 'Busca lo que necesitas',
            'text' => 'Organiza tu búsqueda por categorías y subcategorías para encontrar exactamente lo que buscas.',
            'image' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1200&h=600&fit=crop&q=80'
        ],
        [
            'title' => 'Descubre nuevas tiendas',
            'text' => 'Conoce las tiendas disponibles en cada categoría y sus mejores productos destacados.',
            'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200&h=600&fit=crop&q=80'
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todas las Categorías - Mall Gran Vía</title>
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
        .hero-carousel .carousel-item img { object-fit: cover; width: 100%; height: 100%; filter: brightness(0.56); cursor: pointer; }
        .hero-carousel .carousel-caption { position: absolute; top: 52%; left: 6%; transform: translateY(-52%); max-width: 520px; text-align: left; padding-bottom: 20px; }
        .hero-carousel .carousel-caption h1 { font-size: clamp(2.2rem, 3vw, 3.4rem); line-height: 1.05; font-weight: 800; margin-bottom: 14px; }
        .hero-carousel .carousel-caption p { font-size: 1rem; margin-bottom: 18px; max-width: 420px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 56px; height: 56px; background: rgba(0,0,0,0.5); border-radius: 50%; top: auto; bottom: 22px; }
        .hero-carousel .carousel-control-prev, .hero-carousel .carousel-control-next { width: 56px; height: 56px; background: rgba(0,0,0,0.4); border-radius: 50%; top: auto; bottom: 18px; }
        .hero-carousel .carousel-indicators [data-bs-target] { background-color: rgba(255,255,255,0.9); }
        
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
        
        .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; }
        .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 18px; }
        .footer-app a { color: #d2d4ff; text-decoration: none; }
        .footer-app a:hover { color: #fff; }
        
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
        .filter-success-message { position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 14px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-weight: 600; z-index: 9999; animation: slideDown 0.3s ease-out, slideUp 0.3s ease-out 2.7s; }
        @keyframes slideDown { from { transform: translateX(-50%) translateY(-20px); opacity: 0; } to { transform: translateX(-50%) translateY(0); opacity: 1; } }
        @keyframes slideUp { from { transform: translateX(-50%) translateY(0); opacity: 1; } to { transform: translateX(-50%) translateY(-20px); opacity: 0; } }
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
                <li><a href="{{ route('dashboard') }}" class="d-block py-2"><img src="{{ asset('images/home_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Volver al dashboard</a></li>
                <li><a href="{{ route('dashboard') }}" class="d-block py-2"><img src="{{ asset('images/superofertas_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">SuperOfertas</a></li>
                <li><a href="{{ route('dashboard') }}" class="d-block py-2"><img src="{{ asset('images/tienda_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Ver tiendas</a></li>
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
                    <label for="priceMin" style="color: #3735af; display: block; font-weight: 700; margin-bottom: 10px;">Precio mínimo</label>
                    <input type="number" id="priceMin" placeholder="Desde" class="form-control" min="0" max="999999" maxlength="7" style="width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff;" />
                </div>
                <div class="filter-field">
                    <label for="priceMax" style="color: #3735af; display: block; font-weight: 700; margin-bottom: 10px;">Precio máximo</label>
                    <input type="number" id="priceMax" placeholder="Hasta" class="form-control" min="0" max="999999" maxlength="7" style="width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff;" />
                </div>
                <div class="filter-field">
                    <label for="storeFilter" style="color: #3735af; display: block; font-weight: 700; margin-bottom: 10px;">Tienda específica</label>
                    <input type="text" id="storeFilter" list="storesList" placeholder="Ej: Moda Express" class="form-control" autocomplete="off" style="width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff;" />
                    <datalist id="storesList">
                        @foreach ($availableStores as $storeName)
                            <option value="{{ $storeName }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="filter-field">
                    <label class="form-label fw-bold mb-3" style="color: #3735af; display: block; font-weight: 700; margin-bottom: 10px;">Mostrar solo resultados con ofertas</label>
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
        <!-- Carrusel de categorías -->
        <section class="hero-carousel mb-5">
            <div id="heroSlides" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6500" data-bs-pause="hover">
                <div class="carousel-indicators">
                    @foreach ($categoryCarouselSlides as $index => $slide)
                        <button type="button" data-bs-target="#heroSlides" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner rounded-4 overflow-hidden shadow-lg">
                    @foreach ($categoryCarouselSlides as $index => $slide)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ $slide['image'] }}" class="d-block w-100" alt="{{ $slide['title'] }}">
                            <div class="carousel-caption text-start">
                                <h1>{{ $slide['title'] }}</h1>
                                <p>{{ $slide['text'] }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#categorias" class="btn btn-light btn-lg rounded-pill px-4">Ver categorías</a>
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

        <!-- Sección de categorías -->
        <section id="categorias" class="mb-5">
            <div class="section-title" style="background: #fff; color: #4c5eff; display: inline-block; padding: 10px 24px; border-radius: 999px;">Todas las Categorías</div>
            <div class="section-subtitle" style="color: #fff; margin-bottom: 24px;">Explora todas nuestras categorías de productos y servicios.</div>
            
            <div class="categories-grid">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.subcategorias', ['id' => $category->id]) }}" class="promo-card">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}">
                        <div class="category-title">{{ $category->name }}</div>
                        <div class="category-stats">
                            <div class="stat-item">
                                <i class="bi bi-bag"></i>
                                @php
                                    $isFoodCategory = stripos($category->name, 'comida') !== false || stripos($category->name, 'restaurante') !== false;
                                    $isServiceCategory = stripos($category->name, 'servicio') !== false;
                                @endphp
                                <span>
                                    @if($isFoodCategory)
                                        {{ $categoryStats[$category->id]['products_count'] ?? 0 }} comida
                                    @elseif($isServiceCategory)
                                        {{ $categoryStats[$category->id]['products_count'] ?? 0 }} servicios
                                    @else
                                        {{ $categoryStats[$category->id]['products_count'] ?? 0 }} productos
                                    @endif
                                </span>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-shop"></i>
                                <span>{{ $categoryStats[$category->id]['stores_count'] ?? 0 }} tiendas</span>
                            </div>
                        </div>
                    </a>
                @endforeach
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
        // Hacer que al clickear la imagen del carrusel, cambie al siguiente slide
        document.querySelectorAll('.hero-carousel .carousel-item img').forEach(img => {
            img.addEventListener('click', function() {
                const carousel = bootstrap.Carousel.getOrCreateInstance('#heroSlides');
                carousel.next();
            });
        });
    </script>
    <script>
        const availableStores = @json($availableStores);
        const priceMinInput = document.getElementById('priceMin');
        const priceMaxInput = document.getElementById('priceMax');
        const storeFilterInput = document.getElementById('storeFilter');
        const offerOnlySwitch = document.getElementById('offerOnly');
        const applyFiltersBtn = document.getElementById('applyFiltersBtn');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
        const filterError = document.getElementById('filterError');
        const hiddenPriceMin = document.getElementById('hiddenPriceMin');
        const hiddenPriceMax = document.getElementById('hiddenPriceMax');
        const hiddenStoreFilter = document.getElementById('hiddenStoreFilter');
        const hiddenOfferOnly = document.getElementById('hiddenOfferOnly');
        
        const filterOffcanvas = document.getElementById('filterOffcanvas');
        let filtersAppliedFlag = false;
        
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
        
        filterOffcanvas.addEventListener('hidden.bs.offcanvas', () => {
            // Si no se presionó "Aplicar", limpiar automáticamente
            if (!filtersAppliedFlag) {
                priceMinInput.value = '';
                priceMaxInput.value = '';
                storeFilterInput.value = '';
                offerOnlySwitch.checked = false;
                clearError();
            }
            filtersAppliedFlag = false; // Resetear el flag
        });
        
        const showSuccessMessage = (message = 'Filtros aplicados con éxito') => {
            const existingMessage = document.querySelector('.filter-success-message');
            if (existingMessage) existingMessage.remove();
            
            const successMsg = document.createElement('div');
            successMsg.className = 'filter-success-message';
            successMsg.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
            document.body.appendChild(successMsg);
            
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

            if (storeValue !== '' && !availableStores.includes(storeValue)) {
                errors.push(`La tienda "${storeValue}" no está registrada en nuestro sistema. Verifica el nombre e intenta de nuevo con una tienda disponible.`);
            }

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

        priceMaxInput.addEventListener('change', validateFilters);
        storeFilterInput.addEventListener('change', validateFilters);

        applyFiltersBtn.addEventListener('click', () => {
            if (validateFilters()) {
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
                showSuccessMessage('Filtros aplicados con éxito');
                
                const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                if (offcanvas) offcanvas.hide();
            }
        });

        clearFiltersBtn.addEventListener('click', () => {
            clearError();
            priceMinInput.value = '';
            priceMaxInput.value = '';
            storeFilterInput.value = '';
            offerOnlySwitch.checked = false;
            
            hiddenPriceMin.value = '';
            hiddenPriceMax.value = '';
            hiddenStoreFilter.value = '';
            hiddenOfferOnly.value = '';
            
            localStorage.removeItem('searchFilters');
            
            filtersAppliedFlag = true; // Marcar que se aplicaron cambios (limpios)
            showSuccessMessage('Filtros descartados');
            
            setTimeout(() => {
                const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                if (offcanvas) offcanvas.hide();
            }, 500);
        });

        // Evitar que se ingrese cero al inicio del número en campos de precio
        priceMinInput.addEventListener('input', function() {
            if (this.value.length > 1 && this.value.charAt(0) === '0') {
                this.value = this.value.substring(1);
            }
            if (this.value.length > 7) {
                this.value = this.value.substring(0, 7);
            }
        });

        priceMaxInput.addEventListener('input', function() {
            if (this.value.length > 1 && this.value.charAt(0) === '0') {
                this.value = this.value.substring(1);
            }
            if (this.value.length > 7) {
                this.value = this.value.substring(0, 7);
            }
        });

        // Restaurar filtros al cargar la página
        restoreSavedFilters();

        // Hacer que al clickear la imagen del carrusel, cambie al siguiente slide
        document.querySelectorAll('.hero-carousel .carousel-item img').forEach(img => {
            img.addEventListener('click', function() {
                const carousel = bootstrap.Carousel.getOrCreateInstance('#heroSlides');
                carousel.next();
            });
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
