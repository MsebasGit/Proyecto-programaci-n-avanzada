@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
<h1>Página principal</h1>

<div class="caja">
    <h2>Perfíl</h2>
    <img src="{{ asset('Images/foto2.jpg') }}" label="imagen" width="300">
    <div>
        <p> <strong>Nombre:</strong> {{ $nombre }}</p>
        <p> <strong>Carrera:</strong> {{ $carrera }}</p>
        <p> <strong>Semestre:</strong> {{ $semestre }}</p>
        <p> <strong>Año:</strong> {{ $año }}</p>
    </div>
</div>

<div class="caja">
    <h2>Bienvenido</h2>
    <div style="width: 100%; text-align: center;">
        <p>Mi portafolio académico ^_^</p>
    </div>
</div>
@endsection
