<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaEmpresas extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();                                    // PK
            $table->foreignId('usuario_id')                  // FK a usuarios(id_usuario)
                ->constrained('usuarios', 'id_usuario')
                ->onDelete('cascade');
            $table->string('slug')->unique();                // URL amigable
            $table->string('razon_social');                  // Nombre legal
            $table->string('nif')->nullable();               // NIF/CIF
            // Elimina la línea:
            // $table->text('datos_fiscales')->nullable();
            // Añade la relación:
            $table->unsignedBigInteger('datos_fiscales_id')->nullable();
            $table->timestamps();

            $table->foreign('datos_fiscales_id')->references('id')->on('datos_fiscales')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
