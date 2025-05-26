<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('datos_fiscales', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('nif');
            $table->string('direccion');
            $table->string('cp');
            $table->string('ciudad');
            $table->string('provincia');
            $table->string('pais');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('datos_fiscales');
    }
};
