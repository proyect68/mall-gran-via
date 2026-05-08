@extends('layouts.admin')

@section('title', 'Crear Usuario - Admin')
@section('page-title', 'Crear Nuevo Usuario')

@section('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #eef0f5;
        max-width: 800px;
    }

    .form-label-custom {
        font-weight: 600;
        color: #1e1e3f;
        margin-bottom: 8px;
        font-size: 0.88rem;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid #d8d9ef;
        margin-bottom: 4px;
        background: #f8f9fe;
        color: #202020;
        font-size: 0.92rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #3735af;
        box-shadow: 0 0 0 3px rgba(55, 53, 175, 0.12);
    }

    .btn-save {
        background: #3735af;
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.92rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background: #2a2b8f;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: transparent;
        color: #6c757d;
        border: 1px solid #d8d9ef;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.92rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #f0f0f5;
        color: #333;
    }

    .field-error {
        color: #dc3545;
        font-size: 0.82rem;
        margin-top: 4px;
        margin-bottom: 12px;
        display: block;
    }

    .field-group {
        margin-bottom: 20px;
    }

    .breadcrumb-nav {
        margin-bottom: 24px;
    }

    .breadcrumb-nav a {
        color: #6c757d;
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 500;
    }

    .breadcrumb-nav a:hover {
        color: #3735af;
    }
</style>
@endsection

@section('content')
    <div class="breadcrumb-nav">
        <a href="{{ route('admin.users.index') }}"><i class="bi bi-arrow-left me-1"></i> Volver a Usuarios</a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="field-group">
                        <label class="form-label-custom">Nombre *</label>
                        <input type="text" name="name" class="form-control-custom" value="{{ old('name') }}" required placeholder="Ej: Juan">
                        @error('name') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="field-group">
                        <label class="form-label-custom">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" class="form-control-custom" value="{{ old('apellido_paterno') }}" required placeholder="Ej: Pérez">
                        @error('apellido_paterno') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="field-group">
                        <label class="form-label-custom">Apellido Materno *</label>
                        <input type="text" name="apellido_materno" class="form-control-custom" value="{{ old('apellido_materno') }}" required placeholder="Ej: García">
                        @error('apellido_materno') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="field-group">
                        <label class="form-label-custom">Correo Electrónico *</label>
                        <input type="email" name="email" class="form-control-custom" value="{{ old('email') }}" required placeholder="usuario@gmail.com">
                        <small style="color: #8c8ea0; font-size: 0.78rem;">Solo se permiten cuentas de Gmail.</small>
                        @error('email') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="field-group">
                        <label class="form-label-custom">Contraseña *</label>
                        <input type="password" name="password" class="form-control-custom" required placeholder="Mínimo 8 caracteres">
                        @error('password') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="field-group">
                        <label class="form-label-custom">Rol del Usuario *</label>
                        <select name="role" class="form-control-custom" required>
                            <option value="">-- Seleccionar rol --</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->nombre }}" {{ old('role') === $rol->nombre ? 'selected' : '' }}>
                                    {{ ucfirst($rol->nombre) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-3">
                <button type="submit" class="btn-save">
                    <i class="bi bi-check-lg me-1"></i> Crear Usuario
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
