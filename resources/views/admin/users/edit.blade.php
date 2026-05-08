@extends('layouts.app-authenticated')

@section('title', 'Editar Usuario - Admin')

@section('styles')
<style>
    .admin-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .page-header {
        margin-bottom: 30px;
        color: #fff;
    }
    .page-header h1 {
        font-weight: 800;
        font-size: 2rem;
        margin: 0;
    }
    .admin-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .form-label-custom {
        font-weight: 600;
        color: #3735af;
        margin-bottom: 8px;
    }
    .form-control-custom {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: 1px solid #d8d9ef;
        margin-bottom: 20px;
        background: #f8f9fe;
        color: #202020;
    }
    .btn-save {
        background: #3735af;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 999px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        background: #2a2b8f;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;"><i class="fas fa-arrow-left"></i> Volver a Usuarios</a>
        <h1 class="mt-2"><i class="fas fa-user-edit"></i> Editar Usuario</h1>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label-custom">Nombre</label>
                    <input type="text" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-control-custom" value="{{ old('apellido_paterno', $user->apellido_paterno) }}" required>
                    @error('apellido_paterno') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Apellido Materno</label>
                    <input type="text" name="apellido_materno" class="form-control-custom" value="{{ old('apellido_materno', $user->apellido_materno) }}" required>
                    @error('apellido_materno') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <label class="form-label-custom mt-2">Correo Electrónico</label>
            <input type="email" class="form-control-custom" value="{{ $user->email }}" readonly style="opacity: 0.6; cursor: not-allowed;">
            <small class="text-muted d-block mb-3">El correo electrónico no se puede modificar.</small>

            <label class="form-label-custom">Rol del Usuario</label>
            <select name="role" class="form-control-custom" required>
                <option value="cliente" {{ $user->role === 'cliente' ? 'selected' : '' }}>Cliente</option>
                <option value="comerciante" {{ $user->role === 'comerciante' ? 'selected' : '' }}>Comerciante</option>
                <option value="administrador" {{ $user->role === 'administrador' ? 'selected' : '' }}>Administrador</option>
            </select>
            @error('role') <small class="text-danger">{{ $message }}</small> @enderror

            <div class="text-end mt-4">
                <button type="submit" class="btn-save">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
