@props(['store' => null, 'storeId' => null])

@php
    $target = $storeId ?: $store;
@endphp

@if ($target)
    <a href="{{ route('stores.show', $target) }}" {{ $attributes->merge(['style' => 'color: inherit; text-decoration: none;']) }}>
        {{ $slot }}
    </a>
@else
    <span {{ $attributes }}>
        {{ $slot }}
    </span>
@endif
