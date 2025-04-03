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

        Schema::create('favoritos_prenda', function (Blueprint $table) {
            $table->integer('id_prenda')->nullable();
            $table->foreign('id_prenda')->references('id_prenda')->on('prenda');
            $table->integer('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos_prenda');
    }
};
