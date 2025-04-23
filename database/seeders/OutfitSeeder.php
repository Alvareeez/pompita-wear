<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OutfitSeeder extends Seeder
{
    public function run()
    {
        // Crear el outfit para el usuario (por ejemplo, con id_usuario = 1)
        $usuarioId = 1; // Asegúrate de que este usuario exista en la tabla usuarios

        // Insertar el outfit
        $outfitId = DB::table('outfits')->insertGetId([
            'id_usuario' => $usuarioId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Asociar las prendas con el outfit en la tabla outfit_prendas
        $prendas = [1, 16, 25, 28]; // ID de las prendas que quieres asociar al outfit

        $outfitPrendasData = [];
        foreach ($prendas as $prendaId) {
            $outfitPrendasData[] = [
                'id_outfit' => $outfitId,
                'id_prenda' => $prendaId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insertar las asociaciones en la tabla outfit_prendas
        DB::table('outfit_prendas')->insert($outfitPrendasData);
    }
}
