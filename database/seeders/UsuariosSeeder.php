<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Ejecutar la siembra de la base de datos.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'nombre'         => 'Admin Principal',
                'email'          => 'admin@pompitawear.com',
                'password'       => Hash::make('qweQWE123'),
                'id_rol'         => 1,
                'foto_perfil'    => null,
                'estado'         => 'activo',
                'is_private'     => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Cliente Ejemplo',
                'email'          => 'cliente@pompitawear.com',
                'password'       => Hash::make('qweQWE123'),
                'id_rol'         => 2,
                'foto_perfil'    => null,
                'estado'         => 'activo',    
                'is_private'     => false,       
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Cliente Secundario',
                'email'          => 'cliente2@pompitawear.com',
                'password'       => Hash::make('qweQWE123'),
                'id_rol'         => 2,
                'foto_perfil'    => null,
                'estado'         => 'activo',    
                'is_private'     => false,       
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
