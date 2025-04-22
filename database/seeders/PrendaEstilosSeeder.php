<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrendaEstilosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prenda_estilos')->insert([
            ['id_prenda' => 1, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 2, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 3, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 3, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 3, 'id_estilo' => 5, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 4, 'id_estilo' => 6, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 4, 'id_estilo' => 8, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 5, 'id_estilo' => 6, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 5, 'id_estilo' => 9, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 6, 'id_estilo' => 4, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 7, 'id_estilo' => 2, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 8, 'id_estilo' => 2, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 9, 'id_estilo' => 2, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 10, 'id_estilo' => 5, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 11, 'id_estilo' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 12, 'id_estilo' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 13, 'id_estilo' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 14, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 15, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 16, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 17, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 17, 'id_estilo' => 5, 'created_at' => now(), 'updated_at' => now()],         
            ['id_prenda' => 18, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 18, 'id_estilo' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 18, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 19, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 20, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 21, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 22, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 23, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 24, 'id_estilo' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 24, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 24, 'id_estilo' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 25, 'id_estilo' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 26, 'id_estilo' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 27, 'id_estilo' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 28, 'id_estilo' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 29, 'id_estilo' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
