@extends('layouts.app')

@section('titulo', 'Contacto')

@section('contenido')
<h1>Contacto</h1>

<div class="caja">
    <h2>Contacto</h2>
    
    @if(session('success') || session('exito'))
        <div class="alerta-exito">
            {{ session('success') ?? session('exito') }}
        </div>
    @endif

    <form action="{{ route('contacto.procesar') }}" method="POST">
        @csrf
        
        <label for="nombre">Nombre completo: </label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre..." value="{{ old('nombre') }}" required>
        @error('nombre')
            <span class="mensaje-error">{{ $message }}</span>
        @enderror

        <label for="email">Correo electrónico: </label>
        <input type="email" id="email" name="email" placeholder="Tu correo..." value="{{ old('email') }}" required>
        @error('email')
            <span class="mensaje-error">{{ $message }}</span>
        @enderror

        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje..." required>{{ old('mensaje') }}</textarea>
        @error('mensaje')
            <span class="mensaje-error">{{ $message }}</span>
        @enderror

        <button type="submit">Enviar</button>
    </form>
</div>
@endsection
