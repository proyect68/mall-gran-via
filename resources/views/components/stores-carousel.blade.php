@props(['stores', 'title' => 'Tiendas relacionadas', 'subtitle' => null])

<div class="stores-section py-5" style="background: #cac9ff;">
    <div class="container-fluid px-3 px-md-4">
        <h3 class="section-title" style="color: #3735af; font-size: 1.4rem;">{{ $title }}</h3>
        @if($subtitle)
            <p class="section-subtitle">{{ $subtitle }}</p>
        @endif

        @if($stores && count($stores) > 0)
            <x-store-grid :stores="$stores" carousel id="storesCarousel" />
        @else
            <div style="background: #008984; border-radius: 8px; padding: 40px; text-align: center;">
                <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px;">No hay tiendas disponibles en esta subcategoria</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="javascript:history.back()" class="btn btn-light" style="color: #008984; font-weight: 600;">Volver atras</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light" style="color: #fff; border-color: #fff; font-weight: 600;">Ir al dashboard</a>
                </div>
            </div>
        @endif
    </div>
</div>
