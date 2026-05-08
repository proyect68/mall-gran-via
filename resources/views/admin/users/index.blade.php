@extends('layouts.admin')

@section('title', 'Gestión de Usuarios - Admin')
@section('page-title', 'Gestión de Usuarios')

@section('styles')
<style>
    .page-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-actions h2 {
        font-weight: 700;
        font-size: 1.3rem;
        color: #1e1e3f;
        margin: 0;
    }

    .btn-new {
        background: #3735af;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-new:hover {
        background: #2a2b8f;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.85rem;
    }

    .btn-icon:hover {
        transform: scale(1.08);
        opacity: 0.9;
        color: #fff;
    }

    .btn-edit { background: #ffc107; color: #000; }
    .btn-edit:hover { color: #000; }
    .btn-toggle-active { background: #6c757d; }
    .btn-delete { background: #dc3545; }

    .users-table {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #eef0f5;
    }

    .users-table table {
        margin-bottom: 0;
    }

    .users-table thead {
        background: #f4f4fb;
    }

    .users-table th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        color: #6c6e9a;
    }

    .users-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f5;
        color: #202020;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .users-table tbody tr:hover {
        background: #fafaff;
    }

    .users-table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-role {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge-role-administrador { background: rgba(103, 126, 234, 0.15); color: #667eea; }
    .badge-role-comerciante { background: rgba(246, 211, 101, 0.25); color: #c49800; }
    .badge-role-cliente { background: rgba(132, 250, 176, 0.2); color: #22875a; }
    .badge-role-super_admin { background: rgba(220, 53, 69, 0.15); color: #dc3545; }

    .badge-estado {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge-activo { background: rgba(40, 167, 69, 0.12); color: #28a745; }
    .badge-inactivo { background: rgba(220, 53, 69, 0.12); color: #dc3545; }

    .actions-cell {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }

    .table-pagination {
        padding: 16px;
        display: flex;
        justify-content: center;
    }

    .breadcrumb-nav {
        margin-bottom: 20px;
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

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #8c8ea0;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
    }
</style>
@endsection

@section('content')
    <div class="breadcrumb-nav">
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-arrow-left me-1"></i> Volver al Dashboard</a>
    </div>

    <div class="page-actions">
        <h2><i class="bi bi-people-fill me-2"></i>Usuarios ({{ $users->total() }})</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-new">
            <i class="bi bi-plus-lg"></i> Nuevo Usuario
        </a>
    </div>

    <div class="users-table">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><strong>#{{ $user->id }}</strong></td>
                                <td>{{ $user->name }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge-role badge-role-{{ $user->role ?? 'cliente' }}">
                                        {{ ucfirst($user->role ?? 'Sin rol') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-estado {{ ($user->estado ?? 'activo') === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                        {{ ucfirst($user->estado ?? 'Activo') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-edit" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-icon btn-toggle-active"
                                                    title="{{ ($user->estado ?? 'activo') === 'activo' ? 'Deshabilitar' : 'Habilitar' }}"
                                                    onclick="return confirm('¿Seguro que deseas cambiar el estado de este usuario?')">
                                                    <i class="bi {{ ($user->estado ?? 'activo') === 'activo' ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon btn-delete"
                                                    title="Eliminar permanentemente"
                                                    onclick="return confirm('ATENCIÓN: Esta acción eliminará al usuario de forma permanente. ¿Deseas continuar?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="table-pagination">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <p>No se encontraron usuarios.</p>
            </div>
        @endif
    </div>
@endsection
