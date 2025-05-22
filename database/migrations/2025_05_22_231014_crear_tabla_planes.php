<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPlanes extends Migration
{
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();                                    // PK
            $table->string('nombre');                        // Nombre del plan
            $table->decimal('precio', 8, 2);                 // Precio en EUR
            $table->integer('duracion_dias');                // Duración en días
            $table->text('descripcion')->nullable();         // Descripción opcional
            $table->timestamps();                            // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('planes');
    }
}
