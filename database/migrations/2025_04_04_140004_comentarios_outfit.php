<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comentarios_outfits', function (Blueprint $table) {
            $table->id('id_comentario');
            $table->foreignId('id_outfit')->constrained('outfits', 'id_outfit');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->text('comentario');
            $table->timestamp('fecha')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios_outfits');
    }
};
