<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'store',
        'price',
        'old_price',
        'offer',
        'color',
        'image',
        'expires',
        'is_service',
        'category_id',
        'subcategoria_id',
    ];

        protected $casts = [
            'price' => 'float',
            'old_price' => 'float',
        ];
}