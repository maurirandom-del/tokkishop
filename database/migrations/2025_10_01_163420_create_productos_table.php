<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // database/migrations/xxxx_create_productos_table.php
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('imagen_url', 255)->nullable();
            
            $table->unsignedBigInteger('id_talla');
            $table->unsignedBigInteger('id_color');
            $table->unsignedBigInteger('id_categoria');
            
            $table->timestamps();
            
            $table->foreign('id_talla')
                ->references('id_talla')
                ->on('tallas')
                ->onDelete('cascade');
                
            $table->foreign('id_color')
                ->references('id_color')
                ->on('colores')
                ->onDelete('cascade');
                
            $table->foreign('id_categoria')
                ->references('id_categoria')
                ->on('categorias')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
