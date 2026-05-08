@extends('layouts.admin')

@section('title', 'Gestión de Tiendas - Admin')
@section('page-title', 'Gestión de Tiendas')

@section('styles')
<style>
    .page-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-actions h2 { font-weight: 700; font-size: 1.3rem; color: #1e1e3f; margin: 0; }
    .btn-new { background: #3735af; color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; transition: all 0.2s ease; }
    .btn-new:hover { background: #2a2b8f; color: #fff; transform: translateY(-2px); }
    
    .stores-table { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #eef0f5; }
    .stores-table table { margin-bottom: 0; }
    .stores-table thead { background: #f4f4fb; }
    .stores-table th { font-weight: 700; text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.5px; padding: 14px 16px; border: none; color: #6c6e9a; }
    .stores-table td { padding: 14px 16px; border-bottom: 1px solid #f0f0f5; color: #202020; font-size: 0.9rem; vertical-align: middle; }
    
    .store-logo { width: 50px; height: 50px; border-radius: 12px; object-fit: contain; background: #fff; border: 1px solid #eee; padding: 4px; }
    .btn-icon { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; color: #fff; text-decoration: none; transition: all 0.2s ease; font-size: 0.85rem; }
    .btn-edit { background: #ffc107; color: #000; }
    .btn-toggle-active { background: #6c757d; }
    .btn-delete { background: #dc3545; }
    
    .empty-state { text-align: center; padding: 60px 20px; color: #8c8ea0; }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; display: block; }
    .table-pagination { padding: 16px; display: flex; justify-content: center; }
</style>
@endsection

@section('content')
    <div class="breadcrumb-nav mb-3">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Volver al Dashboard</a>
    </div>

    <div class="page-actions">
        <div>
            <h2><i class="bi bi-shop me-2"></i>Tiendas (<span id="stores-count-badge">{{ $stores->total() }}</span>)</h2>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="search-container" style="position: relative; width: 350px;">
                <i class="bi bi-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #8c8ea0; z-index: 10;"></i>
                <input type="text" id="admin-search-input" placeholder="Buscar por nombre, RIF o descripción..." 
                       style="width: 100%; padding: 10px 15px 10px 40px; border-radius: 12px; border: 1px solid #eef0f5; background: #fff; font-size: 0.9rem; outline: none;">
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-new">
                <i class="bi bi-plus-lg"></i> Nueva Tienda
            </a>
        </div>
    </div>

    <div class="stores-table">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Nombre</th>
                        <th>RIF</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody id="stores-table-body">
                    @forelse($stores as $tienda)
                        <tr>
                            <td><strong>#{{ $tienda->id_tienda }}</strong></td>
                            <td>
                                <img src="{{ $tienda->logo_url ? asset('storage/' . $tienda->logo_url) : asset('images/placeholder-store.png') }}" 
                                     class="store-logo" alt="{{ $tienda->nombre }}">
                            </td>
                            <td>{{ $tienda->nombre }}</td>
                            <td><code>{{ $tienda->rif ?? 'N/A' }}</code></td>
                            <td>
                                @if(in_array($tienda->estado, ['activa', 'abierto']))
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Activa</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inactiva</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.stores.edit', $tienda) }}" class="btn-icon btn-edit" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('admin.stores.toggle-status', $tienda) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-icon btn-toggle-active" title="Cambiar Estado">
                                            <i class="bi bi-toggle-{{ in_array($tienda->estado, ['activa', 'abierto']) ? 'on' : 'off' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.stores.destroy', $tienda) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty-state"><i class="bi bi-shop"></i><p>No hay tiendas registradas.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div id="pagination-container" class="table-pagination">
            {{ $stores->links() }}
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function() {
        const input = document.getElementById('admin-search-input');
        const body = document.getElementById('stores-table-body');
        const badge = document.getElementById('stores-count-badge');
        const pag = document.getElementById('pagination-container');
        
        const originalHtml = body.innerHTML;
        const originalCount = badge.innerText;
        let timer = null;

        input.addEventListener('input', function() {
            const val = this.value.trim();
            clearTimeout(timer);

            if (!val || val.length === 0) {
                body.innerHTML = originalHtml;
                badge.innerText = originalCount;
                pag.style.display = 'flex';
                return;
            }

            timer = setTimeout(() => {
                body.innerHTML = `<tr><td colspan="6" class="text-center p-5"><div class="spinner-border text-primary" role="status"></div></td></tr>`;
                
                fetch(`{{ route('admin.search') }}?category=tiendas&q=${encodeURIComponent(val)}`)
                    .then(r => r.json())
                    .then(data => {
                        const results = Array.isArray(data) ? data : (data.value || data.data || []);
                        body.innerHTML = '';
                        badge.innerText = results.length;
                        pag.style.display = 'none';

                        if (results.length === 0) {
                            body.innerHTML = `<tr><td colspan="6" class="empty-state"><i class="bi bi-search"></i><p>Sin resultados para "${val}"</p></td></tr>`;
                            return;
                        }

                        body.innerHTML = results.map(s => `
                            <tr>
                                <td><strong>#${s.id_tienda}</strong></td>
                                <td><img src="${s.logo_url ? '/storage/' + s.logo_url : '/images/placeholder-store.png'}" class="store-logo"></td>
                                <td>${s.nombre}</td>
                                <td><code>${s.rif || 'N/A'}</code></td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Activa</span></td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/admin/stores/${s.id_tienda}/edit" class="btn-icon btn-edit"><i class="bi bi-pencil-fill"></i></a>
                                        <form action="/admin/stores/${s.id_tienda}/toggle-status" method="POST" class="d-inline">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="PATCH">
                                            <button type="submit" class="btn-icon btn-toggle-active"><i class="bi bi-toggle-on"></i></button>
                                        </form>
                                        <form action="/admin/stores/${s.id_tienda}" method="POST" class="d-inline">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn-icon btn-delete"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `).join('');
                    });
            }, 400);
        });
    })();
</script>
@endsection
