<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colores';
    protected $primaryKey = 'id_color';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'producto_color', 'id_color', 'id_producto');
    }
}
