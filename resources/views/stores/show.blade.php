<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $store['name'] }} - Mall Gran Vía</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        html { scrollbar-gutter: stable; overflow-y: scroll; }
        html, body { width: 100%; }
        body { font-family: 'Montserrat', sans-serif; background: #09b7b1; color: #1f1f4e; padding: 0 !important; }
        main { width: 100%; }

        .app-header { background: #cac9ff; }
        .app-header .menu-btn img { width: 30px; height: auto; }
        .app-header img[alt="Mall Gran Vía"] { width: 40px; height: auto; }

        .page-header { background: linear-gradient(135deg, #6f62f0 0%, #7d5cff 100%); color: #fff; padding: 30px 0 20px; margin-bottom: 30px; }
        .page-header h1 { font-size: 1.8rem; font-weight: 800; margin-bottom: 8px; }
        .page-header p { font-size: 0.95rem; margin-bottom: 0; opacity: 0.95; }
        .back-link { color: rgba(255,255,255,0.9); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; font-size: 0.9rem; }
        .back-link:hover { color: #fff; }

        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }

        .product-card { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }

        .product-image { width: 100%; height: 180px; object-fit: cover; background: #e0e0e0; }
        .product-info { padding: 14px; }
        .product-name { font-weight: 700; font-size: 0.95rem; margin-bottom: 8px; color: #1f1f4e; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .product-price { font-size: 1.2rem; font-weight: 800; color: #6f62f0; margin-bottom: 6px; }
        .product-old-price { color: #9ea0c4; text-decoration: line-through; font-size: 0.9rem; margin-right: 8px; }
        .product-expires { color: #7c7fa1; font-size: 0.8rem; margin-top: 8px; }
        .product-badge { display: inline-block; background: #e9524c; color: #fff; padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; margin-top: 8px; }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state-icon { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }
        .empty-state p { color: #6c7190; font-size: 1.1rem; }

        .pagination-container { display: flex; justify-content: center; margin: 40px 0; }
        .pagination { margin: 0; }

        @media (max-width: 768px) {
            .product-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; }
            .page-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    @include('components.app-header')
    @include('components.menu-offcanvas')
    @include('components.filter-offcanvas')

    <div class="page-header">
        <div class="container-fluid px-3 px-md-4">
            <a href="{{ route('stores.index') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Volver a Tiendas
            </a>
            <h1><i class="bi bi-shop"></i> {{ $store['name'] }}</h1>
            <p>{{ $store['product_count'] }} productos disponibles</p>
        </div>
    </div>

    <main class="container-fluid px-3 px-md-4 pb-4">
        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=600&h=400&fit=crop&q=80' }}" alt="{{ $product->name }}" class="product-image">
                        <div class="product-info">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">
                                {{ $product->price }} Bs
                                @if($product->old_price)
                                    <span class="product-old-price">{{ $product->old_price }} Bs</span>
                                @endif
                            </div>
                            @if($product->offer)
                                <div class="product-badge">-{{ $product->offer }}%</div>
                            @endif
                            <div class="product-expires">
                                <i class="bi bi-calendar-check"></i> Vence: {{ $product->expires ?? '31/05/2026' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="pagination-container">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h3 style="color: #1f1f4e; margin-bottom: 8px;">No hay productos en esta tienda</h3>
                <p>Intenta con otra tienda o vuelve a explorar</p>
            </div>
        @endif
    </main>

    @include('components.app-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
