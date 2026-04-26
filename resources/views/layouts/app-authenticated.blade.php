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

        html {
            height: 100%;
            scrollbar-gutter: stable;
            overflow-y: scroll;
        }

        body {
            background: #09b7b1;
            color: #1f1f4e;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0 !important;
            overflow: hidden !important;
            overflow-x: hidden;
        }

        body.offcanvas-open {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        main {
            width: 100%;
            flex: 1;
        }

        .app-header {
            background: #cac9ff;
            color: #fff;
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .app-header .menu-btn img {
            width: 30px;
        }

        .app-header .search-box {
            background: #fff;
            border-radius: 999px;
            padding: 10px 18px;
            padding-right: 48px;
            border: none;
            width: 100%;
        }

        .search-submit-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent !important;
            border: none !important;
            color: #3735af !important;
        }

        .app-header .user-chip {
            background: rgba(255,255,255,0.16);
            border-radius: 999px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
        }

        .app-header .user-chip img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
        }

        .offcanvas.filter-offcanvas {
            width: 340px !important;
        }

        .offcanvas.filter-offcanvas .offcanvas-body,
        .offcanvas.menu-offcanvas .offcanvas-body {
            background: #cac9ff;
        }

        .filter-field {
            margin-bottom: 22px;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
            border-radius: 14px;
            padding: 12px 14px;
            border: 1px solid #d8d9ef;
        }

        .filter-success-message {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #28a745;
            color: white;
            padding: 14px 24px;
            border-radius: 8px;
            z-index: 9999;
        }
        .filter-panel .form-check-input {
            width: 2.5em;
            height: 1.45em;
            background: #ff4d4d;
            border: 1px solid #ff4d4d;
            position: relative;
        }

        .filter-panel .form-check-input:checked {
            background: #28a745 !important;
            border-color: #28a745 !important;
        }

        .filter-panel .form-check-input::before {
            content: "✗";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.8em;
        }

        .filter-panel .form-check-input:checked::before {
            content: "✓";
        }
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
        document.addEventListener('show.bs.offcanvas', function () {
            document.body.style.paddingRight = '0';
        });

        document.addEventListener('hidden.bs.offcanvas', function () {
            document.body.style.paddingRight = '';
        });
    </script>

</body>
</html>