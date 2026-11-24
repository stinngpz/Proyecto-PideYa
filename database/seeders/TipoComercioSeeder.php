<?php

namespace Database\Seeders;

use App\Models\TipoComercio;
use Illuminate\Database\Seeder;

class TipoComercioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Hamburguesas' => 'hamburguesa',
            'Pizza' => 'pizza',
            'Saludable' => 'ensalada',
            'Postres' => 'postre',
            'Pollo' => 'pollo',
        ];

        foreach ($tipos as $nombre => $icono) {
            TipoComercio::firstOrCreate(['nombre' => $nombre], ['icono' => $icono]);
        }
    }
}