<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_prendas', function (Blueprint $table) {
            $table->id('id_tipoPrenda');
            $table->enum('tipo', ['CABEZA', 'TORSO', 'PIERNA', 'PIE']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_prendas');
    }
};