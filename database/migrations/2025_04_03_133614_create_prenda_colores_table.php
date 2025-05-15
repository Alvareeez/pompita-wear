<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prenda_colores', function (Blueprint $table) {
            $table->id('id_prenda_colores');
            $table->foreignId('id_prenda')->constrained('prendas', 'id_prenda');
            $table->foreignId('id_color')->constrained('colores', 'id_color');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prenda_colores');
    }
};
