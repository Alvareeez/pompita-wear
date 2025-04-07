<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Ejecutar la siembra de la base de datos.
     *
     * @return void
     */
    public function run()
    {
        // Insertar los roles
        DB::table('roles')->insert([
            [
                'nombre' => 'admin',
            ],
            [
                'nombre' => 'cliente',
            ],
        ]);
    }
}
