<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Color.php
class Color extends Model
{
    //Parece que si no agrego un protected con el nombre colores en español intenta buscar la la tabla en
    //el plural ingles y al ejecutarlo da un error xd, no sabia
    protected $table = 'colores';
    protected $primaryKey = 'id_color';
    public $incrementing = true;
    protected $keyType = 'integer';
    protected $fillable = ['id_color', 'nombre'];
    
    public function productos()
    {
        return $this->hasMany(Producto::class, 'color_id', 'id_color');
    }
}
