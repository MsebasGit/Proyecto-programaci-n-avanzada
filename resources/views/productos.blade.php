@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
<h1>Productos</h1>

<div class="caja">
    <h2>Lista de productos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th style="text-align: right;">Precio (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto['nombre'] }}</td>
                <td>{{ $producto['categoria'] }}</td>
                <td style="text-align: right; font-weight: bold; font-family: var(--fuente-codigo);">
                    {{ number_format($producto['precio'], 2) }} Bs.
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="caja" style="justify-content: space-around; gap: 20px; padding: 20px; text-align: center;">
    <div style="width: 100%; background-color: var(--crust); border: 1px dashed var(--surface-2); padding: 15px; border-radius: 8px;">
        <h3 style="color: var(--yellow); font-size: 1.1rem; margin-bottom: 8px;">Precio promedio de productos</h3>
        <p>
        <strong>
            {{ number_format($precioPromedio, 2) }} Bs.
        </strong>
        </p>
    </div>
</div>
@endsection
