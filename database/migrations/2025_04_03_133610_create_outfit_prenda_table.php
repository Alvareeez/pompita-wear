<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('outfit_prenda', function (Blueprint $table) {
            $table->integer('id_outfit_prenda')->primary()->autoIncrement();
            $table->integer('id_outfit')->nullable();
            $table->foreign('id_outfit')->references('id_outfit')->on('outfit');
            $table->integer('id_prenda')->nullable();
            $table->foreign('id_prenda')->references('id_prenda')->on('prenda');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfit_prenda');
    }
};
