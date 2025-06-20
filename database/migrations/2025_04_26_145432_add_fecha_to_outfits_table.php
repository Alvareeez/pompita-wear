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
        Schema::table('outfits', function (Blueprint $table) {
            $table->date('fecha')->nullable(); // Agregar campo de fecha
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outfits', function (Blueprint $table) {
            //
        });
    }
};
