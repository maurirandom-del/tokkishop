<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_tallas_table.php
    public function up()
    {
        Schema::create('tallas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_talla')->primary()->startingValue(2020); // Cambiado a unsignedBigInteger
            $table->enum('talla', ['XS', 'S', 'M', 'L', 'XL', 'XXL','Unitalla'])->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tallas');
    }
};
