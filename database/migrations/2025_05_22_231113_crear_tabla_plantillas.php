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

            // FK a la tabla empresas
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');

            // FK al usuario programador
            $table->foreignId('programador_id')
                  ->constrained('usuarios', 'id_usuario')
                  ->onDelete('cascade');

            $table->string('slug')->unique();               // Para la URL pública
            $table->string('nombre');                       // Nombre de la plantilla
            $table->string('foto')->nullable();             // Ruta de la foto subida
            $table->string('enlace')->nullable();           // Enlace externo

            // Tres colores individuales
            $table->string('color_primario')->nullable();
            $table->string('color_secundario')->nullable();
            $table->string('color_terciario')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plantillas');
    }
}
