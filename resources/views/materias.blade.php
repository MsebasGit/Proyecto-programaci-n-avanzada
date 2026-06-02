@extends('layouts.app')

@section('titulo', 'Materias')

@section('contenido')
<h1>Mis Materias</h1>

<div class="caja" style="justify-content: space-around; gap: 20px;">
    <div style="flex: 1; min-width: 150px; background-color: var(--crust); border: 1px dashed var(--surface-2); padding: 15px; border-radius: 8px; text-align: center;">
        <h3 style="color: var(--yellow); font-size: 1.1rem; margin-bottom: 5px; text-align: center;">Promedio</h3>
        <p style="font-size: 1.8rem; font-weight: bold; color: var(--green); margin: 0; text-align: center;">{{ $promedio }}</p>
    </div>
    <div style="flex: 1; min-width: 150px; background-color: var(--crust); border: 1px dashed var(--surface-2); padding: 15px; border-radius: 8px; text-align: center;">
        <h3 style="color: var(--yellow); font-size: 1.1rem; margin-bottom: 5px; text-align: center;">Aprobadas</h3>
        <p style="font-size: 1.8rem; font-weight: bold; color: var(--green); margin: 0; text-align: center;">{{ $aprobadas }}</p>
    </div>
</div>

<div class="caja">
    <h2>Notas</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Materia</th>
                <th>Créditos</th>
                <th>Nota</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            {{--
             Diferencia clave respecto al Día 12:
             ANTES: $materia['codigo'] → acceso a índice de array
             AHORA: $m->getCodigo() → llamada a método de objeto
             La vista no sabe ni le importa cómo se construyó el objeto.
             Eso es encapsulamiento aplicado al MVC.
            --}}
            @foreach ($materias as $m)
            <tr style="background: {{ $m->getColorEstado() }}">
                <td>{{ $m->getCodigo() }}</td>
                <td>{{ $m->getNombre() }}</td>
                <td style="text-align:center;">{{ $m->getCreditos() }}</td>
                <td style="text-align:center; font-weight:bold;">{{ $m->getNota() }}</td>
                <td style="text-align:center; font-weight:bold;">{{ $m->getEstado() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
