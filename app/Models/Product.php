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
        'tienda',
        'precio',
        'precio_anterior',
        'oferta',
        'color',
        'imagen',
        'expira',
        'es_servicio',
        'categoria_id',
        'subcategoria_id',
        'name',
        'store',
        'price',
        'old_price',
        'offer',
        'image',
        'expires',
        'is_service',
        'category_id',
    ];

    protected $casts = [
        'es_servicio' => 'boolean',
    ];

    protected $appends = [
        'name',
        'store',
        'price',
        'old_price',
        'offer',
        'image',
        'expires',
        'is_service',
        'category_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function category()
    {
        return $this->categoria();
    }

    public function getNameAttribute()
    {
        return $this->attributes['nombre'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nombre'] = $value;
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
}
