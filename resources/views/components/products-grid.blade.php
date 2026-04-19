@props(['products', 'title' => 'Productos', 'emptyMessage' => 'No hay productos disponibles', 'showDashboardLink' => true])

<div class="products-section py-5" style="background: #6564bb;">
    <div class="container-fluid px-3 px-md-4">
        <h3 class="section-title" style="color: #fff; font-size: 1.4rem;">{{ $title }}</h3>
        
        @if($products && $products->count() > 0)
            <div class="result-group">
                @foreach($products as $product)
                    <div class="product-card">
                        <img src="{{ $product->image ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" />
                        <div class="product-card-body">
                            <div class="product-card-title">{{ $product->name }}</div>
                            <div class="product-card-store">{{ $product->store ?? 'Tienda' }}</div>
                            <div class="product-card-prices">
                                @php
                                    $gridProductPrice = $product->price;
                                    if (is_numeric($gridProductPrice)) {
                                        $gridProductPrice = number_format((float)$gridProductPrice, 0, ',', '.') . ' Bs';
                                    }
                                    $gridDiscountedPrice = null;
                                    if (!empty($product->offer) && (int)$product->offer > 0) {
                                        $discountPercent = (int)$product->offer;
                                        $currentPrice = (float)str_replace([' Bs', 'Bs', '.', ','], '', $product->price);
                                        if ($currentPrice > 0) {
                                            $originalPrice = round($currentPrice / (1 - $discountPercent / 100));
                                            $gridDiscountedPrice = number_format($originalPrice, 0, ',', '.') . ' Bs';
                                        }
                                    }
                                @endphp
                                <strong>{{ $gridProductPrice }}</strong>
                                @if($gridDiscountedPrice)
                                    <del>{{ $gridDiscountedPrice }}</del>
                                @elseif($product->old_price && (float)$product->old_price > 0)
                                    <del>{{ number_format((float)$product->old_price, 0, ',', '.') }} Bs</del>
                                @endif
                            </div>
                            @if($product->offer && (int)$product->offer > 0)
                                <span class="product-card-offer offer-red">-{{ (int)$product->offer }}% OFF</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(method_exists($products, 'links'))
                <div class="pagination-container">
                    @if($products->lastPage() === 1)
                        <span style="color: #fff; font-weight: 600;">Página 1</span>
                    @else
                        @php $currentPage = $products->currentPage(); @endphp
                        @if($currentPage > 1)
                            <a href="{{ $products->url(1) }}" class="pagination-btn">«</a>
                            <a href="{{ $products->previousPageUrl() }}" class="pagination-btn">‹</a>
                        @else
                            <button class="pagination-btn disabled">«</button>
                            <button class="pagination-btn disabled">‹</button>
                        @endif
                        
                        @for($i = max(1, $currentPage - 2); $i <= min($products->lastPage(), $currentPage + 2); $i++)
                            @if($i === $currentPage)
                                <button class="pagination-btn active">{{ $i }}</button>
                            @else
                                <a href="{{ $products->url($i) }}" class="pagination-btn">{{ $i }}</a>
                            @endif
                        @endfor
                        
                        @if($currentPage < $products->lastPage())
                            <a href="{{ $products->nextPageUrl() }}" class="pagination-btn">›</a>
                            <a href="{{ $products->url($products->lastPage()) }}" class="pagination-btn">»</a>
                        @else
                            <button class="pagination-btn disabled">›</button>
                            <button class="pagination-btn disabled">»</button>
                        @endif
                    @endif
                </div>
            @endif
        @else
            <div style="background: #7d5cff; border-radius: 12px; padding: 40px; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 12px;">😞</div>
                <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px;">{{ $emptyMessage }}</p>
                @if($showDashboardLink)
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="javascript:history.back()" class="btn btn-light" style="color: #6564bb; font-weight: 600;">Volver atrás</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light" style="color: #fff; border-color: #fff; font-weight: 600;">Ir al dashboard</a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
