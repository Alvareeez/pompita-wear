<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanesSeeder extends Seeder
{
    public function run()
    {
        DB::table('planes')->insert([
            [
                'nombre'         => 'Destacado 7 días',
                'precio'         => 9.99,
                'duracion_dias'  => 7,
                'descripcion'    => 'Destaca una prenda durante 7 días',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Destacado 30 días',
                'precio'         => 24.99,
                'duracion_dias'  => 30,
                'descripcion'    => 'Destaca una prenda durante 30 días',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Plantilla web básica',
                'precio'         => 199.00,
                'duracion_dias'  => 365,
                'descripcion'    => 'Desarrollo de plantilla web para tu empresa',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
