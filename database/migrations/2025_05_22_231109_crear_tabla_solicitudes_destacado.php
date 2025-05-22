<?php
// database/migrations/YYYY_MM_DD_HHMMSS_crear_tabla_solicitudes_destacado.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaSolicitudesDestacado extends Migration
{
    public function up()
    {
        Schema::create('solicitudes_destacado', function (Blueprint $table) {
            $table->id();                                                    
            $table->foreignId('empresa_id')                                  
                  ->constrained('usuarios','id_usuario')
                  ->onDelete('cascade');
            $table->foreignId('prenda_id')                                   
                  ->constrained('prendas','id_prenda')
                  ->onDelete('cascade');
            $table->foreignId('plan_id')                                     
                  ->constrained('planes','id')
                  ->onDelete('cascade');
            $table->enum('estado',['pendiente','aprobada','rechazada'])
                  ->default('pendiente');
            $table->timestamp('solicitada_en')->useCurrent();                
            $table->timestamp('aprobada_en')->nullable();                    
            $table->date('expira_en')->nullable();                           
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_destacado');
    }
}
