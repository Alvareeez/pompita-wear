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
            // TORSO
            ['id_prenda' => 1, 'id_etiqueta' => 1], // Camiseta Mickey Mouse Blanca - Algodón
            ['id_prenda' => 2, 'id_etiqueta' => 3], // Camisa azul clara con estampados - Lino
            ['id_prenda' => 3, 'id_etiqueta' => 1], // Sudadera PSG - Algodón
            ['id_prenda' => 4, 'id_etiqueta' => 1], // Sudadera negra PONY - Algodón
            ['id_prenda' => 5, 'id_etiqueta' => 1], // Sudadera estampada capucha - Algodón
            ['id_prenda' => 6, 'id_etiqueta' => 1], // Sudadera verde QUEENS - Algodón
            ['id_prenda' => 7, 'id_etiqueta' => 1], // Sudadera Le Studio - Algodón
            ['id_prenda' => 8, 'id_etiqueta' => 1], // Sudadera Villa Club - Algodón
            ['id_prenda' => 9, 'id_etiqueta' => 1], // Sudadera bordada roja - Algodón
            ['id_prenda' => 10, 'id_etiqueta' => 1], // Sudadera Paris Saint-Germain Blanco - Algodón
            ['id_prenda' => 11, 'id_etiqueta' => 1], // Camiseta Paris Saint-Germain Negra - Algodón
            ['id_prenda' => 12, 'id_etiqueta' => 1], // Jersey punto cremallera - Algodón

            // PIERNA
            ['id_prenda' => 13, 'id_etiqueta' => 9], // Jeans Comfort Skinny Premium - Denim
            ['id_prenda' => 14, 'id_etiqueta' => 9], // Jeans jogger rotos negros - Denim
            ['id_prenda' => 15, 'id_etiqueta' => 9], // Jeans jogger rotos vaqueros - Denim
            ['id_prenda' => 16, 'id_etiqueta' => 9], // Pantalón chándal Paris Saint-Germain - Denim
            ['id_prenda' => 17, 'id_etiqueta' => 9], // Pantalón chándal interlock - Denim
            ['id_prenda' => 18, 'id_etiqueta' => 9], // Bermuda Paris Saint-Germain negra - Denim
            ['id_prenda' => 19, 'id_etiqueta' => 9], // Bermuda elástica deportiva - Denim
            ['id_prenda' => 20, 'id_etiqueta' => 9], // Bermuda denim relaxed - Denim
            ['id_prenda' => 21, 'id_etiqueta' => 9], // Bermuda jogger estructura Azul - Denim
            ['id_prenda' => 22, 'id_etiqueta' => 9], // Bermuda jogger estructura Verde - Denim

            // CABEZA
            ['id_prenda' => 23, 'id_etiqueta' => 6], // Gorra Dragon Ball ©Bird Studio - Nylon
            ['id_prenda' => 24, 'id_etiqueta' => 6], // Gorra Brooklyn Nets NBA Blanca y Negra - Nylon
            ['id_prenda' => 25, 'id_etiqueta' => 6], // Gafas básicas efecto carey - Nylon

            // PIE
            ['id_prenda' => 26, 'id_etiqueta' => 7], // Botín deportivo Avia - Nylon
            ['id_prenda' => 27, 'id_etiqueta' => 6], // Chancla baño negras - Nylon
            ['id_prenda' => 28, 'id_etiqueta' => 6], // Zapato náutico piel - Piel
            ['id_prenda' => 29, 'id_etiqueta' => 6], // Zapato náutico piel - Piel
        ]);
    }
}

