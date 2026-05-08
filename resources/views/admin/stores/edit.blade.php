@extends('layouts.admin')

@section('title', 'Editar Tienda - Admin')
@section('page-title', 'Editar Tienda')

@section('styles')
<style>
    .form-card { background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #eef0f5; max-width: 800px; }
    .form-label-custom { font-weight: 600; color: #1e1e3f; margin-bottom: 8px; font-size: 0.88rem; }
    .form-control-custom { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #d8d9ef; margin-bottom: 4px; background: #f8f9fe; color: #202020; font-size: 0.92rem; transition: border-color 0.2s ease; }
    .form-control-custom:focus { outline: none; border-color: #3735af; box-shadow: 0 0 0 3px rgba(55,53,175,0.12); }
    .btn-save { background: #3735af; color: #fff; border: none; padding: 12px 28px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; }
    .btn-save:hover { background: #2a2b8f; transform: translateY(-2px); }
    .btn-cancel { background: transparent; color: #6c757d; border: 1px solid #d8d9ef; padding: 12px 28px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.2s ease; }
    .btn-cancel:hover { background: #f0f0f5; color: #333; }
    .field-error { color: #dc3545; font-size: 0.82rem; margin-top: 4px; margin-bottom: 12px; display: block; }
    .field-group { margin-bottom: 20px; }
    .info-banner { background: #f4f4fb; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px; border: 1px solid #eef0f5; }
    .info-avatar { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.1rem; flex-shrink: 0; }
    .info-details strong { display: block; color: #1e1e3f; }
    .info-details span { font-size: 0.82rem; color: #8c8ea0; }
    .breadcrumb-nav { margin-bottom: 24px; }
    .breadcrumb-nav a { color: #6c757d; text-decoration: none; font-size: 0.88rem; font-weight: 500; }
    .breadcrumb-nav a:hover { color: #3735af; }
    textarea.form-control-custom { min-height: 80px; resize: vertical; }
</style>
@endsection

@section('content')
<div class="breadcrumb-nav">
    <a href="{{ route('admin.stores.index') }}"><i class="bi bi-arrow-left me-1"></i> Volver a Tiendas</a>
</div>

<div class="form-card">
    <div class="info-banner">
        <div class="info-avatar">
            {{ strtoupper(substr($store->nombre, 0, 1)) }}
        </div>
        <div class="info-details">
            <strong>{{ $store->nombre }}</strong>
            <span>{{ $store->ubicacion ?? 'Sin ubicación' }} · ID #{{ $store->getKey() }}</span>
        </div>
    </div>

    <form action="{{ route('admin.stores.update', $store) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label class="form-label-custom">Nombre de la Tienda *</label>
            <input type="text" name="nombre" class="form-control-custom" value="{{ old('nombre', $store->nombre) }}" required>
            @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field-group">
            <label class="form-label-custom">Descripción</label>
            <textarea name="descripcion" class="form-control-custom">{{ old('descripcion', $store->descripcion) }}</textarea>
            @error('descripcion') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="field-group">
                    <label class="form-label-custom">Ubicación</label>
                    <input type="text" name="ubicacion" class="form-control-custom" value="{{ old('ubicacion', $store->ubicacion) }}">
                    @error('ubicacion') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="field-group">
                    <label class="form-label-custom">Horario</label>
                    <input type="text" name="horario" class="form-control-custom" value="{{ old('horario', $store->horario) }}">
                    @error('horario') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="field-group">
                    <label class="form-label-custom">Teléfono</label>
                    <input type="text" name="telefono" class="form-control-custom" value="{{ old('telefono', $store->telefono) }}">
                    @error('telefono') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="field-group">
                    <label class="form-label-custom">Email</label>
                    <input type="email" name="email" class="form-control-custom" value="{{ old('email', $store->email) }}">
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <button type="submit" class="btn-save"><i class="bi bi-check-lg me-1"></i> Guardar Cambios</button>
            <a href="{{ route('admin.stores.index') }}" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection
