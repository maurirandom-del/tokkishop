<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Talla.php
class Talla extends Model
{
    protected $table = 'tallas';
    protected $primaryKey = 'id_talla';
    public $incrementing = true;
    protected $keyType = 'integer';
    protected $fillable = ['id_talla', 'talla', 'descripcion'];
    
    public function productos()
    {
        return $this->hasMany(Producto::class, 'talla_id', 'id_talla');
    }
}
