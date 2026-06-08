@extends('layouts.app')

@section('titulo', 'Sudoku')

@section('contenido')
<div class="sudoku-container">
    <h1>Sudoku PHP & Haskell</h1>

    @if ($errors->any())
        <div class="alerta-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success') || session('exito'))
        <div class="alerta-exito">
            {{ session('success') ?? session('exito') }}
        </div>
    @endif

    <form action="{{ route('sudoku') }}" method="GET" class="sudoku-controles">
        <div>
            <label for="pistas">Cantidad de pistas (30-80)</label>
            <input type="number" name="pistas" id="pistas" min="30" max="80" value="{{ request('pistas', 30) }}">
        </div>
        <button type="submit" class="btn-sudoku btn-nuevo">
            Nuevo Juego
        </button>
    </form>

    @php
        $tableroAMostrar = session('solucion') ?: (old('tablero') ?: $tableroIncompleto);
        $esSolucion = session('solucion') ? true : false;
    @endphp

    <form action="{{ route('sudoku.resolver') }}" method="POST" style="width: 100%; max-width: max-content; margin: auto;">
        @csrf
        <div class="sudoku-grid">
            @foreach($tableroAMostrar as $fIndex => $fila)
                <div class="contents row-{{ $fIndex + 1 }}">
                    @foreach($fila as $cIndex => $valor)
                        @php
                            $valorOriginal = $tableroIncompleto[$fIndex][$cIndex] ?? 0;
                            $esPistaOriginal = ($valorOriginal !== 0 && $valorOriginal !== null && $valorOriginal !== '');

                            $esVacio = ($valor === 0 || $valor === null || $valor === '');
                            $valorAImprimir = $esVacio ? '' : $valor;

                            $esReadonly = $esSolucion || $esPistaOriginal;
                        @endphp

                        <input
                            type="number"
                            min="1"
                            max="9"
                            name="tablero[{{ $fIndex }}][{{ $cIndex }}]"
                            value="{{ $valorAImprimir }}"
                            class="sudoku-cell {{ $esReadonly ? 'readonly-cell' : '' }}"
                            {{ $esReadonly ? 'readonly tabindex="-1"' : '' }}
                        >
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="sudoku-acciones">
            @if(!$esSolucion)
                <button type="submit" name="accion" value="resolver" class="btn-sudoku btn-resolver">
                    ¡Haskell, resuélvelo!
                </button>
                <button type="submit" name="accion" value="verificar" class="btn-sudoku btn-nuevo">
                    Verificar mi solución
                </button>
            @else
                <a href="{{ route('sudoku') }}" class="btn-sudoku btn-otra-vez">
                    Jugar otra vez
                </a>
            @endif
        </div>
    </form>

</div>
@endsection
