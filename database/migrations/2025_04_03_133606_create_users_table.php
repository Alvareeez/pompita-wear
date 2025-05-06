<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->foreignId('id_rol')->nullable()->constrained('roles', 'id_rol');
            $table->text('foto_perfil')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
