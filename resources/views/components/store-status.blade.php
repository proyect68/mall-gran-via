@props(['estado', 'tamano' => 'md', 'tamaño' => null])

@php
    $size = $tamaño ?: $tamano;
    $normalized = strtolower((string) $estado);
    $label = match ($normalized) {
        'activa', 'abierto' => 'Abierto',
        'cerrado' => 'Cerrado',
        'deshabilitado', 'inactiva', 'inactivo' => 'Deshabilitado',
        default => ucfirst($normalized ?: 'Sin estado'),
    };

    $sizeClass = match($size) {
        'sm' => 'store-status-sm',
        'lg' => 'store-status-lg',
        default => 'store-status-md',
    };

    $colorClass = match ($label) {
        'Abierto' => 'store-status-open',
        'Cerrado' => 'store-status-closed',
        'Deshabilitado' => 'store-status-disabled',
        default => 'store-status-disabled',
    };
@endphp

<span class="store-status-pill {{ $colorClass }} {{ $sizeClass }}">
    <span class="store-status-dot"></span>
    {{ $label }}
</span>

<style>
    .store-status-pill { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; border: 1px solid transparent; font-weight: 700; }
    .store-status-sm { padding: 5px 10px; font-size: .78rem; }
    .store-status-md { padding: 7px 13px; font-size: .9rem; }
    .store-status-lg { padding: 9px 16px; font-size: 1rem; }
    .store-status-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
    .store-status-open { background: #e7f7ee; color: #1f7a46; border-color: #bde8cf; }
    .store-status-closed { background: #fde9e8; color: #b73535; border-color: #f5c4c1; }
    .store-status-disabled { background: #f0f1f5; color: #6c7190; border-color: #d8dbe8; }
</style>
