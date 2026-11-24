<?php

namespace Database\Seeders;

use App\Models\Ciudad;
use Illuminate\Database\Seeder;

class CiudadZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datos = [
            'Tegucigalpa' => [
                'Colonia Kennedy',
                'Colonia Palmira',
                'Lomas del Guijarro',
                'Colonia Miraflores',
                'Barrio La Hoya',
                'Colonia Las Colinas',
                'Residencial El Trapiche',
            ],
            'Comayagüela' => [
                'Barrio Abajo',
                'Colonia Villa Nueva',
                'Colonia 21 de Octubre',
                'Colonia San Miguel',
            ],
            'San Pedro Sula' => [
                'Barrio Guamilito',
                'Colonia Trejo',
                'Residencial Los Álamos',
                'Colonia Satélite',
                'Barrio Suyapa',
            ],
        ];

        foreach ($datos as $nombreCiudad => $zonas) {
            $ciudad = Ciudad::firstOrCreate(['nombre' => $nombreCiudad]);

            foreach ($zonas as $nombreZona) {
                $ciudad->zonas()->firstOrCreate(['nombre' => $nombreZona]);
            }
        }
    }
}