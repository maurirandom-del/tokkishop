<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_compras_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id_compra');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_direccion')->constrained('direcciones', 'id_direccion');
            $table->foreignId('id_metodo_pago')->constrained('metodos_pago', 'id_metodo_pago');
            
            // Información de la compra
            $table->string('numero_pedido')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('envio', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Estado del pedido
            $table->enum('estado', [
                'pendiente', 
                'confirmado', 
                'en_proceso', 
                'enviado', 
                'entregado', 
                'cancelado'
            ])->default('pendiente');
            
            // Información de envío
            $table->text('notas')->nullable();
            $table->timestamp('fecha_confirmacion')->nullable();
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_entrega')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
};