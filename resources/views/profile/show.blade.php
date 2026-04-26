@extends('layouts.app-authenticated')

@section('title', 'Mi Perfil - Mall Gran Vía')

@section('styles')
<style>
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
</style>
@endsection

@section('content')

<div class="page-header">
    <div class="container-fluid px-3 px-md-4">
        <h1><i class="bi bi-person-circle"></i> Mi Perfil</h1>
        <p>Gestiona tu información personal</p>
    </div>
</div>

<main class="container-fluid px-3 px-md-4">
    <div class="profile-container">

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
                @if (Auth::user()->email_verified_at)
                    Email Verificado
                @else
                    Email No Verificado
                @endif
            </span>
        </div>

        <div class="profile-section">
            <h3 class="section-title">Información Personal</h3>
            <div class="info-grid">
                <div>
                    <div class="info-label">Nombre</div>
                    <div class="info-value">{{ Auth::user()->name }}</div>
                </div>
                <div>
                    <div class="info-label">Apellido Paterno</div>
                    <div class="info-value {{ !Auth::user()->apellido_paterno ? 'empty' : '' }}">
                        {{ Auth::user()->apellido_paterno ?: 'No proporcionado' }}
                    </div>
                </div>
                <div>
                    <div class="info-label">Apellido Materno</div>
                    <div class="info-value {{ !Auth::user()->apellido_materno ? 'empty' : '' }}">
                        {{ Auth::user()->apellido_materno ?: 'No proporcionado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <h3 class="section-title">Información de Contacto</h3>
            <div class="info-grid">
                <div>
                    <div class="info-label">Correo</div>
                    <div class="info-value">{{ Auth::user()->email }}</div>
                </div>
                <div>
                    <div class="info-label">Estado</div>
                    <div class="info-value">
                        {{ Auth::user()->email_verified_at ? 'Verificado' : 'No verificado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="action-buttons">
                <a href="{{ route('profile.edit') }}" class="btn-custom btn-primary-custom">
                    Editar Perfil
                </a>
                <a href="{{ route('dashboard') }}" class="btn-custom btn-secondary-custom">
                    Volver al Dashboard
                </a>
            </div>
        </div>

    </div>
</main>

@endsection