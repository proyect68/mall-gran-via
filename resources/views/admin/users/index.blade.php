@extends('layouts.admin')

@section('title', 'Gestión de Usuarios - Admin')
@section('page-title', 'Gestión de Usuarios')

@section('styles')
<style>
    .page-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-actions h2 { font-weight: 700; font-size: 1.3rem; color: #1e1e3f; margin: 0; }
    .btn-new { background: #3735af; color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; transition: all 0.2s ease; }
    .btn-new:hover { background: #2a2b8f; color: #fff; transform: translateY(-2px); }
    .btn-icon { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; color: #fff; text-decoration: none; transition: all 0.2s ease; font-size: 0.85rem; }
    .btn-icon:hover { transform: scale(1.08); opacity: 0.9; color: #fff; }
    .btn-edit { background: #ffc107; color: #000; }
    .btn-edit:hover { color: #000; }
    .btn-toggle-active { background: #6c757d; }
    .btn-delete { background: #dc3545; }
    .users-table { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #eef0f5; }
    .users-table table { margin-bottom: 0; }
    .users-table thead { background: #f4f4fb; }
    .users-table th { font-weight: 700; text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.5px; padding: 14px 16px; border: none; color: #6c6e9a; }
    .users-table td { padding: 14px 16px; border-bottom: 1px solid #f0f0f5; color: #202020; font-size: 0.9rem; vertical-align: middle; }
    .users-table tbody tr:hover { background: #fafaff; }
    .badge-role { padding: 5px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; }
    .badge-role-administrador { background: rgba(103, 126, 234, 0.15); color: #667eea; }
    .badge-role-comerciante { background: rgba(246, 211, 101, 0.25); color: #c49800; }
    .badge-role-cliente { background: rgba(132, 250, 176, 0.2); color: #22875a; }
    .actions-cell { display: flex; gap: 6px; justify-content: flex-end; }
    .table-pagination { padding: 16px; display: flex; justify-content: center; }
    .empty-state { text-align: center; padding: 60px 20px; color: #8c8ea0; }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; display: block; }
</style>
@endsection

@section('content')
    <div class="breadcrumb-nav mb-3">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Volver al Dashboard</a>
    </div>

    <div class="page-actions">
        <div>
            <h2><i class="bi bi-people-fill me-2"></i>Usuarios (<span id="users-count-badge">{{ $users->total() }}</span>)</h2>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="search-container" style="position: relative; width: 350px;">
                <i class="bi bi-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #8c8ea0; z-index: 10;"></i>
                <input type="text" id="admin-search-input" placeholder="Buscar nombre, email o rol..." 
                       style="width: 100%; padding: 10px 15px 10px 40px; border-radius: 12px; border: 1px solid #eef0f5; background: #fff; font-size: 0.9rem; outline: none;">
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-new">
                <i class="bi bi-plus-lg"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    <div class="users-table">
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
                <tbody id="users-table-body">
                    @forelse($users as $user)
                        <tr>
                            <td><strong>#{{ $user->id }}</strong></td>
                            <td>{{ $user->name }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge-role badge-role-{{ $user->role ?? 'cliente' }}">
                                    {{ ucfirst($user->role ?? 'cliente') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-estado badge-activo" style="padding: 5px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; background: rgba(40, 167, 69, 0.12); color: #28a745;">Activo</span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-edit"><i class="bi bi-pencil-fill"></i></a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-icon btn-toggle-active"><i class="bi bi-toggle-on"></i></button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty-state"><i class="bi bi-people"></i><p>No hay usuarios.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div id="pagination-container" class="table-pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function() {
        const input = document.getElementById('admin-search-input');
        const body = document.getElementById('users-table-body');
        const badge = document.getElementById('users-count-badge');
        const pag = document.getElementById('pagination-container');
        
        // Estado inicial
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
                // LIMPIEZA RADICAL ANTES DE LA PETICION
                body.innerHTML = `<tr><td colspan="6" class="text-center p-4"><div class="spinner-border text-primary" role="status"></div></td></tr>`;
                
                fetch(`{{ route('admin.search') }}?category=usuarios&q=${encodeURIComponent(val)}`)
                    .then(r => r.json())
                    .then(data => {
                        console.log("DEBUG API Response:", data);
                        
                        // Limpiamos de nuevo por si acaso
                        body.innerHTML = '';
                        
                        if (data.error) {
                            body.innerHTML = `<tr><td colspan="6" class="empty-state text-danger"><i class="bi bi-exclamation-triangle"></i><p>Error: ${data.error}</p></td></tr>`;
                            return;
                        }

                        const results = Array.isArray(data) ? data : (data.value || data.data || []);
                        badge.innerText = results.length;
                        pag.style.display = 'none';
                        
                        if (results.length === 0) {
                            body.innerHTML = `<tr><td colspan="6" class="empty-state"><i class="bi bi-search"></i><p>Sin resultados para "${val}"</p></td></tr>`;
                            return;
                        }

                        body.innerHTML = results.map(u => `
                            <tr>
                                <td><strong>#${u.id}</strong></td>
                                <td>${u.name}</td>
                                <td>${u.email}</td>
                                <td><span class="badge-role badge-role-${u.role || 'cliente'}">${(u.role || 'cliente').toUpperCase()}</span></td>
                                <td><span class="badge-estado badge-activo" style="padding: 5px 12px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; background: rgba(40, 167, 69, 0.12); color: #28a745;">Activo</span></td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ url('admin/users') }}/${u.id}/edit" class="btn-icon btn-edit"><i class="bi bi-pencil-fill"></i></a>
                                        ${u.id != {{ auth()->id() }} ? `
                                            <form action="{{ url('admin/users') }}/${u.id}/toggle-status" method="POST" class="d-inline">
                                                @csrf <input type="hidden" name="_method" value="PATCH">
                                                <button type="submit" class="btn-icon btn-toggle-active"><i class="bi bi-toggle-on"></i></button>
                                            </form>
                                        ` : ''}
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
