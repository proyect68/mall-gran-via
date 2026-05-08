@extends('layouts.app-authenticated')

@section('title', $product->name)

@section('styles')
<style>
    .product-detail-page {
        background: #f5f7ff;
        min-height: calc(100vh - 80px);
        padding: 32px 0 56px;
    }

    .product-detail-shell {
        display: grid;
        grid-template-columns: minmax(320px, 0.95fr) minmax(320px, 1.05fr);
        gap: 36px;
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .gallery {
        display: grid;
        grid-template-columns: 86px 1fr;
        gap: 16px;
        align-items: start;
    }

    .gallery-thumbs {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .gallery-thumb,
    .variant-thumb {
        border: 2px solid transparent;
        background: #fff;
        border-radius: 8px;
        padding: 4px;
        cursor: pointer;
        transition: border-color .18s ease, transform .18s ease;
    }

    .gallery-thumb:hover,
    .gallery-thumb.active,
    .variant-thumb:hover,
    .variant-thumb.active {
        border-color: #3735af;
        transform: translateY(-1px);
    }

    .gallery-thumb img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: 6px;
        display: block;
    }

    .main-image-wrap {
        background: #fff;
        border-radius: 12px;
        padding: 14px;
        min-height: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 18px 40px rgba(55,53,175,.08);
    }

    .main-image-wrap img {
        width: 100%;
        height: 492px;
        object-fit: contain;
        border-radius: 8px;
        background: #fff;
    }

    .product-info-panel {
        background: #fff;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(55,53,175,.08);
    }

    .product-kicker {
        color: #6564bb;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .product-kicker a {
        color: #3735af;
        text-decoration: none;
    }

    .product-kicker a:hover {
        text-decoration: underline;
    }

    .product-info-panel h1 {
        color: #1f1f4e;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        font-weight: 800;
        margin-bottom: 14px;
    }

    .pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 22px;
    }

    .pill {
        color: #fff;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: .84rem;
        font-weight: 700;
    }

    .pill.category { background: #3735af; }
    .pill.subcategory { background: #c15bbc; }

    .detail-row {
        border-top: 1px solid #e8e9fb;
        padding: 18px 0;
    }

    .detail-label {
        color: #6c7190;
        font-weight: 700;
        font-size: .88rem;
        margin-bottom: 8px;
    }

    .description {
        color: #46486b;
        line-height: 1.65;
        margin: 0;
    }

    .price-line {
        display: flex;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
    }

    .price-line strong {
        color: #3735af;
        font-size: 1.55rem;
        font-weight: 800;
    }

    .price-line del {
        color: #9ea0c4;
        font-weight: 600;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 7px 12px;
        color: #fff;
        font-weight: 700;
        font-size: .84rem;
    }

    .status-pill.available { background: #248b54; }
    .status-pill.unavailable { background: #b73535; }

    .offer-badge {
        display: inline-flex;
        border-radius: 999px;
        padding: 8px 14px;
        color: #fff;
        font-size: .84rem;
        font-weight: 800;
    }

    .no-offer {
        color: #6c7190;
        font-weight: 600;
    }

    .variants {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(92px, 1fr));
        gap: 12px;
        margin-top: 8px;
    }

    .variant-thumb img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 6px;
        background: #f6f7ff;
    }

    .variant-title {
        display: block;
        margin-top: 6px;
        color: #3735af;
        font-size: .78rem;
        font-weight: 700;
        text-align: center;
    }

    @media (max-width: 900px) {
        .product-detail-shell {
            grid-template-columns: 1fr;
        }

        .gallery {
            grid-template-columns: 1fr;
        }

        .gallery-thumbs {
            flex-direction: row;
            overflow-x: auto;
        }

        .main-image-wrap {
            min-height: 360px;
        }

        .main-image-wrap img {
            height: 332px;
        }
    }
</style>
@endsection

@section('content')
@php
    $galleryImages = collect($galleryImages ?? []);

    $mainImage = $galleryImages->first();

    if (!$mainImage) {
        $mainImage = (object)[
            'url' => asset('images/sinfoto.png'),
            'alt' => $product->name
        ];
    }

    $stock = $product->stock_quantity;
    $isAvailable = $stock > 0;

    $price = $product->price;
    if ($price !== null && $price !== '' && !str_contains($price, 'Bs')) {
        $price .= ' Bs';
    }

    $oldPrice = $product->old_price;
    if ($oldPrice !== null && $oldPrice !== '' && !str_contains($oldPrice, 'Bs')) {
        $oldPrice .= ' Bs';
    }
@endphp

<main class="product-detail-page">
    <div class="product-detail-shell">
        <section class="gallery" aria-label="Imágenes de {{ $product->name }}">
            <div class="gallery-thumbs">
                @foreach ($galleryImages as $index => $image)

    @php
        $imgUrl = is_object($image) ? $image->url : $image;
        $imgTitle = is_object($image) ? $image->title : $product->name;
    @endphp

    <button type="button"
        class="gallery-thumb {{ $index === 0 ? 'active' : '' }}"
        data-image="{{ $imgUrl }}"
        data-title="{{ $imgTitle }}">

        <img src="{{ $imgUrl }}" alt="{{ $imgTitle }}">
    </button>

@endforeach
            </div>

            <div class="main-image-wrap">
                <img id="mainProductImage" src="{{ $mainImage->url }}" alt="{{ $mainImage->alt }}">
            </div>
        </section>

        <section class="product-info-panel">
            <div class="product-kicker">
                {{ $product->is_service ? 'Servicio' : 'Producto' }} en
                @if($product->store_url)
                    <a href="{{ $product->store_url }}">{{ $product->store }}</a>
                @else
                    {{ $product->store }}
                @endif
            </div>
            <h1>{{ $product->name }}</h1>

            <div class="pills">
                @if ($product->category)
                    <span class="pill category">{{ $product->category->name }}</span>
                @endif

                @if ($product->subcategory)
                    <span class="pill subcategory">{{ $product->subcategory->nombre }}</span>
                @endif
            </div>

            <div class="detail-row">
                <div class="detail-label">Descripción</div>
                <p class="description">{{ $product->description ?: 'Sin descripción registrada en la base de datos.' }}</p>
            </div>

            <div class="detail-row">
                <div class="detail-label">Precio</div>
                <div class="price-line">
                    <strong>{{ $price ?: 'Consultar' }}</strong>
                    @if ($oldPrice)
                        <del>{{ $oldPrice }}</del>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Stock</div>
                <strong>{{ $stock }}</strong>
            </div>

            <div class="detail-row">
                <div class="detail-label">Estado</div>
                <span class="status-pill {{ $isAvailable ? 'available' : 'unavailable' }}">
                    {{ $isAvailable ? 'Disponible' : 'No disponible' }}
                </span>
            </div>

            <div class="detail-row">
                <div class="detail-label">Ofertas / descuentos</div>
                @if ($product->offer)
                    <span class="offer-badge {{ $product->color ?: 'offer-red' }}">{{ $product->offer }}</span>
                @else
                    <span class="no-offer">Sin descuentos ni ofertas disponibles</span>
                @endif
            </div>

            <div class="detail-row">
                <div class="detail-label">Colores / modelos</div>
                @if ($variants->isNotEmpty())
                    <div class="variants">
                        @foreach ($variants as $variant)
                            <button type="button" class="variant-thumb" @if($variant->image) data-image="{{ $variant->image }}" @endif>
                                <img src="{{ $variant->image ?: asset('images/sinfoto.png') }}" alt="{{ $variant->title }}">
                                <span class="variant-title">{{ $variant->title }}</span>
                            </button>
                        @endforeach
                    </div>
                @else
                    <span class="no-offer">Sin colores o modelos adicionales registrados.</span>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const mainImage = document.getElementById('mainProductImage');

    document.querySelectorAll('.gallery-thumb').forEach((thumb) => {
        thumb.addEventListener('click', () => {
            document.querySelectorAll('.gallery-thumb').forEach((item) => item.classList.remove('active'));
            thumb.classList.add('active');
            mainImage.src = thumb.dataset.image;
        });
    });

    document.querySelectorAll('.variant-thumb[data-image]').forEach((thumb) => {
        thumb.addEventListener('click', () => {
            document.querySelectorAll('.variant-thumb').forEach((item) => item.classList.remove('active'));
            thumb.classList.add('active');
            mainImage.src = thumb.dataset.image;
        });
    });
</script>
@endsection
