<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oops - Error</title>

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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-container {
            background: white;
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 600px;
            width: 100%;
        }

        .error-header {
            background: linear-gradient(135deg, #3735af 0%, #09b7b1 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .error-code {
            font-size: 80px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 16px;
            animation: bounce 2s infinite;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .error-subtitle {
            font-size: 14px;
            opacity: 0.9;
            letter-spacing: 1px;
        }

        .error-body {
            padding: 50px 40px;
            text-align: center;
        }

        .error-image {
            max-width: 100%;
            height: 280px;
            object-fit: cover;
            margin-bottom: 30px;
            border-radius: 16px;
        }

        .error-message {
            font-size: 16px;
            color: #333;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .error-message strong {
            color: #3735af;
            display: block;
            margin-top: 12px;
        }

        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-error {
            padding: 14px 28px;
            border-radius: 999px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
        }

        .btn-primary {
            background: #3735af;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(55, 53, 175, 0.25);
        }

        .btn-secondary {
            background: #e9edf8;
            color: #3735af;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(55, 53, 175, 0.15);
        }

        .error-emoji {
            font-size: 60px;
            margin-bottom: 20px;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 600px) {
            .error-header {
                padding: 30px 20px;
            }

            .error-body {
                padding: 30px 20px;
            }

            .error-code {
                font-size: 60px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-image {
                height: 200px;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn-error {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-header">
            <div class="error-code">¡Oops!</div>
            <div class="error-title">Algo salió mal</div>
            <div class="error-subtitle">ERRORRRRRR</div>
        </div>

        <div class="error-body">
            <div class="error-emoji">😅</div>
            <img src="https://www.facebook.com/groups/404148061122111/posts/1135628501307393/" alt="Error" class="error-image" onerror="this.style.display='none'">
            <div class="error-message">
                @if($message ?? false)
                    {{ $message }}
                @else
                    Parece que algo ha salido mal con tu solicitud.
                @endif
                <strong>Pero no te preocupes, estamos en ello.</strong>
            </div>

            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn-error btn-primary">
                    <i class="fas fa-home"></i>
                    Ir al inicio
                </a>
                <a href="{{ url('/login') }}" class="btn-error btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver al login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
