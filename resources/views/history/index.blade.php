<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial - Mall Gran Vía</title>
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

        .empty-state-container { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 500px; padding: 40px 20px; text-align: center; }
        .empty-state-icon { font-size: 5rem; margin-bottom: 24px; opacity: 0.6; color: #6f62f0; }
        .empty-state-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 12px; color: #1f1f4e; }
        .empty-state-text { font-size: 1rem; color: #6c7190; margin-bottom: 32px; max-width: 500px; }
        .empty-state-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn-primary-custom { background: #6f62f0; border: none; color: #fff; padding: 12px 32px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; cursor: pointer; }
        .btn-primary-custom:hover { background: #5d52d8; transform: translateY(-2px); box-shadow: 0 8px 16px rgba(111, 98, 240, 0.3); color: #fff; }
        .btn-secondary-custom { background: transparent; border: 2px solid #6f62f0; color: #6f62f0; padding: 10px 30px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; cursor: pointer; }
        .btn-secondary-custom:hover { background: rgba(111, 98, 240, 0.1); color: #5d52d8; }

        .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; margin-top: 40px; }
        .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 18px; }
        .footer-app a { color: #d2d4ff; text-decoration: none; }
        .footer-app a:hover { color: #fff; }
    </style>
</head>
<body>
    @include('components.app-header')
    @include('components.menu-offcanvas')
    @include('components.filter-offcanvas')

    <div class="page-header">
        <div class="container-fluid px-3 px-md-4">
            <h1><i class="bi bi-clock-history"></i> Mi Historial</h1>
            <p>Revisa todo lo que has buscado y visto</p>
        </div>
    </div>

    <main class="container-fluid px-3 px-md-4">
        <div class="empty-state-container">
            <i class="bi bi-clock-history empty-state-icon"></i>
            <h2 class="empty-state-title">Aún no tienes un historial</h2>
            <p class="empty-state-text">Tu historial de búsquedas y productos vistos aparecerá aquí. Comienza a explorar Mall Gran Vía para crear tu historial.</p>
            <div class="empty-state-buttons">
                <a href="{{ route('dashboard') }}" class="btn-secondary-custom">
                    <i class="bi bi-house-fill me-2"></i>Volver al dashboard
                </a>
                <a href="{{ route('search', ['q' => '']) }}" class="btn-primary-custom">
                    <i class="bi bi-search me-2"></i>Explorar productos
                </a>
            </div>
        </div>
    </main>

    @include('components.app-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
