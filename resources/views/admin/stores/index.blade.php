@extends('layouts.admin')

@section('title', 'Gestión de Tiendas - Admin')
@section('page-title', 'Gestión de Tiendas')

@section('styles')
<style>
    .page-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-actions h2 { font-weight: 700; font-size: 1.3rem; color: #1e1e3f; margin: 0; }
    .btn-icon { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; color: #fff; text-decoration: none; transition: all 0.2s ease; font-size: 0.85rem; }
    .btn-icon:hover { transform: scale(1.08); opacity: 0.9; color: #fff; }
    .btn-edit { background: #ffc107; color: #000; }
    .btn-edit:hover { color: #000; }
    .btn-toggle-active { background: #6c757d; }
    .btn-delete { background: #dc3545; }
    .data-table { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #eef0f5; }
    .data-table table { margin-bottom: 0; }
    .data-table thead { background: #f4f4fb; }
    .data-table th { font-weight: 700; text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.5px; padding: 14px 16px; border: none; color: #6c6e9a; }
    .data-table td { padding: 14px 16px; border-bottom: 1px solid #f0f0f5; color: #202020; font-size: 0.9rem; vertical-align: middle; }
    .data-table tbody tr:hover { background: #fafaff; }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .badge-estado { padding: 5px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; }
    .badge-activo { background: rgba(40,167,69,0.12); color: #28a745; }
    .badge-inactivo { background: rgba(220,53,69,0.12); color: #dc3545; }
    .actions-cell { display: flex; gap: 6px; justify-content: flex-end; }
    .table-pagination { padding: 16px; display: flex; justify-content: center; }
    .breadcrumb-nav { margin-bottom: 20px; }
    .breadcrumb-nav a { color: #6c757d; text-decoration: none; font-size: 0.88rem; font-weight: 500; }
    .breadcrumb-nav a:hover { color: #3735af; }
    .empty-state { text-align: center; padding: 60px 20px; color: #8c8ea0; }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; display: block; }
    .text-truncate-custom { max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; }
</style>
@endsection

@section('content')
<div class="breadcrumb-nav">
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-arrow-left me-1"></i> Volver al Dashboard</a>
</div>

<div class="page-actions">
    <h2><i class="bi bi-shop me-2"></i>Tiendas ({{ $stores->total() }})</h2>
</div>

<div class="data-table">
    @if($stores->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Teléfono</th>
                        <th>Calificación</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stores as $store)
                        <tr>
                            <td><strong>#{{ $store->getKey() }}</strong></td>
                            <td><strong>{{ $store->nombre }}</strong></td>
                            <td>
                                <span class="text-truncate-custom" title="{{ $store->ubicacion }}">
                                    {{ $store->ubicacion ?? '—' }}
                                </span>
                            </td>
                            <td>{{ $store->telefono ?? '—' }}</td>
                            <td>
                                @if($store->calificacion)
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i> {{ $store->calificacion }}
                                @else
                                    <span style="color: #8c8ea0;">—</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $isActive = in_array($store->estado, ['activa', 'abierto']);
                                @endphp
                                <span class="badge-estado {{ $isActive ? 'badge-activo' : 'badge-inactivo' }}">
                                    {{ ucfirst($store->estado ?? 'Sin estado') }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.stores.edit', $store) }}" class="btn-icon btn-edit" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('admin.stores.toggle-status', $store) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-icon btn-toggle-active"
                                            title="{{ $isActive ? 'Deshabilitar' : 'Habilitar' }}"
                                            onclick="return confirm('¿Cambiar el estado de esta tienda?')">
                                            <i class="bi {{ $isActive ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete"
                                            title="Eliminar permanentemente"
                                            onclick="return confirm('ATENCIÓN: Se eliminará esta tienda permanentemente. ¿Continuar?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($stores->hasPages())
            <div class="table-pagination">{{ $stores->links() }}</div>
        @endif
    @else
        <div class="empty-state">
            <i class="bi bi-shop"></i>
            <p>No se encontraron tiendas.</p>
        </div>
    @endif
</div>
@endsection
