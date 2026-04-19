<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ver Tiendas - Mall Gran Vía</title>
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

        .section-title { font-weight: 700; font-size: 1.5rem; margin-bottom: 12px; color: #1f1f4e; letter-spacing: 0.5px; }
        .section-subtitle { color: #6c7190; margin-bottom: 24px; font-size: 0.95rem; }

        .category-section { margin-bottom: 40px; }
        .category-header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 3px solid #e0e0e0; }
        .category-header img { width: 70px; height: 70px; border-radius: 12px; object-fit: cover; }
        .category-info h3 { font-size: 1.4rem; font-weight: 700; margin: 0; color: #1f1f4e; }
        .category-info p { margin: 4px 0 0 0; color: #6c7190; font-size: 0.9rem; }

        .stores-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-bottom: 48px; }

        .store-card { background: linear-gradient(135deg, #e8e7ff 0%, #f0efff 100%); border-radius: 18px; padding: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent; }
        .store-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,0.15); border-color: #6f62f0; }

        .store-card-icon { width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #6f62f0 0%, #7d5cff 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 28px; margin-bottom: 16px; }

        .store-card h4 { font-size: 1.3rem; font-weight: 700; margin-bottom: 8px; color: #1f1f4e; }
        .store-card-info { display: flex; gap: 20px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #e0e0e0; }
        .store-card-stat { display: flex; align-items: center; gap: 8px; color: #6c7190; font-size: 0.95rem; }
        .store-card-stat strong { color: #1f1f4e; font-weight: 700; }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state-icon { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }
        .empty-state p { color: #6c7190; font-size: 1rem; }

        .stats-bar { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; gap: 30px; justify-content: center; flex-wrap: wrap; }
        .stat-item { text-align: center; }
        .stat-item-number { font-size: 2rem; font-weight: 800; color: #6f62f0; }
        .stat-item-label { color: #6c7190; font-size: 0.9rem; margin-top: 4px; }

        @media (max-width: 768px) {
            .stores-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
            .page-header h1 { font-size: 1.5rem; }
            .category-header { flex-direction: column; text-align: center; }
            .category-header img { width: 80px; height: 80px; }
            .stats-bar { gap: 20px; }
            .stat-item-number { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    @include('components.app-header')
    @include('components.menu-offcanvas')
    @include('components.filter-offcanvas')

    <div class="page-header">
        <div class="container-fluid px-3 px-md-4">
            <h1><i class="bi bi-shop"></i> Ver Tiendas</h1>
            <p>Descubre todas las tiendas del mall agrupadas por categorías</p>
        </div>
    </div>

    <main class="container-fluid px-3 px-md-4">
        <!-- Estadísticas -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-item-number">{{ $totalStores }}</div>
                <div class="stat-item-label">Tiendas Totales</div>
            </div>
            <div class="stat-item">
                <div class="stat-item-number">{{ $totalCategories }}</div>
                <div class="stat-item-label">Categorías</div>
            </div>
        </div>

        @if(count($storesByCategory) > 0)
            @foreach($storesByCategory as $categoryId => $data)
                <section class="category-section">
                    <div class="category-header">
                        @if($data['category']->image)
                            <img src="{{ $data['category']->image }}" alt="{{ $data['category']->name }}">
                        @else
                            <div style="width: 80px; height: 80px; border-radius: 12px; background: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #999;">
                                <i class="bi bi-image" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <div class="category-info">
                            <h3>{{ $data['category']->name }}</h3>
                            <p><i class="bi bi-shop"></i> {{ $data['store_count'] }} tiendas • <i class="bi bi-bag"></i> {{ $data['product_count'] }} productos</p>
                        </div>
                    </div>

                    <div class="stores-grid">
                        @foreach($data['stores'] as $store)
                            <a href="{{ route('stores.show', ['store' => urlencode($store)]) }}" style="text-decoration: none; color: inherit;">
                                <div class="store-card">
                                    <div class="store-card-icon">
                                        <i class="bi bi-shop"></i>
                                    </div>
                                    <h4>{{ $store }}</h4>
                                    <div class="store-card-info">
                                        <div class="store-card-stat">
                                            <i class="bi bi-tag"></i>
                                            <strong>{{ App\Models\Product::where('store', $store)->where('category_id', $categoryId)->count() }}</strong> productos
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h3 style="color: #1f1f4e; margin-bottom: 8px;">No hay tiendas disponibles</h3>
                <p>Intenta más tarde o explora nuestras categorías</p>
            </div>
        @endif
    </main>

    @include('components.app-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
