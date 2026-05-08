<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tienda_id',
        'tienda',
        'precio',
        'stock',
        'precio_anterior',
        'oferta',
        'color',
        'imagen',
        'expira',
        'es_servicio',
        'categoria_id',
        'subcategoria_id',
        'name',
        'description',
        'store',
        'price',
        'old_price',
        'offer',
        'image',
        'expires',
        'is_service',
        'category_id',
        'detail_url',
        'store_url',
        'availability_status',
        'stock_quantity',
        'estado',
    ];

    protected $casts = [
        'es_servicio' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'tienda_id');
    }

    public function category()
    {
        return $this->categoria();
    }

    public function subcategory()
    {
        return $this->subcategoria();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_producto')->orderBy('id_imagen');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'id_producto')->orderBy('orden');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'producto_color', 'id_producto', 'id_color');
    }

    public function getNameAttribute()
    {
        return $this->attributes['nombre'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nombre'] = $value;
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['descripcion'] ?? null;
    }

    public function setDescriptionAttribute($value): void
    {
        $this->attributes['descripcion'] = $value;
    }

    public function getStoreAttribute()
    {
        return $this->attributes['tienda'] ?? null;
    }

    public function setStoreAttribute($value): void
    {
        $this->attributes['tienda'] = $value;
    }

    public function getPriceAttribute()
    {
        return $this->attributes['precio'] ?? null;
    }

    public function setPriceAttribute($value): void
    {
        $this->attributes['precio'] = $value;
    }

    public function getOldPriceAttribute()
    {
        return $this->attributes['precio_anterior'] ?? null;
    }

    public function setOldPriceAttribute($value): void
    {
        $this->attributes['precio_anterior'] = $value;
    }

    public function getOfferAttribute()
    {
        return $this->attributes['oferta'] ?? null;
    }

    public function setOfferAttribute($value): void
    {
        $this->attributes['oferta'] = $value;
    }

    public function getImageAttribute()
    {
        return $this->attributes['imagen'] ?? null;
    }

    public function setImageAttribute($value): void
    {
        $this->attributes['imagen'] = $value;
    }

    public function getExpiresAttribute()
    {
        return $this->attributes['expira'] ?? null;
    }

    public function setExpiresAttribute($value): void
    {
        $this->attributes['expira'] = $value;
    }

    public function getIsServiceAttribute()
    {
        return (bool) ($this->attributes['es_servicio'] ?? false);
    }

    public function setIsServiceAttribute($value): void
    {
        $this->attributes['es_servicio'] = $value;
    }

    public function getCategoryIdAttribute()
    {
        return $this->attributes['categoria_id'] ?? null;
    }

    public function setCategoryIdAttribute($value): void
    {
        $this->attributes['categoria_id'] = $value;
    }

    public function getDetailUrlAttribute(): ?string
    {
        $id = $this->attributes['id'] ?? null;

        return $id ? route('products.show', $id) : null;
    }

    public function getStoreUrlAttribute(): ?string
    {
        $store = $this->attributes['tienda_id'] ?? $this->store;

        return $store ? route('stores.show', $store) : null;
    }

    public function getStockQuantityAttribute(): int
    {
        return max(0, (int) ($this->attributes['stock'] ?? 0));
    }

    public function getAvailabilityStatusAttribute(): string
    {
        return $this->stock_quantity > 0 ? 'Disponible' : 'No disponible';
    }
}
