@props(['stores', 'title' => 'Tiendas relacionadas', 'subtitle' => null])

<div class="stores-section py-5" style="background: #cac9ff;">
    <div class="container-fluid px-3 px-md-4">
        <h3 class="section-title" style="color: #3735af; font-size: 1.4rem;">{{ $title }}</h3>
        @if($subtitle)
            <p class="section-subtitle">{{ $subtitle }}</p>
        @endif
        
        @if($stores && count($stores) > 0)
            <div class="stores-carousel" id="storesCarousel">
                @foreach($stores as $store)
                    <div class="store-card">
                        <div class="store-card-image"></div>
                        <div class="store-card-body">
                            <div class="store-card-name">{{ $store['name'] }}</div>
                            <div class="store-card-info">{{ $store['relatedProductsCount'] ?? 0 }} productos</div>
                            <div class="store-card-status">
                                <span style="width: 8px; height: 8px; background: #4caf50; border-radius: 50%; display: inline-block;"></span>
                                {{ $store['status'] ?? 'Abierto' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(count($stores) > 5)
                <div class="carousel-controls" style="display: flex; gap: 10px; margin-top: 20px; justify-content: center;">
                    <button class="carousel-btn carousel-prev" onclick="scrollCarousel('storesCarousel', -300)" style="background: #3735af; color: #fff; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">← Anterior</button>
                    <button class="carousel-btn carousel-next" onclick="scrollCarousel('storesCarousel', 300)" style="background: #3735af; color: #fff; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">Siguiente →</button>
                </div>
            @endif
        @else
            <div style="background: #008984; border-radius: 12px; padding: 40px; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 12px;">😞</div>
                <p style="color: #fff; font-size: 1.1rem; margin-bottom: 20px;">No hay tiendas disponibles en esta subcategoría</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="javascript:history.back()" class="btn btn-light" style="color: #008984; font-weight: 600;">Volver atrás</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light" style="color: #fff; border-color: #fff; font-weight: 600;">Ir al dashboard</a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function scrollCarousel(id, distance) {
        const carousel = document.getElementById(id);
        carousel.scrollBy({ left: distance, behavior: 'smooth' });
    }
</script>
