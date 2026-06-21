<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
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
    
    public function favoritos()
    {
        return $this->belongsToMany(Producto::class, 'favoritos', 'user_id', 'producto_id');
    }

    public function carrito()
    {
        return $this->hasMany(Carrito::class, 'user_id');
    }
    // app/Models/User.php - agregar estas relaciones
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'user_id');
    }

    public function metodosPago()
    {
        return $this->hasMany(MetodoPago::class, 'user_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'user_id');
    }

    public function direccionPrincipal()
    {
        return $this->hasOne(Direccion::class, 'user_id')->where('es_principal', true);
    }

    public function metodoPagoPrincipal()
    {
        return $this->hasOne(MetodoPago::class, 'user_id')->where('es_principal', true);
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
