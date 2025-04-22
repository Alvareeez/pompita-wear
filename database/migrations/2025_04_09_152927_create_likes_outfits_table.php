<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes_outfits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_outfit')->constrained('outfits', 'id_outfit')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_usuario', 'id_outfit']); // Evita likes duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes_outfits');
    }
};
