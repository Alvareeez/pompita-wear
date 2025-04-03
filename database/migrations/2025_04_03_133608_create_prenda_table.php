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

        Schema::create('prenda', function (Blueprint $table) {
            $table->integer('id_prenda')->primary()->autoIncrement();
            $table->integer('id_tipoPrenda')->nullable();
            $table->foreign('id_tipoPrenda')->references('id_tipoPrenda')->on('tipo_prenda');
            $table->decimal('precio', 10, 2);
            $table->text('descripcion')->nullable();
            $table->integer('likes')->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenda');
    }
};
