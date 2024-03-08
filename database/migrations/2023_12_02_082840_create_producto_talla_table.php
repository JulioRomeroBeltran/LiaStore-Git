<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('producto_talla', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('talla_id');
            // Puedes agregar más columnas según tus necesidades

            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('talla_id')->references('id')->on('tallas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_talla');
    }
};
