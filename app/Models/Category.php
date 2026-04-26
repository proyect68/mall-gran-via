<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'name',
        'image',
        'description',
    ];

    protected $appends = [
        'name',
        'image',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }

    public function productos()
    {
        return $this->products();
    }

    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class, 'categoria_id');
    }

    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    public function getStoresCountAttribute()
    {
        return $this->products()->distinct('store')->count('store');
    }

    public function getNameAttribute()
    {
        return $this->attributes['nombre'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nombre'] = $value;
    }

    public function getImageAttribute()
    {
        return $this->attributes['imagen'] ?? null;
    }

    public function setImageAttribute($value): void
    {
        $this->attributes['imagen'] = $value;
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['descripcion'] ?? null;
    }

    public function setDescriptionAttribute($value): void
    {
        $this->attributes['descripcion'] = $value;
    }
}
