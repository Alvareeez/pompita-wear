<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favoritos_outfits', function (Blueprint $table) {
            $table->foreignId('id_outfit')->constrained('outfits', 'id_outfit');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->primary(['id_outfit', 'id_usuario']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos_outfits');
    }
};
