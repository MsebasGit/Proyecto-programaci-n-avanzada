<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar la tabla antes de insertar (útil para volver a ejecutar el seeder sin duplicados)
        Materia::truncate();

        $materias = [
            ['nombre' => 'Programación Avanzada', 'codigo' => 'SIS-500', 'creditos' => 5, 'nota_obtenida' => 82.0],
            ['nombre' => 'Base de Datos II', 'codigo' => 'SIS-480', 'creditos' => 4, 'nota_obtenida' => 71.0],
            ['nombre' => 'Redes de Computadoras', 'codigo' => 'SIS-460', 'creditos' => 4, 'nota_obtenida' => 68.0],
            ['nombre' => 'Inglés Técnico', 'codigo' => 'ING-300', 'creditos' => 3, 'nota_obtenida' => 45.0],
        ];

        foreach ($materias as $datos) {
            Materia::create($datos);
        }
    }
}
