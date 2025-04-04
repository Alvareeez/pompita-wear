<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes_comentarios_prendas', function (Blueprint $table) {
            $table->id('id_like');
            $table->foreignId('id_comentario')->constrained('comentarios_prendas', 'id_comentario');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->timestamps();

            $table->unique(['id_comentario', 'id_usuario']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes_comentarios_prendas');
    }
};
