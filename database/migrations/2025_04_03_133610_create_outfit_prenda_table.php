<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('outfit_prendas', function (Blueprint $table) {
            $table->id('id_outfit_prenda');
            $table->foreignId('id_outfit')->nullable()->constrained('outfits', 'id_outfit');
            $table->foreignId('id_prenda')->nullable()->constrained('prendas', 'id_prenda');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outfit_prendas');
    }
};
