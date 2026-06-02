@extends('layouts.app')

@section('titulo', 'Sobre Mí')

@section('contenido')
<h1>Sobre Mí</h1>

<div class="caja">
    <h2>Perfíl Académico</h2>
    <div style="width: 100%; display: flex; flex-direction: column; align-items: center; margin-top: 15px;">
        <p><strong>Nombre:</strong> {{ $nombre }}</p>
        <p><strong>Carrera:</strong> {{ $carrera }}</p>
        <p><strong>Semestre:</strong> {{ $semestre }}</p>
    </div>
</div>

<div class="caja">
    <h2>Habilidades</h2>
    <div style="width: 100%; display: flex; flex-direction: column; gap: 15px; margin-top: 15px;">
        @foreach($habilidades as $habilidad => $porcentaje)
        <div class="progreso-container">
            <div class="progreso-label">
                <span>{{ $habilidad }}</span>
                <span>{{ $porcentaje }}%</span>
            </div>
            <div class="progreso-barra-fondo">
                <div class="progreso-barra-llena" style="width: {{ $porcentaje }}%;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
