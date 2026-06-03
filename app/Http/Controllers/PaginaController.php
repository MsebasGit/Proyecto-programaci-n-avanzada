<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Contacto;

/**
 * PaginaController
 * * Gestiona las 5 páginas del proyecto final SIS-500.
 * Conectado a routes/web.php mediante las 5 rutas definidas en el Ejercicio 3.
 * * Estado: STUB — métodos con respuesta provisional.
 * Los métodos se completan el Día 13.
 */
class PaginaController extends Controller
{
    /**
     * RUTA: GET /
     * DÍA 12: cambiar 'welcome' por 'inicio' y pasar datos del estudiante.
     */
    public function inicio()
    {
        return view('inicio', [
            'nombre' => 'Medrano Sebastian',
            'carrera' => 'Ingeniería de Sistemas',
            'semestre' => 'Sexto semestre',
            'año' => date('Y'),
        ]);
    }

    /**
     * RUTA: GET /sobre-mi
     * Pasar habilidades y datos personales a la vista.
     */
    public function sobreMi()
    {
        $habilidades = [
            'PHP' => 75,
            'HTML/CSS' => 90,
            'JavaScript' => 60,
            'Laravel' => 55,
            'GIT' => 70,
        ];

        return view('sobre-mi', [
            'nombre' => 'Medrano Sebastian',
            'carrera' => 'Ingeniería de Sistemas',
            'semestre' => 'Sexto semestre',
            'habilidades' => $habilidades,
        ]);
    }

    /**
     * RUTA: GET /materias
     * Pasar arreglo de materias, calcular promedio y aprobadas.
     */
    public function materias()
    {
        // ANTES (Parte 2): instanciaba objetos manualmente con new Materia(...)
        // AHORA (Parte 3): Eloquent recupera todos los registros de la tabla 'materias'
        // La interfaz pública de Materia es IDÉNTICA — la vista no necesita cambios.
        $materias = Materia::all();

        // avg() devuelve null si la colección está vacía → ?? 0 evita el error.
        $promedio = round($materias->avg(fn(Materia $m) => $m->getNota()) ?? 0, 2);
        $aprobadas = $materias->filter(fn(Materia $m) => $m->estaAprobada())->count();

        return view('materias', compact('materias', 'promedio', 'aprobadas'));
    }

    /**
     * RUTA: GET /contacto
     * Retorna la vista del formulario.
     */
    public function contacto()
    {
        return view('contacto');
    }

    /**
     * RUTA: POST /contacto
     * Validar entrada del formulario de contacto y redirigir con mensaje flash.
     */
    public function procesarContacto(Request $request)
    {
        // validate() reemplaza TODO el bloque de validación manual de PHP puro.
        // Si falla: Laravel redirige automáticamente al formulario con $errors disponible en Blade.
        // Si pasa: la ejecución continúa normalmente hacia el redirect.
        $validated = $request->validate([
            'nombre'  => 'required|min:3|max:100',
            'email'   => 'required|email',
            'mensaje' => 'required|min:10',
        ]);
        // Guardar el mensaje en la base de datos
        Contacto::create($validated);

        return redirect()->route('contacto')
            ->with('exito', 'Tu mensaje fue enviado correctamente.');
    }
}
