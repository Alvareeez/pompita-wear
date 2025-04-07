<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('valoraciones_outfits', function (Blueprint $table) {
            $table->id('id_valoracion');
            $table->foreignId('id_outfit')->constrained('outfits', 'id_outfit');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->integer('puntuacion')->checkBetween(1, 5);
            $table->timestamps();

            $table->unique(['id_outfit', 'id_usuario']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('valoraciones_outfits');
    }
};
