@props(['products', 'title' => 'Productos', 'emptyMessage' => 'No hay productos disponibles', 'showDashboardLink' => true])

@once
    <style>
        .products-section-unified { background: #6564bb; padding: 36px 0; }
        .products-grid-unified { display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); gap: 18px; }
        .pagination-container { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 28px; flex-wrap: wrap; }
        .pagination-btn { background: #3735af; color: #fff; border: 2px solid #3735af; border-radius: 6px; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; cursor: pointer; transition: all .2s ease; text-decoration: none; }
        .pagination-btn:hover { background: #2f2a9b; border-color: #2f2a9b; color: #fff; }
        .pagination-btn.active, .pagination-btn.disabled { opacity: .55; pointer-events: none; }
    </style>
@endonce

<div class="products-section-unified">
    <div class="container-fluid px-3 px-md-4">
        @if($title)
            <h3 class="section-title" style="color: #fff; font-size: 1.4rem;">{{ $title }}</h3>
        @endif

        @if($products && $products->count() > 0)
            <div class="products-grid-unified">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            @if(method_exists($products, 'links') && $products->hasPages())
                <div class="pagination-container">
                    @php $currentPage = $products->currentPage(); @endphp
                    @if($currentPage > 1)
                        <a href="{{ $products->url(1) }}" class="pagination-btn">&laquo;</a>
                        <a href="{{ $products->previousPageUrl() }}" class="pagination-btn">&lsaquo;</a>
                    @else
                        <span class="pagination-btn disabled">&laquo;</span>
                        <span class="pagination-btn disabled">&lsaquo;</span>
                    @endif

                    @for($i = max(1, $currentPage - 2); $i <= min($products->lastPage(), $currentPage + 2); $i++)
                        @if($i === $currentPage)
                            <span class="pagination-btn active">{{ $i }}</span>
                        @else
                            <a href="{{ $products->url($i) }}" class="pagination-btn">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($currentPage < $products->lastPage())
                        <a href="{{ $products->nextPageUrl() }}" class="pagination-btn">&rsaquo;</a>
                        <a href="{{ $products->url($products->lastPage()) }}" class="pagination-btn">&raquo;</a>
                    @else
                        <span class="pagination-btn disabled">&rsaquo;</span>
                        <span class="pagination-btn disabled">&raquo;</span>
                    @endif
                </div>
            @endif
        @else
            <div style="background: #7d5cff; border-radius: 8px; padding: 40px; text-align: center;">
                <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px;">{{ $emptyMessage }}</p>
                @if($showDashboardLink)
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-light" style="color: #6564bb; font-weight: 600;">Volver atras</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light" style="color: #fff; border-color: #fff; font-weight: 600;">Ir al dashboard</a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
