<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitudesSeeder extends Seeder
{
    public function run()
    {
        // Obtén los IDs reales de la tabla usuarios
        $usuarios = DB::table('usuarios')->pluck('id_usuario')->toArray();
        $solicitudes = [];

        foreach ($usuarios as $emisor) {
            // Selecciona al menos dos receptores distintos al emisor
            $receptores = collect($usuarios)->where('id_usuario', '!=', $emisor)->shuffle()->take(10)->values();

            // Solicitud pendiente
            $solicitudes[] = [
                'id_emisor'   => $emisor,
                'id_receptor' => $receptores[0],
                'status'      => 'pendiente',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
            // Solicitud aceptada
            $solicitudes[] = [
                'id_emisor'   => $emisor,
                'id_receptor' => $receptores[1],
                'status'      => 'aceptada',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
            // Opcional: más solicitudes pendientes y aceptadas
            $solicitudes[] = [
                'id_emisor'   => $emisor,
                'id_receptor' => $receptores[2],
                'status'      => 'pendiente',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
            $solicitudes[] = [
                'id_emisor'   => $emisor,
                'id_receptor' => $receptores[3],
                'status'      => 'aceptada',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('solicitudes')->insert($solicitudes);
    }
}
