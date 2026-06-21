<?php
// app/Models/CompraProducto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraProducto extends Model
{
    protected $table = 'compras_productos';
    protected $primaryKey = 'id_compra_producto';
    
    protected $fillable = [
        'id_compra',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }
}