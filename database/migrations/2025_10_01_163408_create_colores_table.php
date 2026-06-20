<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('colores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_color')->primary()->startingValue(1000); // Cambiado a unsignedBigInteger
            $table->string('nombre', 30)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colores');
    }
};
