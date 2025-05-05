<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeguimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seguidores')->insert([
            [
                'id_seguidor' => 1, // Admin Principal sigue a Cliente Ejemplo
                'id_seguido' => 2,
                'estado' => 'aceptado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_seguidor' => 2, // Cliente Ejemplo sigue a Cliente Secundario
                'id_seguido' => 3,
                'estado' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_seguidor' => 3, // Cliente Secundario sigue a Admin Principal
                'id_seguido' => 1,
                'estado' => 'rechazado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
