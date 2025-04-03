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
        Schema::disableForeignKeyConstraints();

        Schema::create('prenda_colores', function (Blueprint $table) {
            $table->integer('id_prenda')->nullable();
            $table->foreign('id_prenda')->references('id_prenda')->on('prenda');
            $table->integer('id_color')->nullable();
            $table->foreign('id_color')->references('id_color')->on('colores');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenda_colores');
    }
};
