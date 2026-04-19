<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
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
}
