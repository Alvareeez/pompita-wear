<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDestacadaToPrendasTable extends Migration
{
    public function up()
    {
        Schema::table('prendas', function (Blueprint $table) {
            // Campo booleano: true = destacada
            $table->boolean('destacada')
                  ->default(false)
                  ->after('img_trasera');

            // Opcional: fecha hasta la cual está destacada
            $table->date('destacado_hasta')
                  ->nullable()
                  ->after('destacada');
        });
    }

    public function down()
    {
        Schema::table('prendas', function (Blueprint $table) {
            $table->dropColumn(['destacada', 'destacado_hasta']);
        });
    }
}
