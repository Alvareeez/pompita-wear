<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seguidores', function (Blueprint $table) {
            $table->id('id_seguimiento');
            $table->foreignId('id_seguidor')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_seguido')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
            $table->timestamps();

            $table->unique(['id_seguidor', 'id_seguido']); // Evita duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('seguidores');
    }
};
