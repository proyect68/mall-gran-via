@props(['store', 'relatedCount' => null])

@php
    $name = data_get($store, 'nombre') ?? data_get($store, 'name') ?? 'Tienda';
    $key = is_object($store) && method_exists($store, 'getKey') ? $store->getKey() : (data_get($store, 'id_tienda') ?? data_get($store, 'id') ?? $name);
    $banner = data_get($store, 'banner_url') ?: asset('images/sinfoto.png');
    $logo = data_get($store, 'logo_url') ?: asset('images/tienda_logo.png');
    $followers = (int) (data_get($store, 'seguidores') ?? 0);
    $rating = data_get($store, 'calificacion');
    $description = data_get($store, 'descripcion');
    $productCount = $relatedCount ?? data_get($store, 'related_products_count') ?? data_get($store, 'productos_count') ?? (is_object($store) && isset($store->productos_count) ? $store->productos_count : 0);
    $estado = data_get($store, 'estado') ?? 'abierto';
@endphp

@once
    <style>
        .store-card-unified { background: #fff; border: 1px solid #e2e5f3; border-radius: 8px; overflow: hidden; box-shadow: 0 14px 30px rgba(55,53,175,.1); transition: transform .2s ease, box-shadow .2s ease; color: #1f1f4e; text-decoration: none; height: 100%; display: flex; flex-direction: column; }
        .store-card-unified:hover { transform: translateY(-4px); box-shadow: 0 18px 38px rgba(55,53,175,.16); color: #1f1f4e; }
        .store-card-unified-banner { width: 100%; height: 128px; object-fit: cover; display: block; background: #f2f4ff; }
        .store-card-unified-body { padding: 14px 15px 16px; display: flex; flex-direction: column; gap: 11px; flex: 1; }
        .store-card-unified-head { display: flex; gap: 12px; align-items: flex-start; }
        .store-card-unified-logo { width: 58px; height: 58px; border-radius: 8px; border: 3px solid #fff; object-fit: cover; background: #fff; box-shadow: 0 8px 18px rgba(31,31,78,.13); margin-top: -30px; flex: 0 0 auto; }
        .store-card-unified-title { margin: 0 0 3px; color: #1f1f4e; font-size: 1.05rem; font-weight: 900; line-height: 1.2; }
        .store-card-unified-meta { color: #6c7190; font-size: .84rem; font-weight: 650; margin: 0; }
        .store-card-unified-description { color: #545873; font-size: .88rem; line-height: 1.45; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.5em; }
        .store-card-unified-footer { border-top: 1px solid #edf0fa; padding-top: 11px; margin-top: auto; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
        .store-card-unified-products { display: inline-flex; align-items: center; gap: 6px; color: #3735af; font-size: .85rem; font-weight: 850; }
        .store-card-unified-rating { color: #4a4d68; font-size: .86rem; font-weight: 800; }
        .store-card-unified-rating .star { color: #ffbe0b; }
        .store-card-unified-status { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; padding: 5px 9px; font-size: .76rem; font-weight: 850; }
        .store-card-unified-status.open { background: #e7f7ee; color: #1f7a46; }
        .store-card-unified-status.closed { background: #fde9e8; color: #b73535; }
        .store-card-unified-status.disabled { background: #f0f1f5; color: #6c7190; }
    </style>
@endonce

<a href="{{ route('stores.show', $key) }}" class="store-card-unified">
    <img src="{{ $banner }}" alt="{{ $name }}" class="store-card-unified-banner">
    <div class="store-card-unified-body">
        <div class="store-card-unified-head">
            <img src="{{ $logo }}" alt="{{ $name }}" class="store-card-unified-logo">
            <div>
                <h3 class="store-card-unified-title">{{ $name }}</h3>
                <p class="store-card-unified-meta">{{ number_format($followers) }} seguidores</p>
            </div>
        </div>

        @if($description)
            <p class="store-card-unified-description">{{ $description }}</p>
        @endif

        <div class="store-card-unified-footer">
            <span class="store-card-unified-products"><i class="bi bi-box-seam"></i>{{ $productCount }} productos</span>
            @if($rating)
                <span class="store-card-unified-rating"><span class="star">&#9733;</span> {{ number_format((float) $rating, 1) }}</span>
            @endif
            @php
                $state = strtolower((string) $estado);
                $stateClass = in_array($state, ['activa', 'abierto'], true) ? 'open' : ($state === 'cerrado' ? 'closed' : 'disabled');
                $stateLabel = $stateClass === 'open' ? 'Abierto' : ($stateClass === 'closed' ? 'Cerrado' : 'Deshabilitado');
            @endphp
            <span class="store-card-unified-status {{ $stateClass }}">{{ $stateLabel }}</span>
        </div>
    </div>
</a>
