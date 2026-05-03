<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'producto_imagenes';
    protected $primaryKey = 'id_imagen';

    protected $fillable = [
        'id_producto',
        'url',
        'titulo',
        'alt',
        'orden',
        'principal',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
}
