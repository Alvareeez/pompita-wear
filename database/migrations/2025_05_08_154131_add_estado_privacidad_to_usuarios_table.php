<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoPrivacidadToUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Estado: activo, inactivo, baneado
            $table->enum('estado', ['activo', 'inactivo', 'baneado'])
                  ->default('activo')
                  ->after('provider_id');

            // Privacidad: false = público, true = privado
            $table->boolean('is_private')
                  ->default(false)
                  ->after('estado');
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['estado', 'is_private']);
        });
    }
}
