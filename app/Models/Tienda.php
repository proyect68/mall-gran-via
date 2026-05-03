<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Tienda extends Model
{
    use HasFactory;

    protected $table = 'tiendas';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'banner_url',
        'logo_url',
        'ubicacion',
        'piso_local',
        'estado',
        'horario',
        'owner_id',
        'seguidores',
        'calificacion',
        'telefono',
        'whatsapp',
        'email',
        'facebook',
        'instagram',
        'tiktok',
    ];

    public function getKeyName()
    {
        return Schema::hasColumn($this->getTable(), 'id_tienda') ? 'id_tienda' : 'id';
    }

    public function productos()
    {
        return $this->hasMany(Product::class, 'tienda_id', $this->getKeyName());
    }

    public function propietario()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function seguidoresUsuarios()
    {
        if (! class_exists(SeguidoresTienda::class)) {
            return $this->hasMany(User::class, 'id', 'id');
        }

        return $this->hasMany(SeguidoresTienda::class, 'id_tienda', $this->getKeyName());
    }

    public function resenasTienda()
    {
        if (! class_exists(ResenasTienda::class)) {
            return $this->hasMany(User::class, 'id', 'id')->whereRaw('1 = 0');
        }

        return $this->hasMany(ResenasTienda::class, 'id_tienda', $this->getKeyName());
    }

    public function getCategoriasAttribute()
    {
        $productos = $this->relationLoaded('productos') ? $this->productos : collect();

        return $productos
            ->pluck('categoria')
            ->filter()
            ->unique('id')
            ->values();
    }

    public function getSubcategoriasAttribute()
    {
        $productos = $this->relationLoaded('productos') ? $this->productos : collect();

        return $productos
            ->pluck('subcategoria')
            ->filter()
            ->unique('id')
            ->values();
    }

    public function getProductosCountAttribute(): int
    {
        if ($this->relationLoaded('productos')) {
            return $this->productos->count();
        }

        return $this->productos()->count();
    }

    public function calcularCalificacion()
    {
        if (! class_exists(ResenasTienda::class)) {
            return $this->calificacion;
        }

        $promedio = $this->resenasTienda()->avg('puntuacion');

        if ($promedio) {
            $this->update(['calificacion' => round($promedio, 1)]);
        }

        return $promedio;
    }

    public function estaActiva()
    {
        return in_array($this->estado, ['activa', 'abierto'], true);
    }

    public function scopeActivas($query)
    {
        return $query->whereIn('estado', ['activa', 'abierto']);
    }

    public function scopeBuscarPorNombre($query, $nombre)
    {
        return $query->where('nombre', 'ilike', "%{$nombre}%");
    }
}
