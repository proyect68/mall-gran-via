@props(['tienda'])

@php
    $categorias = $tienda->categorias ?? collect();
    $subcategorias = $tienda->subcategorias ?? collect();
@endphp

@if($categorias->count() || $subcategorias->count())
    <div class="store-category-list">
        @foreach($categorias as $categoria)
            <span class="store-category-pill category-pill">
                {{ $categoria->name ?? $categoria->nombre }}
            </span>
        @endforeach

        @foreach($subcategorias as $subcategoria)
            <span class="store-category-pill subcategory-pill">
                {{ $subcategoria->nombre }}
            </span>
        @endforeach
    </div>
@else
    <p class="empty-muted">No tiene categorias asociadas.</p>
@endif

<style>
    .store-category-list { display: flex; flex-wrap: wrap; gap: 10px; }
    .store-category-pill { display: inline-flex; align-items: center; border-radius: 999px; padding: 8px 13px; font-size: .86rem; font-weight: 800; border: 1px solid transparent; }
    .category-pill { background: #e7ecff; color: #3735af; border-color: #c7d1ff; }
    .subcategory-pill { background: #fde8f8; color: #9d267f; border-color: #f6c4ea; }
    .empty-muted { color: #8a8fa8; font-style: italic; margin: 0; }
</style>
