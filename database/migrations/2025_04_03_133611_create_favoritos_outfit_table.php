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

        Schema::create('favoritos_outfit', function (Blueprint $table) {
            $table->integer('id_outfit')->nullable();
            $table->foreign('id_outfit')->references('id_outfit')->on('outfit');
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
        Schema::dropIfExists('favoritos_outfit');
    }
};
