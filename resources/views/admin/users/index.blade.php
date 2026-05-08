@extends('layouts.app-authenticated')

@section('title', 'Gestión de Usuarios - Admin')

@section('styles')
<style>
    .admin-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        color: #fff;
    }
    .page-header h1 {
        font-weight: 800;
        font-size: 2rem;
        margin: 0;
    }
    .btn-custom {
        background: #3735af;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 999px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .btn-custom:hover {
        background: #2a2b8f;
        color: #fff;
        transform: translateY(-2px);
    }
    .btn-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: #fff;
        text-decoration: none;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
    .btn-icon:hover {
        transform: scale(1.1);
        opacity: 0.9;
        color: #fff;
    }
    .btn-edit { background: #ffc107; }
    .btn-toggle { background: #6c757d; }
    .btn-delete { background: #dc3545; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <div>
            <a href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.7); text-decoration: none;"><i class="fas fa-arrow-left"></i> Volver</a>
            <h1 class="mt-2"><i class="fas fa-users"></i> Usuarios</h1>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-custom">
            <i class="fas fa-plus"></i> Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius: 12px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="border-radius: 12px; font-weight: 600;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @component('components.admin-table')
        @slot('headers')
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th class="text-end">Acciones</th>
        @endslot

        @foreach($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>
                    <strong>{{ $user->name }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</strong>
                </td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($user->role) }}</span></td>
                <td>
                    <span class="badge-estado {{ $user->estado === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                        {{ ucfirst($user->estado ?? 'Activo') }}
                    </span>
                </td>
                <td class="text-end">
                    <div class="admin-actions justify-content-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon btn-toggle" title="{{ $user->estado === 'activo' ? 'Deshabilitar' : 'Habilitar' }}" onclick="return confirm('¿Seguro que deseas cambiar el estado de este usuario?')">
                                    <i class="fas {{ $user->estado === 'activo' ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Eliminar" onclick="return confirm('ATENCIÓN: Se eliminará permanentemente. ¿Deseas continuar?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        @slot('pagination')
            {{ $users->links() }}
        @endslot
    @endcomponent
</div>
@endsection
