<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Mall Gran Vía</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #cac9ff 0%, #44d6ce 100%);
            min-height: 100vh;
        }

        .dashboard-header {
            background: #cac9ff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        }

        .dashboard-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #3735af;
            font-weight: 700;
            font-size: 18px;
        }

        .dashboard-brand img {
            height: 40px;
            width: auto;
        }

        .dashboard-user {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #3735af;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #999;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .logout-btn {
            background: #3735af;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #2a2b8f;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome-box {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        }

        .welcome-box h1 {
            color: #3735af;
            font-size: 36px;
            margin-bottom: 16px;
        }

        .welcome-box p {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .welcome-emoji {
            font-size: 80px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                gap: 16px;
            }

            .welcome-box {
                padding: 40px 20px;
            }

            .welcome-box h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <header class="dashboard-header">
        <div class="dashboard-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Mall Gran Vía">
            <span>Mall Gran Vía</span>
        </div>

        <div class="dashboard-user">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div style="color: #3735af; font-weight: 600;">{{ Auth::user()->name }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <div class="dashboard-container">
        <div class="welcome-box">
            <div class="welcome-emoji">👋</div>
            <h1>¡Bienvenido a tu Dashboard!</h1>
            <p>Este es tu espacio personal en Mall Gran Vía.</p>
            <p style="color: #999; font-size: 14px;">Pronto añadiremos más funcionalidades aquí.</p>
        </div>
    </div>
</body>
</html>
