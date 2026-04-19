@props(['title', 'category', 'productCount', 'storeCount'])

<div style="background: #44d6ce; border-radius: 20px; padding: 32px; margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 24px;">
    <div style="flex: 1; min-width: 250px;">
        <a href="{{ route('categories.subcategorias', $category->id) }}" class="breadcrumb-link" style="color: #017470; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 12px;">← {{ $category->name }}</a>
        <h1 style="color: #017470; font-weight: 700; font-size: 2rem; margin: 0;">{{ $title }}</h1>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="#tiendas" class="btn" style="background: #017470; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer;">Ver {{ $storeCount }} tiendas</a>
        <a href="#productos" class="btn" style="background: #017470; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer;">Ver {{ $productCount }} productos</a>
    </div>
</div>
