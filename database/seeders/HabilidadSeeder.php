<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habilidad;

class HabilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Habilidad::truncate();

        $habilidades = [
            ['nombre' => 'PHP', 'porcentaje' => 75],
            ['nombre' => 'HTML/CSS', 'porcentaje' => 90],
            ['nombre' => 'JavaScript', 'porcentaje' => 60],
            ['nombre' => 'Laravel', 'porcentaje' => 55],
            ['nombre' => 'GIT', 'porcentaje' => 70],
        ];

        foreach ($habilidades as $datos) {
            Habilidad::create($datos);
        }
    }
}
