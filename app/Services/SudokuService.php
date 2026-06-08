<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;

class SudokuService
{
    /**
     * Semilla: Un tablero de Sudoku 9x9 válido y resuelto.
     * A partir de este, generaremos miles de variantes.
     */
    private array $semilla = [
        [4, 3, 5, 2, 6, 9, 7, 8, 1],
        [6, 8, 2, 5, 7, 1, 4, 9, 3],
        [1, 9, 7, 8, 3, 4, 5, 6, 2],
        [8, 2, 6, 1, 9, 5, 3, 4, 7],
        [3, 7, 4, 6, 8, 2, 9, 1, 5],
        [9, 5, 1, 7, 4, 3, 6, 2, 8],
        [5, 1, 9, 3, 2, 6, 8, 7, 4],
        [2, 4, 8, 9, 5, 7, 1, 3, 6],
        [7, 6, 3, 4, 1, 8, 2, 5, 9]
    ];

    /**
     * Genera un nuevo tablero incompleto.
     * @param int $pistasRestantes Cantidad de números que se mostrarán al usuario.
     */
    public function generarTablero(int $pistasRestantes = 30): array
    {
        $tablero = $this->semilla;

        $tablero = $this->mezclarNumeros($tablero);
        $tablero = $this->mezclarFilasPorBloque($tablero);
        $tablero = $this->perforarTablero($tablero, $pistasRestantes);

        return $tablero;
    }

    /**
     * Se encarga de llamar al ejecutable de Haskell usando la fachada Process.
     */
    public function resolverConHaskell(array $tableroWeb): ?array
    {
        $pistas = [];

        // 1. Convertimos la matriz bidimensional al formato que espera Haskell (Fila, Columna, Valor)
        // Usamos índices base 1 (del 1 al 9) porque es más natural para tu lógica DPLL en Haskell.
        foreach ($tableroWeb as $filaIndex => $fila) {
            foreach ($fila as $colIndex => $valor) {
                if (!empty($valor) && $valor != 0) {
                    $pistas[] = [
                        'f' => $filaIndex + 1,
                        'c' => $colIndex + 1,
                        'v' => (int) $valor
                    ];
                }
            }
        }

        $payloadJson = json_encode($pistas);

        // 2. Definimos la ruta al binario. base_path() apunta a la raíz de tu proyecto Laravel.
        $rutaBinario = base_path('bin/solucionador_sudoku');

        // 3. Ejecutamos el binario pasándole el argumento 'solve' y el JSON
        $proceso = Process::run([$rutaBinario, 'solve', $payloadJson]);

        if ($proceso->successful()) {
            // Decodificamos el JSON que nos devuelva Haskell y lo retornamos como array de PHP
            return json_decode($proceso->output(), true);
        }

        // En un entorno real, aquí podrías registrar el error en el log (Log::error)
        return null;
    }

    /**
     * Llama al ejecutable de Haskell en modo 'verify' para comprobar si la solución del usuario es correcta.
     */
    public function verificarConHaskell(array $tableroWeb): bool
    {
        $matriz = [];
        for ($i = 0; $i < 9; $i++) {
            $fila = [];
            for ($j = 0; $j < 9; $j++) {
                $valor = $tableroWeb[$i][$j] ?? 0;
                $fila[] = (int) $valor;
            }
            $matriz[] = $fila;
        }

        $payloadJson = json_encode($matriz);
        $rutaBinario = base_path('bin/solucionador_sudoku');
        $proceso = Process::run([$rutaBinario, 'verify', $payloadJson]);

        if ($proceso->successful()) {
            return trim($proceso->output()) === 'valid';
        }

        return false;
    }


    // =========================================================================
    // MÉTODOS PRIVADOS (Lógica interna de manipulación de arrays)
    // =========================================================================

    private function mezclarNumeros(array $tablero): array
    {
        $numeros = range(1, 9);
        shuffle($numeros);
        // Creamos un diccionario de mapeo, ej: [1 => 5, 2 => 9, 3 => 1...]
        $mapa = array_combine(range(1, 9), $numeros);

        foreach ($tablero as &$fila) {
            foreach ($fila as &$celda) {
                $celda = $mapa[$celda];
            }
        }
        unset($fila, $celda); // Previene bugs extraños con las referencias en PHP

        return $tablero;
    }

    private function mezclarFilasPorBloque(array $tablero): array
    {
        $nuevoTablero = [];
        // Un Sudoku tiene 3 "bloques" horizontales de 3 filas cada uno
        $bloques = [[0, 1, 2], [3, 4, 5], [6, 7, 8]];

        foreach ($bloques as $bloque) {
            shuffle($bloque); // Mezclamos el orden de las filas DENTRO de ese bloque
            foreach ($bloque as $indiceFila) {
                $nuevoTablero[] = $tablero[$indiceFila];
            }
        }

        return $nuevoTablero;
    }

    private function perforarTablero(array $tablero, int $pistasRestantes): array
    {
        $casillasAQuitar = 81 - $pistasRestantes;

        while ($casillasAQuitar > 0) {
            $f = rand(0, 8);
            $c = rand(0, 8);

            // Si la casilla no es 0, la vaciamos
            if ($tablero[$f][$c] !== 0) {
                $tablero[$f][$c] = 0;
                $casillasAQuitar--;
            }
        }

        return $tablero;
    }
}
