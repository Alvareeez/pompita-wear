<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPrendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_prendas')->insert([
            [
                'tipo' => 'CABEZA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'TORSO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'PIERNA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'PIE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
