@extends('layouts.app-authenticated')

@section('title', $subcategoria->nombre . ' - Mall Gran Vía')

@section('styles')
    <style>
        .subcategoria-header { 
            background: #44d6ce; 
            border-radius: 20px; 
            padding: 32px; 
            margin-bottom: 40px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            flex-wrap: wrap; 
            gap: 24px;
        }
        .subcategoria-header-content { flex: 1; min-width: 250px; }
        .breadcrumb-link { color: #017470; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 12px; }
        .subcategoria-header h1 { color: #017470; font-weight: 700; font-size: 2rem; margin: 0; }
        .header-buttons { display: flex; gap: 12px; }
        .header-btn { background: #017470; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer; }
        .header-btn:hover { background: #015854; }
    </style>
@endsection

@section('content')
    <main class="container-fluid px-3 px-md-4 pt-4">
        <!-- Información de la subcategoría -->
        <x-subcategoria-info 
            :title="$subcategoria->nombre" 
            :category="$category"
            :productCount="$products->total()"
            :storeCount="count($relatedStores)"
        />

        <!-- Sección de Tiendas Relacionadas -->
        <x-stores-carousel 
            :stores="$relatedStores"
            :title="'Tiendas relacionadas a ' . $subcategoria->nombre"
            :subtitle="'Descubre todas las tiendas de ' . $subcategoria->nombre"
        />

        <!-- Sección de Productos -->
        <x-products-grid 
            :products="$products"
            :title="$subcategoria->nombre"
            :emptyMessage="'No hay productos disponibles en esta subcategoría en este momento.'"
        />
    </main>
@endsection

@section('scripts')
    <script>
        function scrollCarousel(id, distance) {
            const carousel = document.getElementById(id);
            if (carousel) {
                carousel.scrollBy({ left: distance, behavior: 'smooth' });
            }
        }
    </script>
@endsection
