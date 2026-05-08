<div class="table-responsive">
    <table class="table align-middle admin-table">
        <thead>
            <tr>
                {{ $headers }}
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>

@if(isset($pagination))
    <div class="mt-4 d-flex justify-content-center">
        {{ $pagination }}
    </div>
@endif

<style>
    .admin-table {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 0;
    }
    
    .admin-table thead {
        background: #cac9ff;
        color: #3735af;
    }
    
    .admin-table th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 16px;
        border: none;
    }
    
    .admin-table td {
        padding: 16px;
        border-bottom: 1px solid #f0f0f0;
        color: #202020;
        font-size: 0.95rem;
    }
    
    .admin-table tbody tr:hover {
        background-color: #f8f9fe;
    }
    
    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-estado {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge-activo {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }
    
    .badge-inactivo {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
    
    .admin-actions {
        display: flex;
        gap: 8px;
    }
</style>
