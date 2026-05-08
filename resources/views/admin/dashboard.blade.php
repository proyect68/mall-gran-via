@extends('layouts.admin')

@section('title', 'Panel de Administración - Mall Gran Vía')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #eef0f5;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        color: inherit;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        flex-shrink: 0;
    }

    .stat-icon.users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-icon.products { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .stat-icon.stores { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }

    .stat-info h3 {
        font-size: 0.85rem;
        color: #8c8ea0;
        margin: 0 0 4px 0;
        font-weight: 600;
    }

    .stat-info .total {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1e1e3f;
        margin: 0;
        line-height: 1;
    }

    .stat-info .active-count {
        font-size: 0.82rem;
        color: #28a745;
        margin: 6px 0 0 0;
        font-weight: 600;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #1e1e3f 0%, #3735af 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #fff;
        margin-bottom: 28px;
    }

    .welcome-banner h2 {
        font-weight: 800;
        font-size: 1.4rem;
        margin: 0 0 6px 0;
    }

    .welcome-banner p {
        margin: 0;
        opacity: 0.8;
        font-size: 0.92rem;
    }
</style>
@endsection

@section('content')
    <div class="welcome-banner">
        <h2><i class="bi bi-shield-check me-2"></i>Bienvenido, {{ Auth::user()->name }}</h2>
        <p>Gestiona usuarios, productos y tiendas del Mall Gran Vía desde este panel.</p>
    </div>

    <div class="stats-grid">
        <a href="{{ route('admin.users.index') }}" class="stat-card">
            <div class="stat-icon users"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <h3>Usuarios Totales</h3>
                <p class="total">{{ $usersCount }}</p>
                <p class="active-count"><i class="bi bi-check-circle-fill me-1"></i>{{ $activeUsers }} Activos</p>
            </div>
        </a>

        <a href="{{ route('admin.products.index') }}" class="stat-card">
            <div class="stat-icon products"><i class="bi bi-box-seam-fill"></i></div>
            <div class="stat-info">
                <h3>Productos Totales</h3>
                <p class="total">{{ $productsCount }}</p>
                <p class="active-count"><i class="bi bi-check-circle-fill me-1"></i>{{ $activeProducts }} Activos</p>
            </div>
        </a>

        <a href="{{ route('admin.stores.index') }}" class="stat-card">
            <div class="stat-icon stores"><i class="bi bi-shop"></i></div>
            <div class="stat-info">
                <h3>Tiendas Totales</h3>
                <p class="total">{{ $storesCount }}</p>
                <p class="active-count"><i class="bi bi-check-circle-fill me-1"></i>{{ $activeStores }} Activas</p>
            </div>
        </a>
    </div>
@endsection
