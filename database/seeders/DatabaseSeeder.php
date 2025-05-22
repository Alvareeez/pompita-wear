<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsuariosSeeder::class,
            TipoPrendasSeeder::class,
            EstilosSeeder::class,
            ColoresSeeder::class,
            EtiquetasSeeder::class,
            PrendaSeeder::class,
            PrendaColoresSeeder::class,
            PrendaEstilosSeeder::class,
            PrendaEtiquetasSeeder::class,
            OutfitSeeder::class,
            SolicitudesSeeder::class,
            PlanesSeeder::class,
        ]);
    }
    
}
