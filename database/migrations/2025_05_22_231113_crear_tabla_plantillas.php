<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPlantillas extends Migration
{
    public function up()
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id();                                    // PK
            $table->foreignId('empresa_id')                  // FK a empresas(id)
                  ->constrained('empresas')
                  ->onDelete('cascade');
            $table->foreignId('programador_id')              // FK a usuarios(id_usuario)
                  ->constrained('usuarios','id_usuario')
                  ->onDelete('cascade');
            $table->string('nombre');                        // Nombre de la plantilla
            $table->json('config');                          // Configuración JSON
            $table->enum('estado',['pendiente','aprobada','rechazada'])
                  ->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plantillas');
    }
}
