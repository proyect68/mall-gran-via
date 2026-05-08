@extends('layouts.app-authenticated')

@section('title', 'Panel de Administración - Mall Gran Vía')

@section('styles')
<style>
    .admin-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .admin-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        color: #fff;
    }
    
    .admin-header h1 {
        font-weight: 800;
        font-size: 2rem;
        margin: 0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #fff;
    }
    
    .stat-icon.users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-icon.products { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .stat-icon.stores { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
    
    .stat-info h3 {
        font-size: 1rem;
        color: #6c7190;
        margin: 0 0 5px 0;
        font-weight: 600;
    }
    
    .stat-info p.total {
        font-size: 2rem;
        font-weight: 800;
        color: #3735af;
        margin: 0;
        line-height: 1;
    }
    
    .stat-info p.active {
        font-size: 0.85rem;
        color: #28a745;
        margin: 5px 0 0 0;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <i class="fas fa-shield-alt fa-2x"></i>
        <h1>Panel de Administración</h1>
    </div>

    <div class="stats-grid">
        <a href="{{ route('admin.users.index') }}" class="stat-card">
            <div class="stat-icon users"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h3>Usuarios Totales</h3>
                <p class="total">{{ $usersCount }}</p>
                <p class="active"><i class="fas fa-check-circle"></i> {{ $activeUsers }} Activos</p>
            </div>
        </a>

        <a href="{{ route('admin.products.index') }}" class="stat-card">
            <div class="stat-icon products"><i class="fas fa-box"></i></div>
            <div class="stat-info">
                <h3>Productos Totales</h3>
                <p class="total">{{ $productsCount }}</p>
                <p class="active"><i class="fas fa-check-circle"></i> {{ $activeProducts }} Activos</p>
            </div>
        </a>

        <a href="{{ route('admin.stores.index') }}" class="stat-card">
            <div class="stat-icon stores"><i class="fas fa-store"></i></div>
            <div class="stat-info">
                <h3>Tiendas Totales</h3>
                <p class="total">{{ $storesCount }}</p>
                <p class="active"><i class="fas fa-check-circle"></i> {{ $activeStores }} Activas</p>
            </div>
        </a>
    </div>
</div>
@endsection
