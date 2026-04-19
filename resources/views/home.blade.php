@php
    $assetDir = 'images/Pantalla de inicio';
    $heroImage = asset('images/login1.png');
    $logoImage = file_exists(public_path('images/logo.png'))
        ? asset('images/logo.png')
        : null;

    $loginUrl = route('login');

    $categorias = [
        [
            'nombre' => 'Moda y accesorios',
            'desc' => 'Ropa, calzado y complementos para cada estilo y ocasión.',
            'img' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Tecnología y electrónica',
            'desc' => 'Celulares, computadoras, audio y los últimos gadgets.',
            'img' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Electrodomésticos',
            'desc' => 'Línea blanca y equipos para tu hogar y cocina.',
            'img' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Hogar y decoración',
            'desc' => 'Muebles, iluminación y detalles para ambientar tus espacios.',
            'img' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Belleza y cuidado personal',
            'desc' => 'Cosmética, perfumería y bienestar en un solo lugar.',
            'img' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Deportes y entretenimiento',
            'desc' => 'Artículos deportivos y todo para el ocio activo.',
            'img' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Niños y bebés',
            'desc' => 'Juguetes, ropa infantil y lo esencial para los más pequeños.',
            'img' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Comida y restaurantes',
            'desc' => 'Sabores, cafeterías y opciones para comer en el mall.',
            'img' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=600&fit=crop&q=80',
        ],
        [
            'nombre' => 'Servicios',
            'desc' => 'Bancos, courier, estética y otros servicios prácticos.',
            'img' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&h=600&fit=crop&q=80',
        ],
    ];

    // Ubicación proporcionada (Google Maps)
    $mapLat = '-16.4931255808863';
    $mapLng = '-68.14431498477441';
    $mapDireccion = 'Av. Perú 501, La Paz, Bolivia';
    $mapEmbedUrl = 'https://maps.google.com/maps?q=' . $mapLat . ',' . $mapLng . '&hl=es&z=18&output=embed';
    $mapGoogleUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($mapLat . ',' . $mapLng);
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mall Gran Vía Online — Explora tiendas, productos y servicios en un solo lugar.">
    <title>Mall Gran Vía — Online</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:600,700,800|figtree:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="landing-page">
    {{-- Menú lateral (hamburguesa) --}}
    <div class="offcanvas offcanvas-start landing-offcanvas" tabindex="-1" id="menuLateral" aria-labelledby="menuLateralLabel" data-bs-backdrop="true" data-bs-scroll="false">
        <div class="offcanvas-header border-bottom" style="border-color: rgba(55, 53, 175, 0.15) !important;">
            <h2 class="offcanvas-title h5" id="menuLateralLabel" style="color: #3735af;">Menú</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar" style="color: #3735af;"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column gap-4">
            <nav class="d-flex flex-column gap-3">
                <a href="#inicio" class="text-decoration-none fw-600" style="color: #3735af;" data-bs-dismiss="offcanvas">Inicio</a>
                <a href="#plataforma" class="text-decoration-none fw-600" style="color: #3735af;" data-bs-dismiss="offcanvas">¿Qué puedes hacer?</a>
                <a href="#categorias" class="text-decoration-none fw-600" style="color: #3735af;" data-bs-dismiss="offcanvas">Categorías</a>
                <a href="#ubicacion" class="text-decoration-none fw-600" style="color: #3735af;" data-bs-dismiss="offcanvas">Ubicación</a>
            </nav>
            <a href="{{ $loginUrl }}" class="btn btn-lg rounded-pill fw-bold landing-offcanvas-auth">
                <i class="bi bi-person-plus me-2 fs-5"></i>Identificarse / Registrarse
            </a>
        </div>
    </div>

    {{-- Cabecera --}}
    <header class="landing-header landing-user-header">
        <div class="container-fluid landing-shell d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2 gap-md-3 min-w-0">
                <button class="btn btn-link text-decoration-none p-0 landing-icon-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral" aria-controls="menuLateral" aria-label="Abrir menú">
                    <img src="{{ asset('images/menu.png') }}" alt="Menú" class="landing-menu-icon">
                </button>
                @if ($logoImage)
                    <img src="{{ $logoImage }}" alt="Mall Gran Vía" class="landing-logo-img" width="56" height="56">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Mall Gran Vía" class="landing-logo-img" width="56" height="56">
                @endif
                <span class="landing-brand text-truncate">MALL GRAN VÍA - ONLINE</span>
            </div>
            <div class="d-flex align-items-center gap-3 flex-shrink-0 landing-user-panel">
                <img src="{{ asset('images/sinfoto.png') }}" alt="Usuario" class="landing-user-avatar-img">
                <a href="{{ $loginUrl }}" class="text-decoration-none landing-user-link">
                    <div class="landing-user-label">Registrarse / Identificarse</div>
                </a>
            </div>
        </div>
    </header>

    <main id="inicio">
        {{-- Hero --}}
        <section class="landing-hero" style="--hero-bg: url('{{ $heroImage }}');">
            <div class="landing-hero-overlay"></div>
            <div class="landing-hero-body">
                <div class="container-fluid landing-shell text-center landing-hero-content">
                    <h1 class="landing-hero-title mx-auto">DESCUBRE TODO LO QUE OFRECE EL MALL GRAN VÍA EN UN SOLO LUGAR</h1>
                    <p class="landing-hero-sub mx-auto mt-3 mb-4">EXPLORA TIENDAS, ENCUENTRA PRODUCTOS Y RESERVA DESDE CASA.</p>
                    <a href="{{ $loginUrl }}" class="btn landing-cta-hero btn-lg rounded-pill px-4 fw-bold">
                        Identifícate para explorar
                    </a>
                </div>
            </div>
            <div class="landing-wave" aria-hidden="true">
                <svg viewBox="0 0 1440 220" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#09b7b1" d="M0,130 C240,170 480,90 720,120 C960,150 1200,90 1440,120 L1440,220 L0,220 Z"/>
                    <path fill="#6564bb" opacity="0.85" d="M0,150 C220,110 440,190 720,170 C1000,150 1180,90 1440,130 L1440,220 L0,220 Z"/>
                    <path fill="#c15bbc" opacity="0.9" d="M0,170 C260,140 520,220 720,180 C920,140 1180,100 1440,140 L1440,220 L0,220 Z"/>
                </svg>
            </div>
        </section>

        {{-- Qué puedes hacer --}}
        <section id="plataforma" class="landing-teal-section py-5">
            <div class="container-fluid landing-shell">
                <div class="text-center mb-4">
                    <span class="landing-pill-title">¿QUÉ PUEDES HACER EN NUESTRA PLATAFORMA?</span>
                </div>
                <div class="row g-4 g-md-4 justify-content-center landing-features">
                    <div class="col-6 col-lg-3">
                        <div class="landing-feature-card h-100" data-tooltip="Recorre locales, horarios y novedades de cada tienda del mall.">
                            <i class="bi bi-bag-heart landing-feature-icon mb-2"></i>
                            <span>Explorar tiendas</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="landing-feature-card h-100" data-tooltip="Apartá productos y coordiná retiro según disponibilidad de la tienda.">
                            <i class="bi bi-hand-index-thumb landing-feature-icon mb-2"></i>
                            <span>Reservar productos</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="landing-feature-card h-100" data-tooltip="Filtros por categoría, precio y promociones para encontrar rápido.">
                            <i class="bi bi-search landing-feature-icon mb-2"></i>
                            <span>Buscar productos</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="landing-feature-card h-100" data-tooltip="Datos de contacto y mensajes hacia las tiendas que elijas.">
                            <i class="bi bi-chat-dots landing-feature-icon mb-2"></i>
                            <span>Contactar tiendas</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Carrusel categorías --}}
        <section id="categorias" class="landing-teal-section pb-5 pt-0">
            <div class="container-fluid landing-shell">
                <div class="landing-pill-title mb-4">
                    EN MALL GRAN VÍA PODRÁS ENCONTRAR COSAS COMO…
                </div>
                <div>
                    <div class="landing-carousel-track-wrap">
                        <div class="landing-carousel-track" id="categoryCarousel">
                            @foreach ($categorias as $index => $cat)
                                <article class="landing-cat-card" tabindex="0">
                                    <div class="landing-cat-img-wrap">
                                        <img src="{{ $cat['img'] }}" alt="{{ $cat['nombre'] }}" class="landing-cat-img" loading="lazy" width="280" height="280">
                                        <div class="landing-cat-hover">
                                            <p class="mb-0 small">{{ $cat['desc'] }}</p>
                                        </div>
                                    </div>
                                    <h3 class="landing-cat-name">{{ $cat['nombre'] }}</h3>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <div class="landing-carousel-controls">
                        <button type="button" id="catPrev" aria-label="Anterior">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" id="catNext" aria-label="Siguiente">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <p class="text-center landing-much-more mt-4 mb-0">Y MUCHO MÁS!!</p>
            </div>
        </section>

        {{-- Mapa --}}
        <section id="ubicacion" class="landing-teal-section pb-5">
            <div class="container-fluid landing-shell">
                <div class="landing-pill-title mb-3">
                    ¿QUIERES VISITARNOS? ¡ANÍMATE Y VEN A VER TODO LO QUE TENEMOS PREPARADO PARA TI!
                </div>
                <div class="landing-map-container">
                    <div class="landing-map-wrap">
                        <iframe
                            title="Ubicación Mall Gran Vía — La Paz"
                            src="{{ $mapEmbedUrl }}"
                            class="landing-map-iframe"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <a href="{{ $mapGoogleUrl }}" target="_blank" rel="noopener noreferrer" class="landing-location-box text-decoration-none text-white">
                        <p class="mb-1 fw-bold">UBICACIÓN: MALL GRAN VÍA — LA PAZ, BOLIVIA</p>
                        <p class="mb-1 small">{{ $mapDireccion }}</p>
                        <p class="mb-0">HORARIO: LUNES A SÁBADO 10:00 — 21:00</p>
                        <span class="location-hint d-block mt-2">Clic para ver en Google Maps</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- CTA registro --}}
        <section class="landing-teal-section pb-5">
            <div class="container-fluid landing-shell text-center">
                <div class="landing-register-banner mx-auto mb-4">
                    ¿AÚN NO TIENES UNA CUENTA? REGÍSTRATE AHORA PARA PODER VER TODO LO QUE OFRECE EL MALL GRAN VÍA, LO QUE QUIERES, SIEMPRE.
                </div>
                <a href="{{ $loginUrl }}" class="btn landing-cta-secondary btn-lg rounded-pill px-5 fw-bold">
                    Registrarse
                </a>
            </div>
        </section>
    </main>

    <footer class="landing-footer py-4 py-md-5">
        <div class="container-fluid landing-shell">
            <div class="row g-4 align-items-start">
                <div class="col-md-5">
                    <p class="landing-footer-lead mb-0">¿Quieres saber más de nosotros? ¡Síguenos en nuestras redes sociales!</p>
                </div>
                <div class="col-md-7">
                    <ul class="list-unstyled row row-cols-1 row-cols-sm-2 g-2 small mb-0 landing-social-list">
                        <li><i class="bi bi-facebook me-2"></i><strong>Facebook:</strong> <span class="text-secondary">+123-456-7890</span> <span class="text-muted">(próximamente)</span></li>
                        <li><i class="bi bi-instagram me-2"></i><strong>Instagram:</strong> <span class="text-secondary">+123-456-7890</span> <span class="text-muted">(próximamente)</span></li>
                        <li><i class="bi bi-whatsapp me-2"></i><strong>WhatsApp:</strong> <span class="text-secondary">+123-456-7890</span> <span class="text-muted">(próximamente)</span></li>
                        <li><i class="bi bi-envelope me-2"></i><strong>E-mail:</strong> <a href="mailto:hello@reallygreatsite.com">hello@reallygreatsite.com</a></li>
                        <li><i class="bi bi-tiktok me-2"></i><strong>TikTok:</strong> <span class="text-secondary">hello@reallygreatsite.com</span> <span class="text-muted">(próximamente)</span></li>
                    </ul>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill disabled" tabindex="-1" aria-disabled="true">Facebook</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill disabled" tabindex="-1" aria-disabled="true">Instagram</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill disabled" tabindex="-1" aria-disabled="true">WhatsApp</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill disabled" tabindex="-1" aria-disabled="true">TikTok</a>
                    </div>
                </div>
            </div>
            <p class="text-center small text-muted mt-4 mb-0">&copy; {{ date('Y') }} Mall Gran Vía — Online. Proyecto académico.</p>
        </div>
    </footer>
    <script>
        const carouselTrack = document.getElementById('categoryCarousel');
        const btnPrev = document.getElementById('catPrev');
        const btnNext = document.getElementById('catNext');

        if (carouselTrack && btnPrev && btnNext) {
            const cardWidth = carouselTrack.querySelector('.landing-cat-card')?.offsetWidth || 260;
            btnPrev.addEventListener('click', () => {
                carouselTrack.scrollBy({ left: -(cardWidth + 22), behavior: 'smooth' });
            });
            btnNext.addEventListener('click', () => {
                carouselTrack.scrollBy({ left: cardWidth + 22, behavior: 'smooth' });
            });
        }

        const offcanvasMenu = document.getElementById('menuLateral');
        const offcanvasLinks = Array.from(offcanvasMenu.querySelectorAll('a[href^="#"]'));
        const closeOffcanvas = () => {
            if (window.bootstrap && offcanvasMenu) {
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasMenu) || new bootstrap.Offcanvas(offcanvasMenu);
                bsOffcanvas.hide();
            }
        };

        offcanvasLinks.forEach((link) => {
            if (!link.href) {
                return;
            }

            link.addEventListener('click', (event) => {
                const href = link.getAttribute('href') || '';
                if (href.startsWith('#')) {
                    const target = document.querySelector(href);
                    if (target) {
                        event.preventDefault();
                        const headerHeight = document.querySelector('.landing-header')?.offsetHeight || 100;
                        const top = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 12;
                        window.scrollTo({ top, behavior: 'smooth' });
                    }
                }
                closeOffcanvas();
            });
        });

        const loginBtn = offcanvasMenu.querySelector('.landing-offcanvas-auth');
        if (loginBtn) {
            loginBtn.addEventListener('click', (e) => {
                e.preventDefault();
                closeOffcanvas();
                setTimeout(() => {
                    window.location.href = loginBtn.href;
                }, 300);
            });
        }
    </script>
</body>
</html>
