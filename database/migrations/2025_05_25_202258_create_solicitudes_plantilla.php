<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('solicitudes_plantilla', function (Blueprint $table) {
            $table->id();

            // FK a empresas
            $table->foreignId('empresa_id')
                  ->constrained('empresas')
                  ->onDelete('cascade');

            // FK a planes
            $table->foreignId('plan_id')
                  ->constrained('planes')
                  ->onDelete('cascade');

            // Datos de la plantilla
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->string('foto')->nullable();
            $table->string('enlace')->nullable();
            $table->string('color_primario')->nullable();
            $table->string('color_secundario')->nullable();
            $table->string('color_terciario')->nullable();

            // Estado y timestamps de solicitud/procesado
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])
                  ->default('pendiente');
            $table->timestamp('solicitada_en')->useCurrent();
            $table->timestamp('procesada_en')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_plantilla');
    }
};
