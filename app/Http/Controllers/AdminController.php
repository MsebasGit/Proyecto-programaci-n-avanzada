<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Habilidad;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $materias = Materia::all() -> reverse();
        $habilidades = Habilidad::all() -> reverse();

        $editMateria = null;
        if ($request->has('edit_materia_id')) {
            $editMateria = Materia::find($request->query('edit_materia_id'));
        }

        $editHabilidad = null;
        if ($request->has('edit_habilidad_id')) {
            $editHabilidad = Habilidad::find($request->query('edit_habilidad_id'));
        }

        return view('admin', compact('materias', 'habilidades', 'editMateria', 'editHabilidad'));
    }

    public function storeMateria(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:10|unique:materias,codigo',
            'creditos' => 'required|integer|min:1',
            'nota_obtenida' => 'required|numeric|between:0,100',
        ]);

        Materia::create($validated);

        return redirect()->route('admin')->with('exito', 'Materia agregada correctamente.');
    }

    public function updateMateria(Request $request, Materia $materia)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => [
                'required',
                'string',
                'max:10',
                Rule::unique('materias', 'codigo')->ignore($materia->id),
            ],
            'creditos' => 'required|integer|min:1',
            'nota_obtenida' => 'required|numeric|between:0,100',
        ]);

        $materia->update($validated);

        return redirect()->route('admin')->with('exito', 'Materia actualizada correctamente.');
    }

    public function destroyMateria(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('admin')->with('exito', 'Materia eliminada correctamente.');
    }

    public function storeHabilidad(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'porcentaje' => 'required|integer|between:0,100',
        ]);

        Habilidad::create($validated);

        return redirect()->route('admin')->with('exito', 'Habilidad agregada correctamente.');
    }

    public function updateHabilidad(Request $request, Habilidad $habilidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'porcentaje' => 'required|integer|between:0,100',
        ]);

        $habilidad->update($validated);

        return redirect()->route('admin')->with('exito', 'Habilidad actualizada correctamente.');
    }

    public function destroyHabilidad(Habilidad $habilidad)
    {
        $habilidad->delete();

        return redirect()->route('admin')->with('exito', 'Habilidad eliminada correctamente.');
    }
}
