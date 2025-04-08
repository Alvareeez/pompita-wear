<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrendaSeeder extends Seeder
{
    public function run()
    {
        DB::table('prendas')->insert([
            [
                'id_tipoPrenda' => 2, // TORSO
                'precio' => 29.99,
                'descripcion' => 'Camiseta básica de algodón color blanco, perfecta para el día a día.',
                'likes' => 15,
                'img_frontal' => 'camiseta_blanca_frontal.jpg',
                'img_trasera' => 'camiseta_blanca_trasera.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoPrenda' => 2, // TORSO
                'precio' => 49.99,
                'descripcion' => 'Camisa de lino azul clara, ideal para ocasiones semi-formales.',
                'likes' => 22,
                'img_frontal' => 'camisa_lino_frontal.jpg',
                'img_trasera' => 'camisa_lino_trasera.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoPrenda' => 3, // PIERNA
                'precio' => 59.99,
                'descripcion' => 'Jeans slim fit azul oscuro, estilo casual para cualquier ocasión.',
                'likes' => 34,
                'img_frontal' => 'jeans_slim_frontal.jpg',
                'img_trasera' => 'jeans_slim_trasera.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoPrenda' => 1, // CABEZA
                'precio' => 19.99,
                'descripcion' => 'Gorra deportiva negra con diseño minimalista.',
                'likes' => 8,
                'img_frontal' => 'gorra_negra_frontal.jpg',
                'img_trasera' => 'gorra_negra_trasera.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipoPrenda' => 4, // PIE
                'precio' => 89.99,
                'descripcion' => 'Zapatillas deportivas blancas, confort y estilo en cada paso.',
                'likes' => 45,
                'img_frontal' => 'zapatillas_blancas_frontal.jpg',
                'img_trasera' => 'zapatillas_blancas_trasera.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
