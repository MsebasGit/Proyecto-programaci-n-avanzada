@extends('layouts.app')

@section('titulo', 'Materias')

@section('contenido')
<h1>Mis Materias</h1>

<div class="caja caja-resumen">
    <div class="tarjeta-resumen">
        <h3>Promedio</h3>
        <p>{{ $promedio }}</p>
    </div>
    <div class="tarjeta-resumen">
        <h3>Aprobadas</h3>
        <p>{{ $aprobadas }}</p>
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
                <td>{{ $m->getCreditos() }}</td>
                <td><strong>{{ $m->getNota() }}</strong></td>
               <td><strong>{{ $m->getEstado() }}</strong></td>
             </tr>
         @endforeach
         </tbody>
    </table>
</div>
@endsection
