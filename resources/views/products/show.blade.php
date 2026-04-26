@extends('layouts.app-authenticated')

@section('content')
<main class="container py-4">

    <div class="row">
        
        <!-- IZQUIERDA: IMÁGENES -->
        <div class="col-md-5">
            <div class="mb-3">
                <img id="mainImage" 
                     src="{{ $product->image }}" 
                     class="img-fluid rounded" 
                     style="width:100%; height:400px; object-fit:cover;">
            </div>

            <div class="d-flex gap-2">
                @foreach($product->images ?? [$product->image] as $img)
                    <img src="{{ $img }}" 
                         class="img-thumbnail thumb-img" 
                         style="width:80px; height:80px; object-fit:cover; cursor:pointer;">
                @endforeach
            </div>
        </div>

        <!-- DERECHA: INFO -->
        <div class="col-md-7">

            <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

            <!-- Categorías -->
            <div class="mb-3">
                <span class="badge bg-primary">{{ $product->category->name ?? 'Sin categoría' }}</span>
                <span class="badge bg-secondary">{{ $product->subcategory->name ?? 'Sin subcategoría' }}</span>
            </div>

            <!-- Precio -->
            <h3 class="text-success fw-bold">
                {{ $product->price }} Bs
            </h3>

            <!-- Stock -->
            <p><strong>Stock:</strong> {{ $product->stock }}</p>

            <!-- Estado -->
            <p>
                <strong>Estado:</strong> 
                <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                    {{ $product->stock > 0 ? 'Disponible' : 'No disponible' }}
                </span>
            </p>

            <!-- Descripción -->
            <div class="mt-3">
                <h5>Descripción</h5>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Calificación -->
            <p><strong>Calificación:</strong> No disponible</p>

            <!-- Oferta -->
            @if($product->offer)
                <span class="badge bg-danger">{{ $product->offer }}</span>
            @endif

        </div>
    </div>

</main>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.thumb-img').forEach(img => {
    img.addEventListener('click', function(){
        document.getElementById('mainImage').src = this.src;
    });
});
</script>
@endsection