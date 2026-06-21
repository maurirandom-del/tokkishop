<?php
// app/Models/Compra.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    
    protected $fillable = [
        'user_id',
        'id_direccion',
        'id_metodo_pago',
        'numero_pedido',
        'subtotal',
        'envio',
        'impuestos',
        'total',
        'estado',
        'notas',
        'fecha_confirmacion',
        'fecha_envio',
        'fecha_entrega'
    ];

    protected $casts = [
        'fecha_confirmacion' => 'datetime',
        'fecha_envio' => 'datetime',
        'fecha_entrega' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }

    public function productos()
    {
        return $this->hasMany(CompraProducto::class, 'id_compra');
    }
    
    public function generarNumeroPedido()
    {
        return 'TOK' . date('Ymd') . str_pad($this->id_compra, 6, '0', STR_PAD_LEFT);
    }
    
    public function getEstadoTextoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'confirmado' => 'Confirmado',
            'en_proceso' => 'En proceso',
            'enviado' => 'Enviado',
            'entregado' => 'Entregado',
            'cancelado' => 'Cancelado'
        ];
        
        return $estados[$this->estado] ?? $this->estado;
    }
}