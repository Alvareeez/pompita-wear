<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OutfitSeeder extends Seeder
{
    public function run()
    {
        // Definir los datos de los outfits que deseas crear
        $outfits = [
            [
                'id_usuario' => 1, // Asegúrate de que este usuario exista
                'nombre' => 'El mejor',
                'prendas' => [1, 33, 63, 86], // IDs de las prendas
            ],
            [
                'id_usuario' => 1, 
                'nombre' => 'Outfit casual',
                'prendas' => [2, 34, 64, 87], 
            ],
            [
                'id_usuario' => 2, 
                'nombre' => 'Outfit formal',
                'prendas' => [3, 35, 65, 88],
            ],
            [
                'id_usuario' => 2, 
                'nombre' => 'Outfit Joseador',
                'prendas' => [4, 36, 66, 89],
            ],
            [
                'id_usuario' => 2, 
                'nombre' => 'La Machine',
                'prendas' => [5, 36, 66, 89],
            ],
            [
                'id_usuario' => 3, 
                'nombre' => 'El vaquerito',
                'prendas' => [6, 37, 67, 90],
            ],
            [
                'id_usuario' => 3, 
                'nombre' => 'Mansion 2',
                'prendas' => [7, 38, 68, 91],
            ],
            [
                'id_usuario' => 4, 
                'nombre' => 'Outfit Boda',
                'prendas' => [8, 39, 69, 92],
            ],
            [
                'id_usuario' => 4, 
                'nombre' => 'Camionero',
                'prendas' => [9, 40, 70, 92],
            ],
            [
                'id_usuario' => 4, 
                'nombre' => 'El mejor de todos',
                'prendas' => [10, 41, 71, 93],
            ],
            [
                'id_usuario' => 5, 
                'nombre' => 'Picante',
                'prendas' => [11, 42, 72, 94],
            ],
            [
                'id_usuario' => 6, 
                'nombre' => 'Spicy Hot Hot',
                'prendas' => [12, 43, 73, 95],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Vazquez Informal',
                'prendas' => [13, 44, 74, 96],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Dia 2',
                'prendas' => [14, 45, 75, 97],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Outfit Bohemio',
                'prendas' => [15, 46, 76, 98],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Crisis Mental',
                'prendas' => [16, 47, 77, 99],
            ],
            [
                'id_usuario' => 8, 
                'nombre' => 'Lemon Haze',
                'prendas' => [17, 48, 78, 100],
            ],
             [
                'id_usuario' => 8, 
                'nombre' => 'Maquinero',
                'prendas' => [18, 42, 68, 90],
            ],
             [
                'id_usuario' => 8, 
                'nombre' => 'Outfit Muy Formal',
                'prendas' => [20, 38, 68, 101],
            ],
             [
                'id_usuario' => 11, 
                'nombre' => 'Zoco Serio',
                'prendas' => [23, 39, 63, 97],
            ],
            [
                'id_usuario' => 11, 
                'nombre' => 'Malalteo',
                'prendas' => [20, 40, 62, 89],
            ],
             [
                'id_usuario' => 16, 
                'nombre' => 'Carameleante',
                'prendas' => [34, 50, 72, 87],
            ],
            [
                'id_usuario' => 16, 
                'nombre' => 'Zoco Eric',
                'prendas' => [12, 52, 74, 86],
            ],
            [
                'id_usuario' => 17, 
                'nombre' => 'Zoco Eric',
                'prendas' => [9, 53, 76, 88],
            ],
        ];

        foreach ($outfits as $outfitData) {
            // Insertar el outfit
            $outfitId = DB::table('outfits')->insertGetId([
                'id_usuario' => $outfitData['id_usuario'],
                'nombre' => $outfitData['nombre'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Asociar las prendas con el outfit en la tabla outfit_prendas
            $outfitPrendasData = [];
            foreach ($outfitData['prendas'] as $prendaId) {
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
}