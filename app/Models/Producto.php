<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $primaryKey = 'id_producto';
    protected $table = 'productos';

    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'descripcion', 
        'precio', 
        'stock', 
        'imagen_url',
        'id_talla',
        'id_color',  
        'id_categoria' 
    ];
    
    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer'
    ];
        
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
    
    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id_color');
    }
    
    // Un producto PERTENECE A una talla
    public function talla()
    {
        return $this->belongsTo(Talla::class, 'id_talla', 'id_talla');
    }
}
