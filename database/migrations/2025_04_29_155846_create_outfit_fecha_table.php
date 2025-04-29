<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('outfit_fecha', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outfit_id');
            $table->date('fecha');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('outfit_id')->references('id_outfit')->on('outfits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('outfit_fecha');
    }
};
