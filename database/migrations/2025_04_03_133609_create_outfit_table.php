<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('outfits', function (Blueprint $table) {
            $table->id('id_outfit');
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario');
            $table->integer('likes')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outfits');
    }
};
