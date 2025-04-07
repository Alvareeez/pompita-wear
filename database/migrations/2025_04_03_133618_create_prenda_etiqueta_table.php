<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prenda_etiquetas', function (Blueprint $table) {
            $table->foreignId('id_prenda')->constrained('prendas', 'id_prenda');
            $table->foreignId('id_etiqueta')->constrained('etiquetas', 'id_etiqueta');
            $table->primary(['id_prenda', 'id_etiqueta']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prenda_etiquetas');
    }
};
