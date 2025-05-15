<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favoritos_prendas', function (Blueprint $table) {
            $table->id('id_favoritos_prendas');
            $table->foreignId('id_prenda')->constrained('prendas', 'id_prenda');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos_prendas');
    }
};
