<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colores')->insert([
            ['nombre' => 'Rojo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Verde', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Azul', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Amarillo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Naranja', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Morado', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rosa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Marrón', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Negro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Blanco', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gris', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Celeste', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Turquesa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Beige', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Fucsia', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Violeta', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Oliva', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cian', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Magenta', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mostaza', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Verde claro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Verde oscuro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Azul claro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Azul oscuro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rosa claro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rojo oscuro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gris claro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Gris oscuro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Blanco hueso', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Negro carbón', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
