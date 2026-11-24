<?php

namespace Database\Seeders;

use App\Models\Comercio;
use App\Models\Repartidor;
use App\Models\TipoComercio;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            CiudadZonaSeeder::class,
            TipoComercioSeeder::class,
        ]);

        User::firstOrCreate(
            ['correo' => 'admin@pideya.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'PideYa',
                'password' => 'Admin123',
                'rol' => 'admin',
                'telefono' => '99999999',
                'activo' => true,
            ]
        );

        $usuarioComercio = User::firstOrCreate(
            ['correo' => 'comercio@pideya.com'],
            [
                'nombre' => 'Comercio',
                'apellido' => 'Demo',
                'password' => 'Comercio123',
                'rol' => 'comercio',
                'telefono' => '88888888',   // <-- aquí
                'activo' => true,
            ]
        );

        $usuarioRepartidor = User::firstOrCreate(
            ['correo' => 'repartidor@pideya.com'],
            [
                'nombre' => 'Repartidor',
                'apellido' => 'Demo',
                'password' => 'Repartidor123',
                'rol' => 'repartidor',
                'telefono' => '77777777',   // <-- aquí
                'activo' => true,
            ]
        );

        User::firstOrCreate(
            ['correo' => 'cliente@pideya.com'],
            [
                'nombre' => 'Cliente',
                'apellido' => 'Demo',
                'password' => 'Cliente123',
                'rol' => 'cliente',
                'telefono' => '66666666',   // <-- aquí
                'activo' => true,
            ]
        );

        Comercio::firstOrCreate(
            ['id_usuario' => $usuarioComercio->id_usuario],
            [
                'id_tipo_comercio' => TipoComercio::first()->id_tipo_comercio,
                'nombre' => 'Restaurante Demo',
                'rtn' => '08011990123456',
                'descripcion' => 'Comercio de prueba para el desarrollo del proyecto.',
                'estado_aprobacion' => 'aprobado',
            ]
        );

        Repartidor::firstOrCreate(
            ['id_usuario' => $usuarioRepartidor->id_usuario],
            [
                'id_zona' => Zona::first()->id_zona,
                'estado_aprobacion' => 'aprobado',
            ]
        );
    }
}