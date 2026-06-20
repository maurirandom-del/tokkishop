<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Categoria.php
class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $incrementing = true; // Asegurar que sea auto-incrementable
    protected $keyType = 'integer';
    protected $fillable = ['id_categoria', 'nombre', 'descripcion'];
    
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id', 'id_categoria');
    }
}