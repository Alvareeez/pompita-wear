<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversacion_id')
                  ->constrained('conversaciones')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('emisor_id');
            $table->text('contenido');
            $table->timestamp('enviado_en')->useCurrent();
            $table->timestamps();

            // Clave foránea al usuario emisor
            $table->foreign('emisor_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensajes');
    }
};
