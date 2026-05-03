@props(['product'])

@php
    $productId = data_get($product, 'id');
    $url = data_get($product, 'detail_url') ?: ($productId ? route('products.show', $productId) : null);
@endphp

@if ($url)
    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'product-detail-link', 'style' => 'display:block; height:100%; color:inherit; text-decoration:none;']) }}>
        {{ $slot }}
    </a>
@else
    <div {{ $attributes->merge(['class' => 'product-detail-link disabled', 'style' => 'display:block; height:100%; color:inherit;']) }}>
        {{ $slot }}
    </div>
@endif
