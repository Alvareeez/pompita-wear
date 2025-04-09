<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes_prendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_prenda')->constrained('prendas', 'id_prenda')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_usuario', 'id_prenda']); // Evita likes duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes_prendas');
    }
};
