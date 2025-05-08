<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitudesSeeder extends Seeder
{
    /**
     * Ejecutar la siembra de solicitudes de seguimiento.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solicitudes')->insert([
            [
                'id_emisor'   => 2,              // Cliente Ejemplo
                'id_receptor' => 3,              // Cliente Secundario
                'status'      => 'pendiente',    // solicitud en espera
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_emisor'   => 3,              // Cliente Secundario
                'id_receptor' => 2,              // Cliente Ejemplo
                'status'      => 'aceptada',     // ya se sigue mutuamente
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
