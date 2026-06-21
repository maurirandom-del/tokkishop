<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_metodos_pago_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id('id_metodo_pago');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['tarjeta_credito', 'tarjeta_debito', 'paypal', 'transferencia']);
            $table->string('titular', 150);
            $table->string('numero_tarjeta', 20)->nullable(); // Últimos 4 dígitos
            $table->string('fecha_vencimiento', 7)->nullable(); // MM/YYYY
            $table->string('cvv', 4)->nullable();
            $table->boolean('es_principal')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metodos_pago');
    }
};