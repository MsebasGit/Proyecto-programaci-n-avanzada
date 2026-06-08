<?php

namespace App\Http\Controllers;

use App\Services\SudokuService;
use Dotenv\Loader\Resolver;
use Illuminate\Http\Request;

class SudokuController extends Controller
{

    private SudokuService $sudokuService;

    public function __construct(SudokuService $sudokuService)
    {
        $this->sudokuService = $sudokuService;
    }


    public function sudoku(Request $request)
    {
        $request->validate([
            'pistas' => 'sometimes|integer|between:18,81',
        ]);

        $pistas = $request->integer('pistas', 30);

        $tableroIncompleto = $this->sudokuService->generarTablero($pistas);

        return view('sudoku', compact('tableroIncompleto'));
    }
    public function resolve(Request $request)
    {
        $tableroDelRequest = $request->input('tablero');
        $accion = $request->input('accion', 'resolver');

        if ($accion === 'verificar') {
            $esValido = $this->sudokuService->verificarConHaskell($tableroDelRequest);
            if ($esValido) {
                return back()->with('exito', '¡Felicidades! Tu solución es 100% correcta.');
            } else {
                return back()->withErrors([
                    'error_sudoku' => 'La solución es incorrecta o está incompleta. ¡Sigue intentándolo!',
                ])->withInput();
            }
        }

        // Acción por defecto: resolver automáticamente
        $tableroResuelto = $this->sudokuService->resolverConHaskell($tableroDelRequest);

        if(is_null($tableroResuelto)){
            return back()->withErrors([
                'error_haskell' => 'Hubo un problema de comunicación con el solucionador.',
            ])->onlyInput();
        }
        return redirect()->route('sudoku')->with('solucion', $tableroResuelto);
    }



}

