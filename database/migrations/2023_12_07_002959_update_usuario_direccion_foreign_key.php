<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support dropping foreign keys
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('usuario_direccion', function (Blueprint $table) {
            $table->dropForeign(['direccion_id']);
            $table->foreign('direccion_id')->references('id')->on('direccion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
