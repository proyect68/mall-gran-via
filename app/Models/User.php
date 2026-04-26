<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'password',
        'rol_id',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function getRoleAttribute()
    {
        if ($this->relationLoaded('rol')) {
            return $this->rol?->nombre;
        }

        return $this->rol()->value('nombre');
    }

    public function setRoleAttribute($value): void
    {
        $valorNormalizado = match (strtolower((string) $value)) {
            'user', 'cliente' => 'cliente',
            'comerciante' => 'comerciante',
            'admin', 'administrador' => 'administrador',
            'super-admin', 'super_admin' => 'super_admin',
            default => 'cliente',
        };

        $rolId = Rol::query()->where('nombre', $valorNormalizado)->value('id');

        if ($rolId !== null) {
            $this->attributes['rol_id'] = $rolId;
        }
    }
}
