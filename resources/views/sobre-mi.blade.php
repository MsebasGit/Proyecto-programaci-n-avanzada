@extends('layouts.app')

@section('titulo', 'Sobre Mí')

@section('contenido')
<h1>Sobre Mí</h1>

<div class="caja">
    <h2>Perfíl Académico</h2>
    <div class="perfil-info">
        <p><strong>Nombre:</strong> {{ $nombre }}</p>
        <p><strong>Carrera:</strong> {{ $carrera }}</p>
        <p><strong>Semestre:</strong> {{ $semestre }}</p>
    </div>
</div>

<div class="caja">
    <h2>Habilidades</h2>
    <div class="habilidades-lista">
        @foreach($habilidades as $habilidad)
        <div class="progreso-container">
            <div class="progreso-label">
                <span>{{ $habilidad->nombre }}</span>
                <span>{{ $habilidad->porcentaje }}%</span>
            </div>
            <div class="progreso-barra-fondo">
                <div class="progreso-barra-llena" style="width: {{ $habilidad->porcentaje }}%;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
