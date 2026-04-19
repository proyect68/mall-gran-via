<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mall Gran Vía')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * { font-family: 'Montserrat', sans-serif !important; }
        html { height: 100%; scrollbar-gutter: stable; overflow-y: scroll; }
        body { font-family: 'Montserrat', sans-serif; background: #09b7b1; color: #1f1f4e; width: 100%; min-height: 100vh; display: flex; flex-direction: column; margin: 0; padding: 0 !important; overflow: hidden !important; overflow-x: hidden; }
        body.offcanvas-open { overflow: hidden !important; padding-right: 0 !important; }
        main { width: 100%; flex: 1; }
        .app-header { background: #cac9ff; color: #fff; padding: 18px 0; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .app-header .menu-btn { padding: 0 !important; }
        .app-header .menu-btn img { width: 30px; height: auto; }
        .app-header .search-box { background: #fff; border-radius: 999px; padding: 10px 18px; padding-right: 48px; border: none; width: 100%; font-family: 'Montserrat', sans-serif; }
        .app-header .search-box:focus { outline: none; box-shadow: 0 0 0 3px rgba(111,98,240,0.18); }
        .search-submit-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent !important; border: none !important; padding: 8px !important; color: #3735af !important; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; }
        .search-submit-btn:hover { color: #2f2a9b !important; }
        .app-header .user-chip { background: rgba(255,255,255,0.16); border-radius: 999px; padding: 8px 16px; display: inline-flex; align-items: center; gap: 12px; color: #fff; text-decoration: none; }
        .app-header .user-chip img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.35); }
        
        .offcanvas.filter-offcanvas { width: 340px !important; }
        .offcanvas.filter-offcanvas .offcanvas-header { background: #cac9ff; border-bottom: 1px solid rgba(55,53,175,0.2); color: #3735af; }
        .offcanvas.filter-offcanvas .offcanvas-header .offcanvas-title { color: #3735af; font-weight: 700; }
        .offcanvas.filter-offcanvas .btn-close { color: #3735af; opacity: 0.7; }
        .offcanvas.filter-offcanvas .offcanvas-body { background: #cac9ff; padding: 24px; }
        .offcanvas.menu-offcanvas .offcanvas-header { background: #cac9ff; border-bottom: 1px solid rgba(55,53,175,0.2); color: #3735af; }
        .offcanvas.menu-offcanvas .offcanvas-header .offcanvas-title { color: #3735af; font-weight: 700; }
        .offcanvas.menu-offcanvas .btn-close { color: #3735af; opacity: 0.7; }
        .offcanvas.menu-offcanvas .offcanvas-body { background: #cac9ff; color: #3735af; }
        .offcanvas.menu-offcanvas .offcanvas-body ul li a { color: #3735af; text-decoration: none; }
        .offcanvas.menu-offcanvas .offcanvas-body ul li a i { opacity: 0.7; }
        
        .filter-field { margin-bottom: 22px; }
        .filter-field label { display: block; font-weight: 700; margin-bottom: 10px; }
        .filter-field input, .filter-field select { width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff; font-family: 'Montserrat', sans-serif; }
        .filter-field input::placeholder { color: #8f92b7; }
        .filter-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .filter-panel .btn-outline-secondary { color: #3735af; border-color: #3735af; background: transparent; }
        .filter-panel .btn-outline-secondary:hover, .filter-panel .btn-outline-secondary:focus { background: rgba(55,53,175,0.08); }
        .filter-panel .btn-primary { background: #3735af; border-color: #3735af; color: #ffffff; }
        .filter-panel .btn-primary:hover, .filter-panel .btn-primary:focus { background: #2f2a9b; border-color: #2f2a9b; }
        .filter-panel .form-check-input { width: 2.5em; height: 1.45em; background: #ff4d4d; border: 1px solid #ff4d4d; position: relative; }
        .filter-panel .form-check-input:checked { background: #28a745 !important; border-color: #28a745 !important; }
        .filter-panel .form-check-input:focus { box-shadow: 0 0 0 0.25rem rgba(55,53,175,0.18); }
        .filter-panel .form-check-input::before { content: "✗"; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: white; font-size: 0.8em; }
        .filter-panel .form-check-input:checked::before { content: "✓"; }
        
        .filter-success-message { position: fixed; top: 80px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 14px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-weight: 600; z-index: 9999; animation: slideDown 0.3s ease-out, slideUp 0.3s ease-out 2.7s; }
        @keyframes slideDown { from { transform: translateX(-50%) translateY(-20px); opacity: 0; } to { transform: translateX(-50%) translateY(0); opacity: 1; } }
        @keyframes slideUp { from { transform: translateX(-50%) translateY(0); opacity: 1; } to { transform: translateX(-50%) translateY(-20px); opacity: 0; } }
    </style>
    @yield('styles')
</head>
<body>
    @include('components.app-header')
    @include('components.menu-offcanvas')
    @include('components.filter-offcanvas')

    @yield('content')

    @include('components.app-footer')

    @yield('scripts')
    <script>
        // Interceptar eventos de offcanvas para prevenir que Bootstrap agregue padding-right al body
        document.addEventListener('show.bs.offcanvas', function(e) {
            document.body.style.paddingRight = '0 !important';
            document.body.style.overflow = 'hidden !important';
            document.documentElement.style.overflow = 'hidden !important';
            // Remover el padding-right que Bootstrap intenta agregar
            setTimeout(() => {
                document.body.style.paddingRight = '0';
                document.body.style.removeProperty('padding-right');
            }, 0);
        });

        document.addEventListener('hidden.bs.offcanvas', function(e) {
            document.body.style.paddingRight = '';
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
        });

        // Observer para detectar cambios de estilo en el body y corregirlos
        const bodyStyleObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'style') {
                    const body = mutation.target;
                    if (body.style.paddingRight && body.classList.contains('offcanvas-open')) {
                        body.style.paddingRight = '0 !important';
                    }
                }
            });
        });

        bodyStyleObserver.observe(document.body, {
            attributes: true,
            attributeFilter: ['style']
        });
    </script>
</body>
</html>
