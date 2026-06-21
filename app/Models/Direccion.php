<?php
// app/Models/Direccion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id_direccion';
    
    protected $fillable = [
        'user_id',
        'calle',
        'numero_exterior', 
        'numero_interior',
        'colonia',
        'ciudad',
        'estado',
        'codigo_postal',
        'pais',
        'referencias',
        'es_principal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_direccion');
    }
    
    public function getDireccionCompletaAttribute()
    {
        return "{$this->calle} #{$this->numero_exterior}" . 
               ($this->numero_interior ? " Int. {$this->numero_interior}" : "") . 
               ", {$this->colonia}, {$this->ciudad}, {$this->estado}, C.P. {$this->codigo_postal}";
    }
}