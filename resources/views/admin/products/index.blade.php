@extends('layouts.admin')

@section('title', 'Gestión de Productos - Admin')
@section('page-title', 'Gestión de Productos')

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

    .data-table {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #eef0f5;
    }

    .data-table table { margin-bottom: 0; }

    .data-table thead { background: #f4f4fb; }

    .data-table th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        color: #6c6e9a;
    }

    .data-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f5;
        color: #202020;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .data-table tbody tr:hover { background: #fafaff; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .product-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        background: #f0f0f5;
    }

    .product-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-name-text {
        font-weight: 600;
        color: #1e1e3f;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge-estado {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge-activo { background: rgba(40, 167, 69, 0.12); color: #28a745; }
    .badge-inactivo { background: rgba(220, 53, 69, 0.12); color: #dc3545; }

    .badge-servicio {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        background: rgba(103, 126, 234, 0.12);
        color: #667eea;
    }

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

    .breadcrumb-nav a:hover { color: #3735af; }

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

    .text-truncate-custom {
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }
</style>
@endsection

@section('content')
    <div class="breadcrumb-nav">
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-arrow-left me-1"></i> Volver al Dashboard</a>
    </div>

    <div class="page-actions">
        <h2><i class="bi bi-box-seam-fill me-2"></i>Productos ({{ $products->total() }})</h2>
    </div>

    <div class="data-table">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Tienda</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td><strong>#{{ $product->id }}</strong></td>
                                <td>
                                    <div class="product-name-cell">
                                        @if($product->imagen)
                                            <img src="{{ $product->imagen }}" alt="" class="product-thumb" onerror="this.src='https://via.placeholder.com/48'">
                                        @else
                                            <div class="product-thumb d-flex align-items-center justify-content-center" style="background: #eef0f5;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="product-name-text" title="{{ $product->nombre }}">{{ $product->nombre }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate-custom" title="{{ $product->tienda }}">
                                        {{ $product->tienda ?? '—' }}
                                    </span>
                                </td>
                                <td>{{ $product->categoria->nombre ?? '—' }}</td>
                                <td><strong>{{ $product->precio ?? '—' }}</strong></td>
                                <td>{{ $product->stock ?? 0 }}</td>
                                <td>
                                    @if($product->es_servicio)
                                        <span class="badge-servicio">Servicio</span>
                                    @else
                                        <span style="font-size: 0.82rem; color: #6c6e9a;">Producto</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-estado {{ ($product->estado ?? 'activo') === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                        {{ ucfirst($product->estado ?? 'Activo') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon btn-edit" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-icon btn-toggle-active"
                                                title="{{ ($product->estado ?? 'activo') === 'activo' ? 'Deshabilitar' : 'Habilitar' }}"
                                                onclick="return confirm('¿Cambiar el estado de este producto?')">
                                                <i class="bi {{ ($product->estado ?? 'activo') === 'activo' ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete"
                                                title="Eliminar permanentemente"
                                                onclick="return confirm('ATENCIÓN: Se eliminará este producto de forma permanente. ¿Continuar?')">
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

            @if($products->hasPages())
                <div class="table-pagination">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="bi bi-box-seam"></i>
                <p>No se encontraron productos.</p>
            </div>
        @endif
    </div>
@endsection
