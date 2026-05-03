@extends('layouts.app-authenticated')

@section('title', $tienda->nombre)

@section('styles')
<style>
    .store-page { background: #f5f7ff; min-height: calc(100vh - 80px); padding-bottom: 50px; }
    .store-banner-wrap { background: #3735af; overflow: hidden; }
    .store-banner { width: 100%; height: 310px; object-fit: cover; display: block; }
    .store-profile { max-width: 1200px; margin: -58px auto 0; padding: 0 20px; display: flex; gap: 22px; align-items: flex-end; position: relative; z-index: 2; }
    .store-logo { width: 148px; height: 148px; border-radius: 12px; border: 5px solid #fff; object-fit: cover; box-shadow: 0 16px 34px rgba(31,31,78,.18); background: #fff; }
    .store-heading { flex: 1; background: #fff; border-radius: 8px; padding: 18px 20px; box-shadow: 0 16px 34px rgba(31,31,78,.08); }
    .store-name { color: #1f1f4e; font-size: clamp(1.8rem, 3vw, 2.55rem); font-weight: 900; margin: 0 0 4px; }
    .store-followers { color: #6c7190; margin: 0 0 14px; font-weight: 600; }
    .store-summary-row { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; }
    .store-content { max-width: 1200px; margin: 34px auto 0; padding: 0 20px; }
    .store-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; margin-bottom: 18px; }
    .info-card { background: #fff; border: 1px solid #e2e5f3; border-radius: 8px; padding: 20px; box-shadow: 0 12px 28px rgba(55,53,175,.06); }
    .info-card.wide { grid-column: 1 / -1; }
    .info-title { display: flex; align-items: center; gap: 9px; color: #1f1f4e; font-size: 1.05rem; font-weight: 900; margin-bottom: 12px; }
    .info-content { color: #545873; line-height: 1.65; }
    .owner-card { display: flex; align-items: center; gap: 13px; }
    .owner-avatar { width: 58px; height: 58px; border-radius: 50%; object-fit: cover; background: #e8e9fb; }
    .owner-name { color: #1f1f4e; font-weight: 800; }
    .divider { height: 1px; background: #dfe3f2; margin: 32px 0; }
    .section-title { color: #1f1f4e; font-size: 1.7rem; font-weight: 900; margin-bottom: 18px; }
    .products-section { background: transparent !important; padding: 0 !important; }
    .products-section .container-fluid { padding: 0 !important; }
    .result-group { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 18px; }
    .product-card { background: #cac9ff; border-radius: 8px; overflow: hidden; height: 100%; box-shadow: 0 14px 28px rgba(55,53,175,.12); transition: transform .2s ease; }
    .product-card:hover { transform: translateY(-4px); }
    .product-card img { width: 100%; height: 180px; object-fit: cover; display: block; background: #fff; }
    .product-card-body { padding: 14px; }
    .product-card-title { color: #3735af; font-weight: 900; margin-bottom: 7px; }
    .product-card-store { color: #3735af; font-size: .9rem; font-weight: 700; margin-bottom: 10px; cursor: pointer; }
    .product-card-store:hover { text-decoration: underline; }
    .product-card-prices { display: flex; gap: 9px; align-items: baseline; color: #3735af; margin-bottom: 10px; flex-wrap: wrap; }
    .product-card-prices del { color: #7c7f9c; }
    .product-card-offer { display: inline-flex; border-radius: 999px; padding: 6px 10px; color: #fff; background: #e9524c; font-size: .78rem; font-weight: 800; }
    .pagination-container { display: flex; justify-content: center; gap: 8px; margin-top: 24px; flex-wrap: wrap; }
    .pagination-btn { min-width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; border: 0; background: #3735af; color: #fff; font-weight: 800; text-decoration: none; }
    .pagination-btn.active, .pagination-btn.disabled { opacity: .65; pointer-events: none; }
    @media (max-width: 900px) {
        .store-grid { grid-template-columns: 1fr; }
        .store-profile { align-items: center; flex-direction: column; text-align: center; }
        .store-heading { width: 100%; }
        .store-summary-row { justify-content: center; }
    }
</style>
@endsection

@section('content')
@php
    $banner = $tienda->banner_url ?: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1400&h=420&fit=crop&q=80';
    $logo = $tienda->logo_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($tienda->nombre) . '&background=3735af&color=fff&size=240';
    $owner = $tienda->propietario;
    $ownerName = $owner?->name ?: 'Propietario no asignado';
    $location = $tienda->piso_local ?? $tienda->ubicacion ?? 'No disponible';
    $schedule = is_array($tienda->horario) ? implode(', ', $tienda->horario) : ($tienda->horario ?? 'No especificado');
@endphp

<main class="store-page">
    <div class="store-banner-wrap">
        <img src="{{ $banner }}" alt="{{ $tienda->nombre }}" class="store-banner">
    </div>

    <section class="store-profile">
        <img src="{{ $logo }}" alt="{{ $tienda->nombre }}" class="store-logo">
        <div class="store-heading">
            <h1 class="store-name">{{ $tienda->nombre }}</h1>
            <p class="store-followers"><strong>{{ number_format($tienda->seguidores ?? 0) }}</strong> seguidores</p>
            <div class="store-summary-row">
                <x-star-rating :calificacion="$tienda->calificacion" tamano="md" />
                <x-store-status :estado="$tienda->estado" tamano="md" />
            </div>
        </div>
    </section>

    <div class="store-content">
        <div class="store-grid">
            <article class="info-card wide">
                <h2 class="info-title"><i class="bi bi-shop"></i> Sobre la tienda</h2>
                <div class="info-content">{{ $tienda->descripcion ?: 'Esta tienda aun no tiene una descripcion registrada.' }}</div>
            </article>

            <article class="info-card">
                <h2 class="info-title"><i class="bi bi-person-badge-fill"></i> Propietario</h2>
                <div class="owner-card">
                    <img class="owner-avatar" src="https://ui-avatars.com/api/?name={{ urlencode($ownerName) }}&background=09b7b1&color=fff&size=120" alt="{{ $ownerName }}">
                    <div>
                        <div class="owner-name">{{ $ownerName }}</div>
                        <div class="info-content">{{ $owner?->email ?? 'Sin correo registrado' }}</div>
                    </div>
                </div>
            </article>

            <article class="info-card">
                <h2 class="info-title"><i class="bi bi-geo-alt-fill"></i> Localizacion</h2>
                <div class="info-content">{{ $location }}</div>
            </article>

            <article class="info-card">
                <h2 class="info-title"><i class="bi bi-clock-fill"></i> Horario de atencion</h2>
                <div class="info-content">{{ $schedule }}</div>
            </article>

            <article class="info-card wide">
                <h2 class="info-title"><i class="bi bi-tags-fill"></i> Categorias</h2>
                <x-store-categories :tienda="$tienda" />
            </article>

            <article class="info-card wide">
                <h2 class="info-title"><i class="bi bi-chat-dots-fill"></i> Contacto</h2>
                <x-store-contact
                    :facebook="$tienda->facebook"
                    :instagram="$tienda->instagram"
                    :whatsapp="$tienda->whatsapp"
                    :email="$tienda->email"
                    :telefono="$tienda->telefono"
                    :tiktok="$tienda->tiktok"
                />
            </article>
        </div>

        <div class="divider"></div>

        <h2 class="section-title">Productos y servicios</h2>
        <x-products-grid :products="$productos" :title="null" :showDashboardLink="false" />
    </div>
</main>
@endsection
