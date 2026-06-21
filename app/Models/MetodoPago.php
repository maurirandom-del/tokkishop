<?php
// app/Models/MetodoPago.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodos_pago';
    protected $primaryKey = 'id_metodo_pago';
    
    protected $fillable = [
        'user_id',
        'tipo',
        'titular',
        'numero_tarjeta',
        'fecha_vencimiento',
        'cvv',
        'es_principal'
    ];

    protected $hidden = ['cvv']; // Ocultar datos sensibles

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_metodo_pago');
    }
    
    public function getTarjetaEnmascaradaAttribute()
    {
        if ($this->numero_tarjeta) {
            return '**** **** **** ' . substr($this->numero_tarjeta, -4);
        }
        return 'Método digital';
    }
    
    public function getTipoTextoAttribute()
    {
        $tipos = [
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito', 
            'paypal' => 'PayPal',
            'transferencia' => 'Transferencia'
        ];
        
        return $tipos[$this->tipo] ?? $this->tipo;
    }
}