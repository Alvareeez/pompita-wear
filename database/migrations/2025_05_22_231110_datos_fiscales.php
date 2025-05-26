<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('datos_fiscales', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('nif');
            $table->string('direccion');
            $table->string('cp');
            $table->string('ciudad');
            $table->string('provincia');
            $table->string('pais');
            $table->timestamps();
        });

        // Si la tabla empresas ya existe, añade la columna y la clave foránea
        if (Schema::hasTable('empresas')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->unsignedBigInteger('datos_fiscales_id')->nullable()->after('nif');
                $table->foreign('datos_fiscales_id')->references('id')->on('datos_fiscales')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        // Elimina la clave foránea y la columna de empresas si existe
        if (Schema::hasTable('empresas')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->dropForeign(['datos_fiscales_id']);
                $table->dropColumn('datos_fiscales_id');
            });
        }
        Schema::dropIfExists('datos_fiscales');
    }
};
