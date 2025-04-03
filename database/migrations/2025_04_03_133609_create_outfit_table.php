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

        Schema::create('outfit', function (Blueprint $table) {
            $table->integer('id_outfit')->primary()->autoIncrement();
            $table->integer('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->integer('likes')->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfit');
    }
};
