@extends('layouts.app-authenticated')

@section('title', $product->nombre)

@section('styles')
<style>
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .product-image {
        width: 100%;
        border-radius: 12px;
        object-fit: cover;
        height: 500px;
    }

    .product-info h1 {
        font-size: 2rem;
        font-weight: 800;
        color: #1f1f4e;
        margin-bottom: 16px;
    }

    .product-store {
        color: #6c7190;
        font-size: 1.1rem;
        margin-bottom: 16px;
    }

    .product-prices {
        font-size: 1.3rem;
        margin-bottom: 24px;
    }

    .product-prices strong {
        color: #6f62f0;
        font-weight: 800;
    }

    .product-prices del {
        color: #bbb;
        margin-left: 16px;
    }

    .product-offer {
        display: inline-block;
        background: #e9524c;
        color: #fff;
        padding: 8px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .product-btn {
        background: #6f62f0;
        color: #fff;
        padding: 14px 32px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
    }

    .product-btn:hover {
        background: #5a50d9;
    }

    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .product-image {
            height: 300px;
        }

        .product-info h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')

<div class="product-detail">
    <div>
        <img src="{{ $product->imagen }}" alt="{{ $product->nombre }}" class="product-image">
    </div>
    <div class="product-info">
        <h1>{{ $product->nombre }}</h1>
        <div class="product-store"><i class="bi bi-shop"></i> {{ $product->tienda }}</div>
        
        <div class="product-prices">
            <strong>{{ $product->precio }} Bs</strong>
            @if($product->precio_anterior)
                <del>{{ $product->precio_anterior }} Bs</del>
            @endif
        </div>

        @if($product->oferta)
            <div class="product-offer">
                {{ $product->oferta }}
            </div>
        @endif

        @if($product->expira)
            <p style="color: #6c7190; margin-bottom: 24px;">
                <i class="bi bi-calendar"></i> Vence: {{ $product->expira }}
            </p>
        @endif

        <button class="product-btn" onclick="alert('Funcionalidad de carrito en desarrollo')">
            <i class="bi bi-cart-plus"></i> Agregar al carrito
        </button>

        <div style="margin-top: 24px; padding: 16px; background: #f6f7ff; border-radius: 8px;">
            <h4 style="margin-bottom: 12px; color: #1f1f4e;">Información del producto</h4>
            <p style="margin: 0; color: #6c7190; font-size: 0.95rem;">
                @if($product->es_servicio)
                    Este es un servicio disponible en {{ $product->tienda }}
                @else
                    Producto disponible en {{ $product->tienda }}
                @endif
            </p>
        </div>
    </div>
</div>

@endsection
