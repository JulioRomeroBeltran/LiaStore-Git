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
        Schema::table('colores', function (Blueprint $table) {
            $table->string('codigo')->after('nombre')->nullable(); // Agrega el campo 'codigo' después del campo 'nombre'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colores', function (Blueprint $table) {
            $table->dropColumn('codigo'); // Elimina el campo 'codigo' si se revierte la migración
        });
    }
};
