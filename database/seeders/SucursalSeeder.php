<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear la sucursal fija
        Sucursal::firstOrCreate(
            ['nombre' => 'LA VILLA'],
            [
                'direccion' => 'Av. Cumavi Barrio San juan',
                'telefono' => '76658532',
                'estado' => true,
            ]
        );

        // 2. Crear las 3 aleatorias adicionales
        Sucursal::factory()->count(3)->create();
    }
}
