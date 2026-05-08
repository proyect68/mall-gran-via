<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - Mall Gran Vía')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { font-family: 'Montserrat', sans-serif !important; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            background: #f0f2f5;
            color: #1f1f4e;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1e1e3f 0%, #2a2b5e 100%);
            color: #c8c9f0;
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }

        .sidebar-brand-text {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-brand-text small {
            font-size: 0.7rem;
            font-weight: 400;
            color: #9a9bc4;
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }

        .sidebar-section-label {
            padding: 12px 20px 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6c6e9a;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #b0b2d6;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }

        .sidebar-link.active {
            color: #fff;
            background: rgba(55, 53, 175, 0.35);
            border-left-color: #7c7aff;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
        }

        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.72rem;
            color: #9a9bc4;
            text-transform: capitalize;
        }

        /* ── Top bar ── */
        .admin-topbar {
            margin-left: 260px;
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e4e6ef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e1e3f;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: #fff;
        }

        /* ── Main content ── */
        .admin-main {
            margin-left: 260px;
            padding: 28px;
            min-height: calc(100vh - 64px);
        }

        /* ── Mobile toggle ── */
        .sidebar-toggle {
            display: none;
            background: #1e1e3f;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .sidebar-overlay.active {
                display: block;
            }
            .admin-topbar,
            .admin-main {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: inline-flex;
            }
        }

        /* ── Alert styling ── */
        .admin-alert {
            border-radius: 12px;
            font-weight: 600;
            border: none;
            padding: 14px 20px;
        }
    </style>

    @yield('styles')
</head>

<body>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Mall Gran Vía" onerror="this.style.display='none'">
            <div class="sidebar-brand-text">
                Mall Gran Vía
                <small>Panel de Administración</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Principal</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>

            <div class="sidebar-section-label">Gestión</div>

            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                Usuarios
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                Productos
            </a>

            <a href="{{ route('admin.stores.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                Tiendas
            </a>
        </nav>

        @auth
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                <div class="sidebar-user-role">{{ Auth::user()->role }}</div>
            </div>
        </div>
        @endauth
    </aside>

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Top bar --}}
    <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-actions">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    {{-- Main content --}}
    <main class="admin-main">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success admin-alert mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger admin-alert mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if (toggle) {
            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function () {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });
        }

        // Auto-dismiss alerts
        document.querySelectorAll('.admin-alert').forEach(function (alert) {
            setTimeout(function () {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function () { alert.remove(); }, 500);
            }, 4000);
        });
    </script>

    @yield('scripts')
</body>
</html>
