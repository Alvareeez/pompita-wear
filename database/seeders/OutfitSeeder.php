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
                'prendas' => [63, 1, 33, 86], // IDs de las prendas
            ],
            [
                'id_usuario' => 1, 
                'nombre' => 'Outfit casual',
                'prendas' => [64, 2, 34, 87], 
            ],
            [
                'id_usuario' => 2, 
                'nombre' => 'Outfit formal',
                'prendas' => [65, 3, 35, 88],
            ],
            [
                'id_usuario' => 2, 
                'nombre' => 'Outfit Joseador',
                'prendas' => [66, 4, 36, 89],
            ],
            [
                'id_usuario' => 2, 
                'nombre' => 'La Machine',
                'prendas' => [66, 5, 36, 89],
            ],
            [
                'id_usuario' => 3, 
                'nombre' => 'El vaquerito',
                'prendas' => [67, 6, 37, 90],
            ],
            [
                'id_usuario' => 3, 
                'nombre' => 'Mansion 2',
                'prendas' => [68, 7, 38, 91],
            ],
            [
                'id_usuario' => 4, 
                'nombre' => 'Outfit Boda',
                'prendas' => [69, 8, 39, 92],
            ],
            [
                'id_usuario' => 4, 
                'nombre' => 'Camionero',
                'prendas' => [70, 9, 40, 92],
            ],
            [
                'id_usuario' => 4, 
                'nombre' => 'El mejor de todos',
                'prendas' => [71, 10, 41, 93],
            ],
            [
                'id_usuario' => 5, 
                'nombre' => 'Picante',
                'prendas' => [72, 11, 42, 94],
            ],
            [
                'id_usuario' => 6, 
                'nombre' => 'Spicy Hot Hot',
                'prendas' => [73, 12, 43, 95],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Vazquez Informal',
                'prendas' => [74, 13, 44, 96],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Dia 2',
                'prendas' => [75, 14, 45, 97],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Outfit Bohemio',
                'prendas' => [76, 15, 46, 98],
            ],
            [
                'id_usuario' => 7, 
                'nombre' => 'Crisis Mental',
                'prendas' => [77, 16, 47, 99],
            ],
            [
                'id_usuario' => 8, 
                'nombre' => 'Lemon Haze',
                'prendas' => [78, 17, 48, 100],
            ],
             [
                'id_usuario' => 8, 
                'nombre' => 'Maquinero',
                'prendas' => [68, 18, 42, 90],
            ],
             [
                'id_usuario' => 8, 
                'nombre' => 'Outfit Muy Formal',
                'prendas' => [68, 20, 38, 101],
            ],
             [
                'id_usuario' => 11, 
                'nombre' => 'Zoco Serio',
                'prendas' => [63, 23, 39, 97],
            ],
            [
                'id_usuario' => 11, 
                'nombre' => 'Malalteo',
                'prendas' => [65, 2, 33, 89],
            ],
             [
                'id_usuario' => 16, 
                'nombre' => 'Carameleante',
                'prendas' => [72, 30, 41, 87],
            ],
            [
                'id_usuario' => 16, 
                'nombre' => 'Zoco Eric',
                'prendas' => [74, 12, 52, 86],
            ],
            [
                'id_usuario' => 17, 
                'nombre' => 'Zoco Eric',
                'prendas' => [76, 9, 53, 88],
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

    // Inicializar el array para las prendas del outfit actual
    $outfitPrendasData = [];

    // Asociar las prendas con el outfit en la tabla outfit_prendas
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