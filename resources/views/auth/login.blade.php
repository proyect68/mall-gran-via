<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Mall Gran Vía</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #e9edf8;
            color: #fff;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .login-header {
            background: #cac9ff;
            padding: 18px 30px;
            display: flex;
            align-items: center;
            gap: 16px;
            color: #3735af;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        }

        .login-header a {
            color: #3735af;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .login-header a:hover {
            text-decoration: none;
            opacity: 0.85;
        }

        .login-content {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            overflow: hidden;
        }

        .login-left,
        .login-right {
            position: relative;
        }

        .login-left {
            background: #f5f7ff;
            overflow: hidden;
            cursor: pointer;
        }

        .login-left .slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: opacity 0.8s ease;
            opacity: 0;
        }

        .login-left .slide.active {
            opacity: 1;
        }

        .login-left .slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.10) 0%, rgba(0,0,0,0.45) 100%);
        }

        .login-left .slide-text {
            position: absolute;
            left: 30px;
            bottom: 60px;
            z-index: 2;
            max-width: 420px;
        }

        .login-left .slide-text h2 {
            font-size: clamp(2rem, 2.5vw, 3rem);
            line-height: 1.05;
            color: #2d39d7;
            margin: 0 0 10px;
            text-transform: uppercase;
        }

        .login-left .slide-text .bar {
            width: 100px;
            height: 4px;
            background: #3735af;
            margin-top: 16px;
            border-radius: 999px;
        }

        .slide-indicators {
            position: absolute;
            bottom: 30px;
            left: 30px;
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .indicator-bar {
            width: 30px;
            height: 3px;
            background: rgba(255, 255, 255, 0.35);
            border-radius: 999px;
            transition: width 0.8s ease, background 0.8s ease;
            cursor: pointer;
        }

        .indicator-bar.active {
            width: 60px;
            background: rgba(255, 255, 255, 0.85);
        }

        .login-right {
            background: url('{{ asset('images/Login_background.jpg') }}') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(8px);
        }

        .login-card {
            position: relative;
            width: min(520px, 100%);
            padding: 40px 36px;
            background: rgba(0,0,0,0.55);
            border-radius: 28px;
            box-shadow: 0 30px 70px rgba(0,0,0,0.35);
            z-index: 1;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .login-card img.logo {
            height: 200px;
            margin: 0 auto 40px;
            display: block;
            width: auto;
        }

        .login-card p.subtitle {
            color: rgba(255,255,255,0.75);
            text-align: center;
            margin: 0 0 28px;
            letter-spacing: 0.8px;
        }

        .form-control-custom {
            width: 100%;
            padding: 16px 18px;
            border-radius: 999px;
            border: none;
            margin-bottom: 18px;
            background: rgba(255,255,255,0.92);
            color: #202020;
            font-size: 0.95rem;
            outline: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control-custom:focus {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(55, 53, 175, 0.12);
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper .form-control-custom {
            padding-right: 50px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #3735af;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 8px;
            width: auto;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 8px;
        }

        .divider-line {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 2px;
        }

        .login-action {
            display: flex;
            justify-content: center;
            margin-top: 0;
        }

        .btn-google {
            width: 100%;
            padding: 14px 18px;
            border-radius: 999px;
            border: none;
            background: #3735af;
            color: white;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
            text-decoration: none;
        }

        .btn-google:hover {
            transform: translateY(-2px);
            background: #2a2b8f;
        }

        .error-message {
            background: rgba(255, 107, 107, 0.15);
            border-left: 4px solid #ff6b6b;
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 16px;
            color: #d32f2f;
            font-size: 0.95rem;
        }

        .form-control-custom.error {
            background: #ffffff;
            border: 2px solid #ff6b6b;
            color: #3735af;
        }

        @media (max-width: 1150px) {
            .login-content {
                grid-template-columns: 1fr;
            }
            .login-left {
                min-height: 420px;
            }
        }

        @media (max-width: 780px) {
            .login-header {
                flex-wrap: wrap;
                justify-content: center;
                text-align: center;
            }
            .login-left .slide-text {
                left: 20px;
                right: 20px;
                bottom: 40px;
            }
            .login-right {
                min-height: 600px;
            }
            .login-card {
                padding: 28px 22px;
                border-radius: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <header class="login-header">
            <a href="{{ url('/') }}">
                <i class="fas fa-arrow-left"></i>
                REGRESAR AL INICIO
            </a>
        </header>

        <div class="login-content">
            <div class="login-left" id="loginSlider" title="Haz clic para pasar a la siguiente imagen\nMantén pulsado para pausar">
                <div class="slide active" style="background-image: url('{{ asset('images/login1.png') }}');" data-text="Todo el mall en un solo lugar."></div>
                <div class="slide" style="background-image: url('{{ asset('images/login2.jpg') }}');" data-text="Encuentra lo que buscas, más rápido."></div>
                <div class="slide" style="background-image: url('{{ asset('images/login3.jpg') }}');" data-text="Decide mejor con información confiable."></div>
                <div class="slide-overlay"></div>
                <div class="slide-text" id="slideText">
                    <h2>Todo el mall en un solo lugar.</h2>
                    <div class="bar"></div>
                </div>
                <div class="slide-indicators">
                    <div class="indicator-bar active" data-index="0"></div>
                    <div class="indicator-bar" data-index="1"></div>
                    <div class="indicator-bar" data-index="2"></div>
                </div>
            </div>

            <div class="login-right">
                <div class="login-card">
                    <img src="{{ asset('images/Mall_via.png') }}" alt="Mall Gran Vía" class="logo">

                    @if ($errors->any())
                        <div class="error-message">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="email" name="email" class="form-control-custom @error('email') error @enderror" placeholder="usuario@gmail.com" value="{{ old('email') }}" required autofocus autocomplete="username" maxlength="255">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror

                        <div class="password-wrapper" style="margin-bottom: 18px;">
                            <input id="password" type="password" name="password" class="form-control-custom @error('password') error @enderror" placeholder="Ingresar contraseña" required autocomplete="current-password" maxlength="255">
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Mostrar contraseña">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn-google" style="margin-top: 6px;">Ingresar</button>
                    </form>

                    <div class="register-link-wrapper" style="text-align: center; margin-top: 20px; color: rgba(255, 255, 255, 0.75); font-size: 0.95rem;">
                        ¿Aún no tienes cuenta? <a href="{{ route('register') }}" style="color: #a8a7ff; text-decoration: none; font-weight: 600; transition: color 0.2s ease;">Regístrate aquí</a>
                    </div>

                    <div class="divider-line">.....................................................................</div>

                    <div class="login-action">
                        <a href="{{ route('google.redirect') }}" class="btn-google" style="margin-top: 0;">
                            <i class="fab fa-google"></i>
                            ingresar con google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const slides = Array.from(document.querySelectorAll('#loginSlider .slide'));
        const slideText = document.getElementById('slideText').querySelector('h2');
        const loginSlider = document.getElementById('loginSlider');
        let currentIndex = 0;
        let slideTimer;
        let isPaused = false;

        function showSlide(index) {
            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('active', slideIndex === index);
            });
            const indicators = document.querySelectorAll('.indicator-bar');
            indicators.forEach((indicator, indicatorIndex) => {
                indicator.classList.toggle('active', indicatorIndex === index);
            });
            const text = slides[index].dataset.text || '';
            slideText.textContent = text;
            currentIndex = index;
        }

        function goNextSlide() {
            const nextIndex = (currentIndex + 1) % slides.length;
            showSlide(nextIndex);
        }

        function startSlider() {
            slideTimer = setInterval(() => {
                if (!isPaused) {
                    goNextSlide();
                }
            }, 7000);
        }

        function stopSlider() {
            clearInterval(slideTimer);
        }

        loginSlider.addEventListener('click', () => {
            goNextSlide();
        });

        loginSlider.addEventListener('mousedown', () => {
            isPaused = true;
        });

        loginSlider.addEventListener('mouseup', () => {
            isPaused = false;
        });

        loginSlider.addEventListener('mouseleave', () => {
            isPaused = false;
        });

        loginSlider.addEventListener('touchstart', () => {
            isPaused = true;
        });

        loginSlider.addEventListener('touchend', () => {
            isPaused = false;
        });

        document.querySelectorAll('.indicator-bar').forEach((indicator) => {
            indicator.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.index);
                showSlide(index);
            });
        });

        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const passwordVisible = passwordInput.type === 'text';
            passwordInput.type = passwordVisible ? 'password' : 'text';
            this.innerHTML = passwordVisible ? '<i class="fa-regular fa-eye"></i>' : '<i class="fa-regular fa-eye-slash"></i>';
        });

        startSlider();
    </script>
</body>
</html>
