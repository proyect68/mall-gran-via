@extends('layouts.app-authenticated')

@section('title', 'Tiendas')

@section('styles')
<style>
    .stores-page { background: #f5f7ff; min-height: calc(100vh - 80px); padding: 42px 0 58px; }
    .stores-shell { max-width: 1220px; margin: 0 auto; padding: 0 20px; }
    .page-title { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 900; color: #1f1f4e; margin-bottom: 8px; }
    .page-subtitle { color: #6c7190; font-size: 1.05rem; margin-bottom: 10px; }
    .stores-total { color: #3735af; font-weight: 850; margin-bottom: 32px; }
    .store-category-section { margin-bottom: 42px; }
    .store-category-heading { display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid #dfe3f8; }
    .store-category-heading h2 { color: #1f1f4e; font-size: 1.35rem; font-weight: 900; margin: 0; }
    .store-category-heading span { color: #6c7190; font-size: .95rem; font-weight: 750; }
    .empty-state { text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; border: 1px solid #e2e5f3; }
    .empty-state-title { color: #1f1f4e; font-weight: 900; margin-bottom: 8px; }
    .empty-state-text { color: #6c7190; margin: 0; }
</style>
@endsection

@section('content')
<main class="stores-page">
    <div class="stores-shell">
        <h1 class="page-title">Nuestras tiendas</h1>
        <p class="page-subtitle">Descubre todas las tiendas y servicios disponibles en el mall.</p>
        <div class="stores-total">{{ $tiendas->count() }} tiendas registradas</div>

        @if($storesByCategory->count() > 0)
            @foreach($storesByCategory as $categoryName => $stores)
                <section class="store-category-section">
                    <div class="store-category-heading">
                        <h2>{{ $categoryName }}</h2>
                        <span>{{ $stores->count() }} tiendas</span>
                    </div>
                    <x-store-grid :stores="$stores" />
                </section>
            @endforeach
        @else
            <div class="empty-state">
                <h2 class="empty-state-title">Sin tiendas disponibles</h2>
                <p class="empty-state-text">No hay tiendas disponibles en este momento.</p>
            </div>
        @endif
    </div>
</main>
@endsection
