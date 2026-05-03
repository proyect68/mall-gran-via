<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'producto_variantes';
    protected $primaryKey = 'id_variante';

    protected $fillable = [
        'id_producto',
        'titulo',
        'tipo',
        'valor',
        'imagen',
        'orden',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
}
