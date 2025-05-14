<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrendaEtiquetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Relacionar etiquetas con las prendas
        DB::table('prenda_etiquetas')->insert([
            ['id_prenda' => 1, 'id_etiqueta' => 1], 
            ['id_prenda' => 2, 'id_etiqueta' => 3],  
            ['id_prenda' => 3, 'id_etiqueta' => 2],  
            ['id_prenda' => 3, 'id_etiqueta' => 8], 
            ['id_prenda' => 4, 'id_etiqueta' => 2],  
            ['id_prenda' => 5, 'id_etiqueta' => 2],  
            ['id_prenda' => 6, 'id_etiqueta' => 2],  
            ['id_prenda' => 7, 'id_etiqueta' => 2],  
            ['id_prenda' => 8, 'id_etiqueta' => 1],  
            ['id_prenda' => 8, 'id_etiqueta' => 8],  
            ['id_prenda' => 9, 'id_etiqueta' => 1],  
            ['id_prenda' => 9, 'id_etiqueta' => 8],  
            ['id_prenda' => 10, 'id_etiqueta' => 2], 
            ['id_prenda' => 11, 'id_etiqueta' => 1], 
            ['id_prenda' => 12, 'id_etiqueta' => 1],
            ['id_prenda' => 13, 'id_etiqueta' => 1], 
            ['id_prenda' => 14, 'id_etiqueta' => 1], 
            ['id_prenda' => 15, 'id_etiqueta' => 1], 
            ['id_prenda' => 16, 'id_etiqueta' => 1], 
            ['id_prenda' => 17, 'id_etiqueta' => 1], 
            ['id_prenda' => 18, 'id_etiqueta' => 1], 
            ['id_prenda' => 19, 'id_etiqueta' => 2], 
            ['id_prenda' => 19, 'id_etiqueta' => 6], 
            ['id_prenda' => 20, 'id_etiqueta' => 1], 
            ['id_prenda' => 21, 'id_etiqueta' => 1], 
            ['id_prenda' => 22, 'id_etiqueta' => 9], 
            ['id_prenda' => 23, 'id_etiqueta' => 2], 
            ['id_prenda' => 24, 'id_etiqueta' => 1], 
            ['id_prenda' => 25, 'id_etiqueta' => 2], 
            ['id_prenda' => 25, 'id_etiqueta' => 6], 
            ['id_prenda' => 26, 'id_etiqueta' => 1], 
            ['id_prenda' => 27, 'id_etiqueta' => 2], 
            ['id_prenda' => 28, 'id_etiqueta' => 1], 
            ['id_prenda' => 29, 'id_etiqueta' => 2], 
            ['id_prenda' => 30, 'id_etiqueta' => 1], 
            ['id_prenda' => 31, 'id_etiqueta' => 1], 
            ['id_prenda' => 32, 'id_etiqueta' => 1], 
            ['id_prenda' => 33, 'id_etiqueta' => 9], 
            ['id_prenda' => 33, 'id_etiqueta' => 8], 
            ['id_prenda' => 34, 'id_etiqueta' => 1], 
            ['id_prenda' => 34, 'id_etiqueta' => 8], 
            ['id_prenda' => 35, 'id_etiqueta' => 9], 
            ['id_prenda' => 35, 'id_etiqueta' => 8], 
            ['id_prenda' => 36, 'id_etiqueta' => 2], 
            ['id_prenda' => 37, 'id_etiqueta' => 2], 
            ['id_prenda' => 38, 'id_etiqueta' => 2], 
            ['id_prenda' => 39, 'id_etiqueta' => 2], 
            ['id_prenda' => 39, 'id_etiqueta' => 8], 
            ['id_prenda' => 40, 'id_etiqueta' => 9], 
            ['id_prenda' => 41, 'id_etiqueta' => 2], 
            ['id_prenda' => 42, 'id_etiqueta' => 2], 
            ['id_prenda' => 43, 'id_etiqueta' => 9], 
            ['id_prenda' => 44, 'id_etiqueta' => 9], 
            ['id_prenda' => 45, 'id_etiqueta' => 9], 
            ['id_prenda' => 46, 'id_etiqueta' => 9], 
            ['id_prenda' => 47, 'id_etiqueta' => 2], 
            ['id_prenda' => 48, 'id_etiqueta' => 9], 
            ['id_prenda' => 49, 'id_etiqueta' => 9], 
            ['id_prenda' => 50, 'id_etiqueta' => 9],           
        ]);
    }
}

