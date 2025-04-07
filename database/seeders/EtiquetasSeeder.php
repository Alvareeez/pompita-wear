<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etiquetas')->insert([
            ['nombre' => 'Algodón', 'descripcion' => 'Tejido natural, suave y transpirable.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Poliéster', 'descripcion' => 'Fibra sintética resistente y duradera.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Lino', 'descripcion' => 'Material natural fresco y ligero.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Seda', 'descripcion' => 'Tejido natural suave y lujoso.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Lana', 'descripcion' => 'Fibra natural cálida y aislante.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Nylon', 'descripcion' => 'Fibra sintética ligera y resistente.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rayón', 'descripcion' => 'Fibra semisintética suave y fluida.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Spandex', 'descripcion' => 'Material elástico que proporciona flexibilidad.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Denim', 'descripcion' => 'Tejido resistente usado comúnmente en jeans.', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Franela', 'descripcion' => 'Tejido suave ideal para climas fríos.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
