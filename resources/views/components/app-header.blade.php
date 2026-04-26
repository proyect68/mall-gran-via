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
                            <!-- Hidden inputs para mantener filtros al hacer nueva búsqueda -->
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

                    {{-- Volver al dashboard SOLO si no estás en él --}}
                    @if (!request()->is('home') && !request()->is('dashboard'))
                    <li>
                        <a href="{{ route('dashboard') }}" class="dropdown-item" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                            <i class="bi bi-house" style="margin-right: 10px;"></i> Volver al Dashboard
                        </a>
                    </li>
                    @endif

                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                            <i class="bi bi-person-circle" style="margin-right: 10px;"></i> Mi Perfil
                        </a>
                    </li>

                    <li><hr class="dropdown-divider" style="margin: 6px 0; border-color: rgba(55,53,175,0.2);"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #d32f2f; padding: 12px 16px; border-radius: 12px; margin: 6px; width: 100%; text-align: left; border: none; background: transparent;">
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
<!--
<header class="app-header shadow-sm" style="background: #cac9ff; color: #fff; padding: 18px 0; position: relative; z-index: 1030;">
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
                        <input type="text" name="q" class="search-box" placeholder="Buscar productos, tiendas o servicios..." aria-label="Buscar" value="{{ request('q') }}" style="background: #fff; border-radius: 999px; padding: 10px 18px; padding-right: 48px; border: none; width: 100%;" />
                        <input type="hidden" id="hiddenPriceMin" name="priceMin" />
                        <input type="hidden" id="hiddenPriceMax" name="priceMax" />
                        <input type="hidden" id="hiddenStoreFilter" name="storeFilter" />
                        <input type="hidden" id="hiddenOfferOnly" name="offerOnly" />
                        <button type="submit" class="search-submit-btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent !important; border: none !important; padding: 8px !important; color: #3735af !important; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-white border rounded-circle p-2" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas" title="Filtros de búsqueda">
                        <img src="{{ asset('images/filtros.png') }}" alt="Filtros" width="24" />
                    </button>
                </form>
            </div>
            <div class="dropdown">
                <button class="btn btn-link user-chip dropdown-toggle" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(255,255,255,0.16); border-radius: 999px; padding: 8px 16px; display: inline-flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; border: none; cursor: pointer;">
                    <img src="{{ asset('images/sinfoto.png') }}" alt="Perfil" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.35);" />
                    <div class="text-start">
                        <div style="font-size:.95rem;">¡Bienvenido!</div>
                        <div style="font-size:.85rem; opacity:.85;">@auth {{ Auth::user()->name }} @else Invitado @endauth</div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn" style="background: #cac9ff; border: 1px solid rgba(55,53,175,0.2); border-radius: 16px; min-width: 200px;">

                @auth

                    {{-- Volver al dashboard SOLO si no estás en él --}}
                    @if (!request()->is('home') && !request()->is('dashboard'))
                        <li>
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="bi bi-house" style="margin-right: 10px;"></i> Volver al Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- Perfil --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                            <i class="bi bi-person-circle" style="margin-right: 10px;"></i> Mi Perfil
                        </a>
                    </li>

                    <li><hr class="dropdown-divider" style="margin: 6px 0; border-color: rgba(55,53,175,0.2);"></li>

                    {{-- Logout --}}
                    <li>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #d32f2f; padding: 12px 16px; border-radius: 12px; margin: 6px; width: 100%; text-align: left; border: none; background: transparent; cursor: pointer;">
                                <i class="bi bi-box-arrow-right" style="margin-right: 10px;"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>

                @else

                    {{-- Login --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('login') }}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                            <i class="bi bi-box-arrow-in-right" style="margin-right: 10px;"></i> Iniciar Sesión
                        </a>
                    </li>

                    {{-- Register --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('register') }}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
                            <i class="bi bi-person-plus" style="margin-right: 10px;"></i> Registrarse
                        </a>
                    </li>

                @endauth

            </ul>
                <---
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn" style="background: #cac9ff; border: 1px solid rgba(55,53,175,0.2); border-radius: 16px; min-width: 200px;">
                @if (!request()->is('home') && !request()->is('dashboard'))
                    <li>
                        <a href="{{ route('dashboard') }}" class="dropdown-item">
                            Volver al Dashboard
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                        Mi Perfil
                    </a>
                </li>    
                @auth
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show')}}" style="color: #3735af; padding: 12px 16px; border-radius: 12px; margin: 6px;">
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
                ---
            </div>
        </div>
    </div>
</header>
-->