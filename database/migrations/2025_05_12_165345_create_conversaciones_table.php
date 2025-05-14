<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user1_id');
            $table->unsignedBigInteger('user2_id');
            $table->timestamps();

            // Índice único para evitar duplicados en cualquier orden
            $table->unique(['user1_id', 'user2_id']);

            // Claves foráneas
            $table->foreign('user1_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('user2_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversaciones');
    }
};