<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrendaVistasTable extends Migration
{
    public function up()
    {
        Schema::create('prenda_vistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prenda_id')
                  ->constrained('prendas', 'id_prenda')
                  ->onDelete('cascade');
            $table->foreignId('id_usuario')->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->onDelete('set null');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('prenda_vistas');
    }
}
