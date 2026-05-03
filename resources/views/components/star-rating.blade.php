@props(['calificacion' => null, 'tamano' => 'md', 'tamaño' => null])

@php
    $size = $tamaño ?: $tamano;
    $rating = $calificacion !== null ? max(0, min(5, (float) $calificacion)) : null;
    $sizeClass = match($size) {
        'sm' => 'star-rating-sm',
        'lg' => 'star-rating-lg',
        default => 'star-rating-md',
    };
@endphp

<div class="star-rating {{ $sizeClass }}">
    @if($rating !== null)
        <span class="star-rating-stars" aria-label="{{ number_format($rating, 1) }} de 5">
            @for($i = 1; $i <= 5; $i++)
                <span class="{{ $i <= round($rating) ? 'star-on' : 'star-off' }}">&#9733;</span>
            @endfor
        </span>
        <strong>{{ number_format($rating, 1) }}</strong>
    @else
        <span class="star-rating-empty">Sin reseñas</span>
    @endif
</div>

<style>
    .star-rating { display: inline-flex; align-items: center; gap: 8px; color: #4a4d68; }
    .star-rating-sm { font-size: .85rem; }
    .star-rating-md { font-size: 1rem; }
    .star-rating-lg { font-size: 1.15rem; }
    .star-rating-stars { display: inline-flex; gap: 2px; letter-spacing: 0; }
    .star-on { color: #ffbe0b; }
    .star-off { color: #d2d5e6; }
    .star-rating-empty { color: #8a8fa8; font-style: italic; }
</style>
