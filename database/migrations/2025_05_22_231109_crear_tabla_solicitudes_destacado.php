<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaSolicitudesDestacado extends Migration
{
    public function up()
    {
        Schema::create('solicitudes_destacado', function (Blueprint $table) {
            $table->id();                                                    // PK
            $table->foreignId('empresa_id')                                  // FK a usuarios(id_usuario)
                  ->constrained('usuarios','id_usuario')
                  ->onDelete('cascade');
            $table->foreignId('prenda_id')                                   // FK a prendas(id_prenda)
                  ->constrained('prendas','id_prenda')
                  ->onDelete('cascade');
            $table->foreignId('plan_id')                                     // FK a planes(id)
                  ->constrained('planes')
                  ->onDelete('cascade');
            $table->enum('estado',['pendiente','aprobada','rechazada'])      // Estado de la petición
                  ->default('pendiente');
            $table->timestamp('solicitada_en')->useCurrent();                // Fecha de solicitud
            $table->timestamp('aprobada_en')->nullable();                    // Fecha de aprobación
            $table->date('expira_en')->nullable();                           // Fecha de expiración
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_destacado');
    }
}
