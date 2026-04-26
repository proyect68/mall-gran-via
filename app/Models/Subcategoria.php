<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $fillable = ['nombre', 'imagen', 'descripcion', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function productos()
    {
        return $this->hasMany(Product::class, 'subcategoria_id');
    }

    public function getProductsCountAttribute()
    {
        return $this->productos()->count();
    }

    public function getStoresCountAttribute()
    {
        return $this->productos()->select('tienda')->distinct()->count();
    }
}
