<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstilosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estilos')->insert([
            ['nombre' => 'Casual', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Elegante', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Deportivo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Formal', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Urbano', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Vintage', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Bohemio', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Minimalista', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Clásico', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rocker', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
