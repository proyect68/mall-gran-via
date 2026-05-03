@props(['product'])

@php
    $id = data_get($product, 'id');
    $name = data_get($product, 'name') ?? data_get($product, 'nombre') ?? data_get($product, 'title') ?? 'Producto';
    $store = data_get($product, 'store') ?? data_get($product, 'tienda') ?? data_get($product, 'category');
    $image = data_get($product, 'image_display') ?? data_get($product, 'image') ?? data_get($product, 'imagen') ?? asset('images/sinfoto.png');
    $price = data_get($product, 'price_display') ?? data_get($product, 'price') ?? data_get($product, 'precio') ?? 'Consultar';
    $oldPrice = data_get($product, 'old_price_display') ?? data_get($product, 'old_price') ?? data_get($product, 'precio_anterior');
    $offer = data_get($product, 'badge_display') ?? data_get($product, 'offer') ?? data_get($product, 'oferta') ?? data_get($product, 'badge');
    $color = data_get($product, 'color_display') ?? data_get($product, 'color') ?: 'offer-red';
    $detailUrl = data_get($product, 'detail_url') ?: ($id ? route('products.show', $id) : null);
    $storeUrl = data_get($product, 'store_url') ?: ($store ? route('stores.show', $store) : null);

    if (is_numeric($price)) {
        $price = number_format((float) $price, 0, ',', '.') . ' Bs';
    } elseif ($price !== 'Consultar' && $price !== null && $price !== '' && !str_contains((string) $price, 'Bs')) {
        $price .= ' Bs';
    }

    if ($oldPrice && is_numeric(str_replace(['.', ','], '', (string) $oldPrice))) {
        $oldPrice = number_format((float) str_replace(['.', ','], '', (string) $oldPrice), 0, ',', '.') . ' Bs';
    }
@endphp

@once
    <style>
        .product-card-unified { background: #cac9ff; border-radius: 8px; overflow: hidden; box-shadow: 0 14px 30px rgba(55,53,175,.12); transition: transform .2s ease, box-shadow .2s ease; height: 100%; display: flex; flex-direction: column; color: #1f1f4e; }
        .product-card-unified:hover { transform: translateY(-4px); box-shadow: 0 18px 36px rgba(55,53,175,.16); }
        .product-card-unified img { width: 100%; height: 190px; object-fit: cover; display: block; background: #fff; }
        .product-card-unified-body { padding: 15px; display: flex; flex-direction: column; gap: 9px; flex: 1; }
        .product-card-unified-title { color: #3735af; font-weight: 900; font-size: 1rem; line-height: 1.25; margin: 0; }
        .product-card-unified-store { color: #3735af; font-size: .9rem; font-weight: 750; text-decoration: none; align-self: flex-start; }
        .product-card-unified-store:hover { text-decoration: underline; color: #2f2a9b; }
        .product-card-unified-prices { display: flex; gap: 9px; align-items: baseline; flex-wrap: wrap; color: #3735af; margin-top: auto; }
        .product-card-unified-prices strong { font-size: 1.08rem; font-weight: 900; }
        .product-card-unified-prices del { color: #7c7f9c; font-size: .88rem; }
        .product-card-unified-offer { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 6px 11px; color: #fff; font-size: .76rem; font-weight: 900; align-self: flex-start; }
        .offer-red { background: #e9524c; }
        .offer-blue { background: #2b8fe0; }
        .offer-purple { background: #7d5cff; }
    </style>
@endonce

<article class="product-card-unified">
    @if($detailUrl)
        <a href="{{ $detailUrl }}" style="color:inherit; text-decoration:none;">
            <img src="{{ $image }}" alt="{{ $name }}">
        </a>
    @else
        <img src="{{ $image }}" alt="{{ $name }}">
    @endif
            <div class="product-card-unified-body">
                <h3 class="product-card-unified-title">
                    @if($detailUrl)
                        <a href="{{ $detailUrl }}" style="color:inherit; text-decoration:none;">{{ $name }}</a>
                    @else
                        {{ $name }}
                    @endif
                </h3>
                @if($store)
                    @if($storeUrl)
                        <a href="{{ $storeUrl }}" class="product-card-unified-store" onclick="event.stopPropagation();">{{ $store }}</a>
                    @else
                        <span class="product-card-unified-store">{{ $store }}</span>
                    @endif
                @endif
                <div class="product-card-unified-prices">
                    <strong>{{ $price ?: 'Consultar' }}</strong>
                    @if($oldPrice)
                        <del>{{ $oldPrice }}</del>
                    @endif
                </div>
                @if($offer)
                    <span class="product-card-unified-offer {{ $color }}">{{ $offer }}</span>
                @endif
            </div>
</article>
