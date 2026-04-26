@php
    use App\Models\Product;
    $availableStores = Product::select('tienda')->distinct()->pluck('tienda')->filter()->values()->toArray();
    $defaultPromoImage = 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=300&h=300&fit=crop&q=80';
@endphp

@extends('layouts.app-authenticated')

@section('title', 'Resultados de búsqueda - Mall Gran Vía')

@section('styles')
    <style>
        * { font-family: 'Montserrat', sans-serif !important; }
        .search-results-header { background: linear-gradient(135deg, #6f62f0 0%, #4c5eff 100%); color: white; padding: 40px 0; margin: 0; width: 100%; font-family: 'Montserrat', sans-serif; }
        .search-results-header h2 { font-weight: 700; margin-bottom: 5px; font-family: 'Montserrat', sans-serif; }
        .search-results-header p { opacity: 0.9; }
        .result-section { margin-bottom: 40px; }
        .result-section h3 { font-weight: 700; color: #3735af; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #cac9ff; }
        section[style*="background: #6564bb"] .result-section h3 { color: #fff; border-bottom-color: rgba(255,255,255,0.2); }
        .result-group { display: grid; grid-template-columns: repeat(7, 1fr); gap: 20px; }
        @media (max-width: 1400px) { .result-group { grid-template-columns: repeat(5, 1fr); } }
        @media (max-width: 1200px) { .result-group { grid-template-columns: repeat(4, 1fr); } }
        @media (max-width: 992px) { .result-group { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .result-group { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .result-group { grid-template-columns: 1fr; } }
        .product-card { background: #cac9ff; border-radius: 22px; overflow: hidden; padding: 0; box-shadow: 0 20px 35px rgba(64,69,148,0.08); transition: transform 0.25s ease; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-8px); }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card-body { padding: 18px; display: flex; flex-direction: column; height: 100%; }
        .product-card-title { font-weight: 700; margin-bottom: 8px; font-size: 1rem; color: #3735af; }
        .product-card-store { color: #3735af; font-size: 0.9rem; margin-bottom: 12px; }
        .product-card-prices { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .product-card-prices strong { font-size: 1.1rem; color: #3735af; font-weight: 700; }
        .product-card-prices del { color: #9ea0c4; font-size: 0.9rem; }
        .product-card-offer { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; align-self: flex-start; }
        .offer-red { background: #e9524c; }
        .offer-blue { background: #2b8fe0; }
        .offer-purple { background: #7d5cff; }
        .no-results { text-align: center; padding: 60px 20px; }
        .no-results i { font-size: 3rem; color: #cac9ff; margin-bottom: 20px; }
        .related-stores-section { margin-bottom: 50px; }
        .related-stores-title { font-weight: 700; color: #3735af; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #cac9ff; }
        .stores-wrapper { position: relative; margin-bottom: 15px; }
        .stores-scroll-btns { position: absolute; top: -50px; right: 0; display: flex; gap: 8px; z-index: 2; }
        .stores-scroll-btns button { width: 34px; height: 34px; border-radius: 50%; border: none; background: rgba(111,98,240,0.15); color: #3735af; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.2s ease; font-weight: 700; pointer-events: auto; }
        .stores-scroll-btns button:hover { background: rgba(111,98,240,0.25); }
        .stores-carousel { display: flex; gap: 16px; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 16px; }
        .stores-carousel::-webkit-scrollbar { height: 8px; }
        .stores-carousel::-webkit-scrollbar-track { background: rgba(111,98,240,0.08); border-radius: 10px; }
        .stores-carousel::-webkit-scrollbar-thumb { background: rgba(111,98,240,0.35); border-radius: 10px; }
        .stores-carousel::-webkit-scrollbar-thumb:hover { background: rgba(111,98,240,0.5); }
        .store-card { flex: 0 0 320px; height: 360px; background: #cac9ff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.25s ease, box-shadow 0.25s ease; display: flex; flex-direction: column; }
        .store-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
        .store-card-image { width: 100%; height: 200px; background: linear-gradient(135deg, #cac9ff 0%, #a8a7d6 100%); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; position: relative; overflow: hidden; flex-shrink: 0; }
        .store-card-image::before { content: '🏪'; font-size: 4rem; opacity: 0.3; }
        .store-card-body { padding: 18px 18px 24px 18px; flex: 1; display: flex; flex-direction: column; }
        .store-card-name { font-weight: 700; margin-bottom: 12px; font-size: 1.05rem; color: #3735af; }
        .store-card-info { font-size: 0.95rem; color: #3735af; margin-bottom: 12px; font-weight: 500; }
        .store-card-status { display: inline-flex; align-items: center; gap: 5px; font-size: 0.78rem; font-weight: 600; padding: 6px 12px; border-radius: 999px; background: #e8f5e9; color: #2e7d32; align-self: flex-start; }
        .store-card-status.closed { background: #ffebee; color: #c62828; }
        .pagination-container { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; margin-bottom: 40px; flex-wrap: wrap; }
        .pagination-btn { background: #3735af; color: #fff; border: 2px solid #3735af; border-radius: 4px; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
        .pagination-btn:hover { background: #2f2a9b; border-color: #2f2a9b; }
        .pagination-btn.active { background: #3735af; color: #fff; border-color: #3735af; }
        .pagination-btn.disabled { opacity: 0.5; cursor: not-allowed; background: #8a88c2; border-color: #8a88c2; }
        .filter-success-message { position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 14px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-weight: 600; z-index: 9999; animation: slideDown 0.3s ease-out, slideUp 0.3s ease-out 2.7s; }
        @keyframes slideDown { from { transform: translateX(-50%) translateY(-20px); opacity: 0; } to { transform: translateX(-50%) translateY(0); opacity: 1; } }
        @keyframes slideUp { from { transform: translateX(-50%) translateY(0); opacity: 1; } to { transform: translateX(-50%) translateY(-20px); opacity: 0; } }
        
        /* Filter Panel Styles - Idéntico al Dashboard */
        .filter-panel { width: 340px; padding: 24px; background: #cac9ff; color: #3735af; }
        .filter-panel .offcanvas-header { background: #cac9ff; color: #3735af; border-bottom: 1px solid rgba(55,53,175,0.2); }
        .filter-panel .offcanvas-body { background: #cac9ff; }
        .filter-field { margin-bottom: 22px; }
        .filter-field label { display: block; font-weight: 700; margin-bottom: 10px; color: #3735af !important; }
        .filter-field input, .filter-field select { width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af !important; background: #ffffff; }
        .filter-field input::placeholder { color: #8f92b7; }
        .filter-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .filter-panel .btn-outline-secondary { color: #3735af; border-color: #3735af; background: transparent; }
        .filter-panel .btn-outline-secondary:hover, .filter-panel .btn-outline-secondary:focus { background: rgba(55,53,175,0.08); }
        .filter-panel .btn-primary { background: #3735af; border-color: #3735af; color: #ffffff; }
        .filter-panel .btn-primary:hover, .filter-panel .btn-primary:focus { background: #2f2a9b; border-color: #2f2a9b; }
        .filter-panel .form-check-input { width: 2.5em; height: 1.45em; background: #ff4d4d; border: 1px solid #ff4d4d; position: relative; }
        .filter-panel .form-check-input:checked { background: #28a745 !important; border-color: #28a745 !important; }
        .filter-panel .form-check-input:focus { box-shadow: 0 0 0 0.25rem rgba(55,53,175,0.18); }
        .filter-panel .form-check-input::before { content: "✗"; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: white; font-size: 0.8em; }
        .filter-panel .form-check-input:checked::before { content: "✓"; }
        .filter-panel .form-check-label { color: #3735af !important; }
        .filter-panel .form-text { font-size: 0.85rem; }
        .filter-panel .text-danger { min-height: 18px; }
    </style>
@endsection

@section('content')
    @php
        // Detectar si hay filtros aplicados en la URL
        $hasFilters = !empty($priceMin) || !empty($priceMax) || !empty($storeFilter) || $offerOnly === 'on';
    @endphp

    @if ($hasFilters)
        <div class="filter-success-message" style="position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 14px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-weight: 600; z-index: 9999;">
            <i class="bi bi-check-circle me-2"></i>Filtros aplicados correctamente
        </div>
        <script>
            // Auto-remover el mensaje después de 3 segundos
            setTimeout(() => {
                const msg = document.querySelector('.filter-success-message');
                if (msg) {
                    msg.style.animation = 'slideUp 0.3s ease-out';
                    setTimeout(() => msg.remove(), 300);
                }
            }, 2700);
        </script>
    @endif

    <main id="inicio">
        <section class="search-results-header">
            <div class="container-fluid px-3 px-md-4">
                @if ($isShowingAll)
                    <h2 style="font-weight:700; color:#fff; margin-bottom:5px;">Todos los resultados</h2>
                    <p style="opacity:0.9; color:#fff; margin:0;"><i class="bi bi-shop me-2"></i>Explora todas las tiendas, productos y servicios disponibles</p>
                @else
                    <h2 style="font-weight:700; color:#fff; margin-bottom:5px;">Resultados de búsqueda</h2>
                    <p style="opacity:0.9; color:#fff; margin:0;"><i class="bi bi-search me-2"></i>"{{ $query }}"</p>
                @endif
            </div>
        </section>
        
        <div class="container-fluid px-3 px-md-4" style="background: #09b7b1; padding-top: 0; padding-bottom: 0; margin-bottom: 0;">
        @if (count($relatedStores) > 0)
            <div class="related-stores-section" style="margin-bottom: 0; padding-top: 20px; padding-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    @if ($isShowingAll)
                        <h3 class="related-stores-title mb-0" style="color:#fff;"><i class="bi bi-shop me-2"></i>Todas las tiendas ({{ count($relatedStores) }})</h3>
                    @else
                        <h3 class="related-stores-title mb-0" style="color:#fff;"><i class="bi bi-shop me-2"></i>Tiendas relacionadas con "{{ $query }}" ({{ count($relatedStores) }})</h3>
                    @endif
                </div>
                <div class="stores-wrapper">
                    @if (count($relatedStores) > 5)
                        <div class="stores-scroll-btns">
                            <button type="button" class="stores-scroll-btn" data-direction="prev">‹</button>
                            <button type="button" class="stores-scroll-btn" data-direction="next">›</button>
                        </div>
                    @endif
                    <div class="stores-carousel" id="storesCarousel">
                        @foreach ($relatedStores as $store)
                            <div class="store-card">
                                <div class="store-card-image"></div>
                                <div class="store-card-body">
                                    <div class="store-card-name">{{ $store['name'] }}</div>
                                    <div class="store-card-info">
                                        Productos relacionados: {{ $store['relatedProductsCount'] }}
                                    </div>
                                    <span class="store-card-status">
                                        <i class="bi bi-circle-fill" style="font-size: 0.6rem;"></i>{{ $store['status'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        </div>

        <section style="background: #6564bb; padding: 30px 0; font-family: 'Montserrat', sans-serif;">
            <div class="container-fluid px-3 px-md-4" style="font-family: 'Montserrat', sans-serif;">
        @if (count($services) > 0)
            <div class="result-section">
                @if ($isShowingAll)
                    <h3 style="color:#fff;"><i class="bi bi-cup-straw"></i> Todos los servicios ({{ count($services) }})</h3>
                @else
                    <h3 style="color:#fff;"><i class="bi bi-cup-straw"></i> Servicios encontrados ({{ count($services) }})</h3>
                @endif
                <div class="result-group">
                    @foreach ($services as $service)
                        <div class="product-card">
                            <img src="{{ $service['image'] ?? $defaultPromoImage }}" alt="{{ $service['name'] }}">
                            <div class="product-card-body">
                                <div class="product-card-title">{{ $service['name'] }}</div>
                                <div class="product-card-store">{{ $service['store'] }}</div>
                                <div class="product-card-prices">
                                    @php
                                        $servicePrice = $service['price'];
                                        if (strpos($servicePrice, 'Bs') === false && is_numeric($servicePrice)) {
                                            $servicePrice = $servicePrice . ' Bs';
                                        }
                                        $discountedServicePrice = null;
                                        if (!empty($service['offer']) && strpos($service['offer'], '%') !== false) {
                                            $discountPercent = (int)str_replace('%', '', $service['offer']);
                                            $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $service['price']);
                                            if ($currentPrice > 0 && $discountPercent > 0) {
                                                $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                                $discountedServicePrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                            }
                                        }
                                    @endphp
                                    <strong>{{ $servicePrice }}</strong>
                                    @if (!empty($discountedServicePrice))
                                        <del>{{ $discountedServicePrice }}</del>
                                    @elseif (!empty($service['old_price']))
                                        <del>@php
                                            $serviceFallbackPrice = $service['old_price'];
                                            if (strpos($serviceFallbackPrice, 'Bs') === false && is_numeric(str_replace(['.', ','], '', $serviceFallbackPrice))) {
                                                $serviceFallbackPrice .= ' Bs';
                                            }
                                        @endphp {{ $serviceFallbackPrice }}</del>
                                    @endif
                                </div>
                                @if (!empty($service['offer']))
                                    <span class="product-card-offer {{ $service['color'] ?? 'offer-red' }}">{{ $service['offer'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @php
                    $filterParams = '';
                    if ($priceMin) $filterParams .= '&priceMin=' . urlencode($priceMin);
                    if ($priceMax) $filterParams .= '&priceMax=' . urlencode($priceMax);
                    if ($storeFilter) $filterParams .= '&storeFilter=' . urlencode($storeFilter);
                    if ($offerOnly) $filterParams .= '&offerOnly=on';
                @endphp
                <div class="pagination-container">
                    @if ($totalPages_services > 1)
                        @if ($currentPage > 1)
                            <a href="?q={{ urlencode($query) }}&page=1{{ $filterParams }}" class="pagination-btn" title="Primera página">«</a>
                            <a href="?q={{ urlencode($query) }}&page={{ $currentPage - 1 }}{{ $filterParams }}" class="pagination-btn" title="Página anterior">‹</a>
                        @else
                            <span class="pagination-btn disabled">«</span>
                            <span class="pagination-btn disabled">‹</span>
                        @endif
                    @endif
                    
                    @for ($p = 1; $p <= $totalPages_services; $p++)
                        @if ($p == $currentPage)
                            <span class="pagination-btn active">{{ $p }}</span>
                        @else
                            <a href="?q={{ urlencode($query) }}&page={{ $p }}{{ $filterParams }}" class="pagination-btn">{{ $p }}</a>
                        @endif
                    @endfor
                    
                    @if ($totalPages_services > 1)
                        @if ($currentPage < $totalPages_services)
                            <a href="?q={{ urlencode($query) }}&page={{ $currentPage + 1 }}{{ $filterParams }}" class="pagination-btn" title="Página siguiente">›</a>
                            <a href="?q={{ urlencode($query) }}&page={{ $totalPages_services }}{{ $filterParams }}" class="pagination-btn" title="Última página">»</a>
                        @else
                            <span class="pagination-btn disabled">›</span>
                            <span class="pagination-btn disabled">»</span>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        @if (count($products) > 0)
            <div class="result-section">
                @if ($isShowingAll)
                    <h3 style="color:#fff;"><i class="bi bi-box"></i> Todos los productos ({{ count($products) }})</h3>
                @else
                    <h3 style="color:#fff;"><i class="bi bi-box"></i> Productos encontrados ({{ count($products) }})</h3>
                @endif
                <div class="result-group">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <img src="{{ $product['image'] ?? $defaultPromoImage }}" alt="{{ $product['name'] }}">
                            <div class="product-card-body">
                                <div class="product-card-title">{{ $product['name'] }}</div>
                                <div class="product-card-store">{{ $product['store'] }}</div>
                                <div class="product-card-prices">
                                    @php
                                        $searchProductPrice = $product['price'];
                                        if (is_numeric($searchProductPrice)) {
                                            $searchProductPrice = $searchProductPrice . ' Bs';
                                        }
                                        $searchDiscountedPrice = null;
                                        if (!empty($product['offer']) && is_numeric(str_replace('%', '', $product['offer']))) {
                                            $discountPercent3 = (int)str_replace('%', '', $product['offer']);
                                            $currentPrice3 = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product['price']);
                                            if ($currentPrice3 > 0 && $discountPercent3 > 0) {
                                                $originalPrice3 = round($currentPrice3 / (1 - $discountPercent3 / 100));
                                                $searchDiscountedPrice = number_format($originalPrice3, 0, ',', '.') . ' Bs';
                                            }
                                        }
                                    @endphp
                                    <strong>{{ $searchProductPrice }}</strong>
                                    @if (!empty($searchDiscountedPrice))
                                        <del>{{ $searchDiscountedPrice }}</del>
                                    @elseif (!empty($product['old_price']))
                                        <del>@php
                                            $productFallbackPrice = $product['old_price'];
                                            if (strpos($productFallbackPrice, 'Bs') === false && is_numeric(str_replace(['.', ','], '', $productFallbackPrice))) {
                                                $productFallbackPrice .= ' Bs';
                                            }
                                        @endphp {{ $productFallbackPrice }}</del>
                                    @endif
                                </div>
                                @if (!empty($product['offer']))
                                    <span class="product-card-offer {{ $product['color'] ?? 'offer-red' }}">{{ $product['offer'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @php
                    $filterParams = '';
                    if ($priceMin) $filterParams .= '&priceMin=' . urlencode($priceMin);
                    if ($priceMax) $filterParams .= '&priceMax=' . urlencode($priceMax);
                    if ($storeFilter) $filterParams .= '&storeFilter=' . urlencode($storeFilter);
                    if ($offerOnly) $filterParams .= '&offerOnly=on';
                @endphp
                <div class="pagination-container">
                    @if ($totalPages > 1)
                        @if ($currentPage > 1)
                            <a href="?q={{ urlencode($query) }}&page=1{{ $filterParams }}" class="pagination-btn" title="Primera página">«</a>
                            <a href="?q={{ urlencode($query) }}&page={{ $currentPage - 1 }}{{ $filterParams }}" class="pagination-btn" title="Página anterior">‹</a>
                        @else
                            <span class="pagination-btn disabled">«</span>
                            <span class="pagination-btn disabled">‹</span>
                        @endif
                    @endif
                    
                    @for ($p = 1; $p <= $totalPages; $p++)
                        @if ($p == $currentPage)
                            <span class="pagination-btn active">{{ $p }}</span>
                        @else
                            <a href="?q={{ urlencode($query) }}&page={{ $p }}{{ $filterParams }}" class="pagination-btn">{{ $p }}</a>
                        @endif
                    @endfor
                    
                    @if ($totalPages > 1)
                        @if ($currentPage < $totalPages)
                            <a href="?q={{ urlencode($query) }}&page={{ $currentPage + 1 }}{{ $filterParams }}" class="pagination-btn" title="Página siguiente">›</a>
                            <a href="?q={{ urlencode($query) }}&page={{ $totalPages }}{{ $filterParams }}" class="pagination-btn" title="Última página">»</a>
                        @else
                            <span class="pagination-btn disabled">›</span>
                            <span class="pagination-btn disabled">»</span>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        @if (count($products) === 0 && count($services) === 0)
            <div class="no-results">
                <i class="bi bi-inbox" style="color:#fff;"></i>
                <h3 style="color: #fff; margin-bottom: 10px;">No se encontraron resultados</h3>
                <p style="color: #e0e0f0;">Intenta con otras palabras clave o explora nuestras categorías.</p>
                <a href="/dashboard" class="btn btn-primary mt-3" style="background: #fff; border-color: #fff; color: #6564bb;">Volver al dashboard</a>
            </div>
        @endif
            </div>
        </section>
@endsection

@section('scripts')
    <script>
        // Validación de Filtros
        const availableStores = @json($availableStores);
        const priceMinInput = document.getElementById('priceMin');
        const priceMaxInput = document.getElementById('priceMax');
        const storeFilterInput = document.getElementById('storeFilter');
        const offerOnlySwitch = document.getElementById('offerOnly');
        const filterError = document.getElementById('filterError');
        const applyFiltersBtn = document.getElementById('applyFiltersBtn');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
        
        // Hidden inputs para mantener filtros
        const hiddenPriceMin = document.getElementById('hiddenPriceMin');
        const hiddenPriceMax = document.getElementById('hiddenPriceMax');
        const hiddenStoreFilter = document.getElementById('hiddenStoreFilter');
        const hiddenOfferOnly = document.getElementById('hiddenOfferOnly');
        
        // Función para mostrar mensaje de éxito
        const showSuccessMessage = (message = 'Filtros aplicados con éxito') => {
            // Remover mensaje anterior si existe
            const existingMessage = document.querySelector('.filter-success-message');
            if (existingMessage) existingMessage.remove();
            
            const successMsg = document.createElement('div');
            successMsg.className = 'filter-success-message';
            successMsg.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
            document.body.appendChild(successMsg);
            
            // Remover después de 3 segundos
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

            // Validar precios
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

            // Validar tienda
            if (storeValue !== '' && !availableStores.includes(storeValue)) {
                errors.push(`La tienda "${storeValue}" no está registrada en nuestro sistema. Verifica el nombre e intenta de nuevo con una tienda disponible.`);
            }

            // Mostrar errores si existen
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

        // Limpieza al cerrar el offcanvas
        const filterOffcanvas = document.getElementById('filterOffcanvas');
        let filtersAppliedFlag = false;
        
        filterOffcanvas.addEventListener('hidden.bs.offcanvas', () => {
            // Si no se presionó "Aplicar", limpiar automáticamente
            if (!filtersAppliedFlag) {
                // Restaurar filtros guardados en localStorage
                const savedFilters = JSON.parse(localStorage.getItem('searchFilters') || '{}');
                priceMinInput.value = savedFilters.priceMin || '';
                priceMaxInput.value = savedFilters.priceMax || '';
                storeFilterInput.value = savedFilters.storeFilter || '';
                offerOnlySwitch.checked = savedFilters.offerOnly || false;
            }
            filtersAppliedFlag = false; // Resetear el flag
            clearError();
        });
        priceMaxInput.addEventListener('change', validateFilters);
        storeFilterInput.addEventListener('change', validateFilters);

        // Botón Aplicar
        applyFiltersBtn.addEventListener('click', () => {
            if (validateFilters()) {
                // Actualizar hidden inputs
                const minValue = priceMinInput.value.trim();
                const maxValue = priceMaxInput.value.trim();
                const storeValue = storeFilterInput.value.trim();
                const offerChecked = offerOnlySwitch.checked ? 'on' : '';
                
                hiddenPriceMin.value = minValue;
                hiddenPriceMax.value = maxValue;
                hiddenStoreFilter.value = storeValue;
                hiddenOfferOnly.value = offerChecked;
                
                filtersAppliedFlag = true; // Marcar que se aplicaron
                
                // Guardar filtros en localStorage ANTES de redirigir
                const filters = {
                    priceMin: minValue,
                    priceMax: maxValue,
                    storeFilter: storeValue,
                    offerOnly: offerOnlySwitch.checked
                };
                localStorage.setItem('searchFilters', JSON.stringify(filters));
                
                // Marcar que se aplicó un filtro
                sessionStorage.setItem('filterApplied', 'true');
                
                // Mostrar mensaje de éxito
                showSuccessMessage('Filtros aplicados con éxito');
                
                // Cerrar offcanvas
                const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                if (offcanvas) offcanvas.hide();
                
                // Construir URL con filtros
                const query = document.querySelector('.search-box').value || @json($query);
                let url = `?q=${encodeURIComponent(query)}`;
                if (minValue) url += `&priceMin=${minValue}`;
                if (maxValue) url += `&priceMax=${maxValue}`;
                if (storeValue) url += `&storeFilter=${encodeURIComponent(storeValue)}`;
                if (offerChecked) url += `&offerOnly=on`;
                
                // Redirigir a los resultados con los filtros
                setTimeout(() => {
                    window.location.href = url;
                }, 500);
            }
        });

        // Botón Descartar
        clearFiltersBtn.addEventListener('click', () => {
            clearError();
            priceMinInput.value = '';
            priceMaxInput.value = '';
            storeFilterInput.value = '';
            offerOnlySwitch.checked = false;
            
            // Limpiar hidden inputs
            hiddenPriceMin.value = '';
            hiddenPriceMax.value = '';
            hiddenStoreFilter.value = '';
            hiddenOfferOnly.value = '';
            
            // Limpiar localStorage
            localStorage.removeItem('searchFilters');
            
            filtersAppliedFlag = true; // Marcar que se aplicaron cambios (limpios)
            
            // Mostrar mensaje de éxito
            showSuccessMessage('Filtros descartados');
            
            // Redirigir sin filtros después de mostrar el mensaje
            setTimeout(() => {
                const query = document.querySelector('.search-box').value || @json($query);
                window.location.href = `?q=${encodeURIComponent(query)}`;
            }, 500);
        });
        
        // Restaurar filtros guardados en localStorage al cargar
        const restoreSavedFilters = () => {
            const savedFilters = JSON.parse(localStorage.getItem('searchFilters') || '{}');
            if (savedFilters.priceMin) priceMinInput.value = savedFilters.priceMin;
            if (savedFilters.priceMax) priceMaxInput.value = savedFilters.priceMax;
            if (savedFilters.storeFilter) storeFilterInput.value = savedFilters.storeFilter;
            if (savedFilters.offerOnly) offerOnlySwitch.checked = true;
        };
        
        // Llenar valores de filtros si existen
        window.addEventListener('DOMContentLoaded', () => {
            const priceMinVal = @json($priceMin);
            const priceMaxVal = @json($priceMax);
            const storeVal = @json($storeFilter);
            const offerVal = @json($offerOnly);
            
            if (priceMinVal) priceMinInput.value = priceMinVal;
            if (priceMaxVal) priceMaxInput.value = priceMaxVal;
            if (storeVal) storeFilterInput.value = storeVal;
            if (offerVal === 'on' || offerVal === '1' || offerVal === true) offerOnlySwitch.checked = true;
            
            // También restaurar de localStorage como respaldo
            restoreSavedFilters();
            
            // Evitar que se ingrese cero al inicio del número en campos de precio
            priceMinInput.addEventListener('input', function() {
                if (this.value.length > 1 && this.value.charAt(0) === '0') {
                    this.value = this.value.substring(1);
                }
                // Limitar a 7 caracteres (máximo 999999)
                if (this.value.length > 7) {
                    this.value = this.value.substring(0, 7);
                }
            });

            priceMaxInput.addEventListener('input', function() {
                if (this.value.length > 1 && this.value.charAt(0) === '0') {
                    this.value = this.value.substring(1);
                }
                // Limitar a 7 caracteres (máximo 999999)
                if (this.value.length > 7) {
                    this.value = this.value.substring(0, 7);
                }
            });
        });

        // Scroll horizontal para tiendas relacionadas
        const attachStoresScrollListeners = () => {
            const scrollButtons = document.querySelectorAll('.stores-scroll-btn');
            
            scrollButtons.forEach(button => {
                button.removeEventListener('click', handleStoresScroll);
                button.addEventListener('click', handleStoresScroll);
            });
        };

        const handleStoresScroll = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const direction = this.getAttribute('data-direction');
            const wrapper = this.closest('.stores-wrapper');
            const carousel = wrapper ? wrapper.querySelector('.stores-carousel') : null;
            
            if (carousel) {
                const scrollAmount = carousel.clientWidth * 0.35;
                carousel.scrollBy({ 
                    left: direction === 'next' ? scrollAmount : -scrollAmount, 
                    behavior: 'smooth' 
                });
            }
        };

        // Ejecutar cuando está listo el DOM
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', attachStoresScrollListeners);
        } else {
            attachStoresScrollListeners();
        }

        // También ejecutar al cargar completamente la página
        window.addEventListener('load', attachStoresScrollListeners);
    </script>
@endsection
