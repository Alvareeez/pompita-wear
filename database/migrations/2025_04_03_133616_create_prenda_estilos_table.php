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

        Schema::create('prenda_estilos', function (Blueprint $table) {
            $table->integer('id_prenda')->nullable();
            $table->foreign('id_prenda')->references('id_prenda')->on('prenda');
            $table->integer('id_estilo')->nullable();
            $table->foreign('id_estilo')->references('id_estilo')->on('estilos');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenda_estilos');
    }
};
