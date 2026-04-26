@extends('layouts.app-authenticated')

@section('title', $store['name'])

@section('styles')
<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <div class="container-fluid px-3 px-md-4">
        <h1>{{ $store['name'] }}</h1>
    </div>
</div>

<main class="container-fluid px-3 px-md-4">

    <div class="product-grid">
        @foreach($products as $product)
            <div>
                {{ $product->name }} - {{ $product->price }} Bs
            </div>
        @endforeach
    </div>

</main>

@endsection