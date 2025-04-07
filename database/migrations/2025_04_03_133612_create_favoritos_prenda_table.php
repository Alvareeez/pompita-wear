<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favoritos_prendas', function (Blueprint $table) {
            $table->foreignId('id_prenda')->constrained('prendas', 'id_prenda');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->primary(['id_prenda', 'id_usuario']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos_prendas');
    }
};
