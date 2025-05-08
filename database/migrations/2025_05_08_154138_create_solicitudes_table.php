<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();

            // Quién envía y quién recibe la solicitud
            $table->foreignId('id_emisor')
                  ->constrained('usuarios', 'id_usuario')
                  ->onDelete('cascade');
            $table->foreignId('id_receptor')
                  ->constrained('usuarios', 'id_usuario')
                  ->onDelete('cascade');

            // Estado de la solicitud
            $table->enum('status', ['pendiente', 'aceptada', 'rechazada'])
                  ->default('pendiente');

            $table->timestamps();

            // Evitar duplicados emisor→receptor
            $table->unique(['id_emisor', 'id_receptor']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
