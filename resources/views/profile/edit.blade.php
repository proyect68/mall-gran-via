@extends('layouts.app-authenticated')

@section('title', 'Editar Perfil - Mall Gran Vía')

@section('styles')
<style>
    .profile-page {
        font-family: 'Montserrat', sans-serif;
        background: #f5f7ff;
        min-height: calc(100vh - 80px);
        padding: 40px 20px;
        color: #1f1f4e;
    }

    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .profile-card {
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 15px 40px rgba(55,53,175,.08);
    }

    .profile-header {
        margin-bottom: 24px;
        border-bottom: 1px solid #e8e9fb;
        padding-bottom: 16px;
    }

    .profile-header h2 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1f1f4e;
        margin: 0 0 8px;
    }

    .profile-header p {
        color: #6c7190;
        margin: 0;
        font-size: 0.95rem;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-group-custom label {
        display: block;
        margin-bottom: 8px;
        color: #3735af;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .form-control-custom {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: 2px solid #e8e9fb;
        background: #fafbff;
        color: #202020;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: #3735af;
        box-shadow: 0 0 0 4px rgba(55, 53, 175, 0.1);
    }

    .form-control-custom.error {
        border-color: #ff6b6b;
        background: #fffafa;
    }

    .error-message {
        color: #ce2525;
        font-size: 0.85rem;
        margin-top: 6px;
        font-weight: 600;
    }

    .btn-save {
        padding: 14px 28px;
        border-radius: 999px;
        border: none;
        background: #3735af;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        background: #2a2b8f;
    }

    .form-actions {
        display: flex;
        align-items: center;
        margin-top: 32px;
    }

    .status-message {
        color: #248b54;
        font-weight: 600;
        font-size: 0.95rem;
        margin-left: 16px;
        animation: fadeOut 3s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; }
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
        top: 8px;
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
    }

    .password-toggle:hover {
        color: #2a2b8f;
    }
</style>
@endsection

@section('content')
<div class="profile-page">
    <div class="profile-container">
        
        <div class="profile-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-card">
            @include('profile.partials.update-password-form')
        </div>
        
    </div>
</div>

@if (session('status') === 'profile-updated' || session('status') === 'password-updated')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Cambio Guardado!',
                text: '{{ session('status') === 'profile-updated' ? 'Tu información de perfil ha sido actualizada.' : 'Tu contraseña ha sido actualizada con éxito.' }}',
                confirmButtonColor: '#3735af',
                timer: 3500
            });
        });
    </script>
@endif
@endsection
