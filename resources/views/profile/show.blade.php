<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil - Mall Gran Vía</title>
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

        .profile-container { max-width: 900px; margin: 0 auto; padding-bottom: 40px; }
        .profile-header { background: linear-gradient(135deg, #e8e7ff 0%, #f0efff 100%); border-radius: 20px; padding: 40px; margin-bottom: 30px; text-align: center; box-shadow: 0 4px 16px rgba(111, 98, 240, 0.1); }
        .profile-avatar { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #6f62f0 0%, #7d5cff 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 48px; margin: 0 auto 20px; box-shadow: 0 8px 24px rgba(111, 98, 240, 0.2); }
        .profile-name { font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; color: #1f1f4e; }
        .profile-email { font-size: 0.95rem; color: #6c7190; margin-bottom: 16px; }
        .profile-badge { display: inline-block; background: #6f62f0; color: #fff; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }

        .profile-section { background: #fff; border-radius: 16px; padding: 30px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); }
        .section-title { font-size: 1.3rem; font-weight: 700; margin-bottom: 20px; color: #1f1f4e; padding-bottom: 12px; border-bottom: 2px solid #e8e7ff; }

        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .info-item { }
        .info-label { font-size: 0.85rem; font-weight: 600; color: #6c7190; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .info-value { font-size: 1rem; font-weight: 600; color: #1f1f4e; word-break: break-word; }
        .info-value.empty { color: #9ea0c4; font-style: italic; }

        .action-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-custom { padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary-custom { background: #6f62f0; color: #fff; }
        .btn-primary-custom:hover { background: #5d52d8; transform: translateY(-2px); box-shadow: 0 8px 16px rgba(111, 98, 240, 0.3); color: #fff; }
        .btn-secondary-custom { background: transparent; border: 2px solid #6f62f0; color: #6f62f0; }
        .btn-secondary-custom:hover { background: rgba(111, 98, 240, 0.1); color: #5d52d8; border-color: #5d52d8; }

        .alert-info-custom { background: rgba(111, 98, 240, 0.1); border-left: 4px solid #6f62f0; padding: 16px; border-radius: 8px; margin-bottom: 20px; }
        .alert-info-custom i { color: #6f62f0; font-size: 1.1rem; margin-right: 12px; }

        .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; margin-top: 40px; }
        .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 18px; }
        .footer-app a { color: #d2d4ff; text-decoration: none; }
        .footer-app a:hover { color: #fff; }

        @media (max-width: 768px) {
            .profile-header { padding: 30px 20px; }
            .profile-section { padding: 20px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('components.app-header')
    @include('components.menu-offcanvas')
    @include('components.filter-offcanvas')

    <div class="page-header">
        <div class="container-fluid px-3 px-md-4">
            <h1><i class="bi bi-person-circle"></i> Mi Perfil</h1>
            <p>Gestiona tu información personal</p>
        </div>
    </div>

    <main class="container-fluid px-3 px-md-4">
        <div class="profile-container">
            <!-- Encabezado del Perfil -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h2 class="profile-name">
                    {{ Auth::user()->name }}
                    @if (Auth::user()->apellido_paterno || Auth::user()->apellido_materno)
                        {{ Auth::user()->apellido_paterno }} {{ Auth::user()->apellido_materno }}
                    @endif
                </h2>
                <p class="profile-email">{{ Auth::user()->email }}</p>
                <span class="profile-badge">
                    <i class="bi bi-shield-check me-1"></i>
                    @if (Auth::user()->email_verified_at)
                        Email Verificado
                    @else
                        Email No Verificado
                    @endif
                </span>
            </div>

            <!-- Información Personal -->
            <div class="profile-section">
                <h3 class="section-title"><i class="bi bi-person me-2"></i>Información Personal</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nombre</div>
                        <div class="info-value">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Apellido Paterno</div>
                        <div class="info-value @if (!Auth::user()->apellido_paterno) empty @endif">
                            {{ Auth::user()->apellido_paterno ?: 'No proporcionado' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Apellido Materno</div>
                        <div class="info-value @if (!Auth::user()->apellido_materno) empty @endif">
                            {{ Auth::user()->apellido_materno ?: 'No proporcionado' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="profile-section">
                <h3 class="section-title"><i class="bi bi-envelope me-2"></i>Información de Contacto</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Correo Electrónico</div>
                        <div class="info-value">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estado del Email</div>
                        @if (Auth::user()->email_verified_at)
                            <span style="display: inline-block; background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.9rem;">
                                <i class="bi bi-check-circle me-1"></i>Verificado
                            </span>
                        @else
                            <span style="display: inline-block; background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.9rem;">
                                <i class="bi bi-exclamation-triangle me-1"></i>No Verificado
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de la Cuenta -->
            <div class="profile-section">
                <h3 class="section-title"><i class="bi bi-shield-lock me-2"></i>Información de la Cuenta</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Rol de Usuario</div>
                        <div class="info-value" style="text-transform: capitalize;">
                            {{ Auth::user()->role ?: 'Usuario Regular' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tipo de Autenticación</div>
                        <div class="info-value">
                            @if (Auth::user()->password)
                                Correo y Contraseña
                            @else
                                Google / Red Social
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Miembro desde</div>
                        <div class="info-value">
                            {{ Auth::user()->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aviso para usuarios con Google -->
            @if (!Auth::user()->password)
                <div class="alert-info-custom">
                    <i class="bi bi-info-circle"></i>
                    <strong>Nota:</strong> Tu cuenta está conectada a través de Google. Algunos campos pueden no estar disponibles para editar. Si deseas agregar más información, puedes actualizarla desde tu configuración.
                </div>
            @endif

            <!-- Botones de Acción -->
            <div class="profile-section">
                <div class="action-buttons">
                    <a href="{{ route('profile.edit') }}" class="btn-custom btn-primary-custom">
                        <i class="bi bi-pencil-square"></i>Editar Perfil
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-custom btn-secondary-custom">
                        <i class="bi bi-house-fill"></i>Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('components.app-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
