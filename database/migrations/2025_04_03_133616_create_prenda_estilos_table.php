<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prenda_estilos', function (Blueprint $table) {
            $table->foreignId('id_prenda')->constrained('prendas', 'id_prenda');
            $table->foreignId('id_estilo')->constrained('estilos', 'id_estilo');
            $table->primary(['id_prenda', 'id_estilo']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prenda_estilos');
    }
};
