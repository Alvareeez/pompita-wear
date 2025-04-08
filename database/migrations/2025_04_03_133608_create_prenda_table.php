<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prendas', function (Blueprint $table) {
            $table->id('id_prenda');
            $table->foreignId('id_tipoPrenda')->nullable()->constrained('tipo_prendas', 'id_tipoPrenda');
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->text('descripcion')->nullable();
            $table->integer('likes')->nullable()->default(0);
            $table->string('img_frontal')->nullable();
            $table->string('img_trasera')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prendas');
    }
};
