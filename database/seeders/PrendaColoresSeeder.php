<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrendaColoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prenda_colores')->insert([
            ['id_prenda' => 1, 'id_color' => 10, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 2, 'id_color' => 3, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 3, 'id_color' => 27, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 3, 'id_color' => 28, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 4, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 5, 'id_color' => 10, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 6, 'id_color' => 21, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 6, 'id_color' => 22, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 7, 'id_color' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 8, 'id_color' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 9, 'id_color' => 1, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 10, 'id_color' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 11, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()], 
            ['id_prenda' => 12, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 13, 'id_color' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 13, 'id_color' => 23, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 14, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 15, 'id_color' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 15, 'id_color' => 23, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 16, 'id_color' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 16, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 17, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 18, 'id_color' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 18, 'id_color' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 19, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 20, 'id_color' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 21, 'id_color' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 22, 'id_color' => 22, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 24, 'id_color' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 24, 'id_color' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 23, 'id_color' => 19, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 25, 'id_color' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 26, 'id_color' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 27, 'id_color' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 28, 'id_color' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['id_prenda' => 29, 'id_color' => 14, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
