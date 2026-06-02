@extends('layouts.app')

@section('titulo', 'Contacto')

@section('contenido')
<h1>Contacto</h1>

<div class="caja">
    <h2>Contacto</h2>
    
    @if(session('success') || session('exito'))
        <div style="background-color: rgba(166, 209, 137, 0.15); border: 2px dashed var(--green); color: var(--green); padding: 15px; border-radius: 8px; width: 100%; margin-bottom: 20px; text-align: center; font-family: var(--fuente-codigo); font-size: 0.9rem;">
            {{ session('success') ?? session('exito') }}
        </div>
    @endif

    <form action="{{ route('contacto.procesar') }}" method="POST">
        @csrf
        
        <label for="nombre">Nombre completo: </label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre..." value="{{ old('nombre') }}" required>
        @error('nombre')
            <span style="color: var(--red); font-family: var(--fuente-codigo); font-size: 0.8rem; margin-top: -10px; margin-bottom: 10px; display: block;">{{ $message }}</span>
        @enderror

        <label for="email">Correo electrónico: </label>
        <input type="email" id="email" name="email" placeholder="Tu correo..." value="{{ old('email') }}" required>
        @error('email')
            <span style="color: var(--red); font-family: var(--fuente-codigo); font-size: 0.8rem; margin-top: -10px; margin-bottom: 10px; display: block;">{{ $message }}</span>
        @enderror

        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje..." required>{{ old('mensaje') }}</textarea>
        @error('mensaje')
            <span style="color: var(--red); font-family: var(--fuente-codigo); font-size: 0.8rem; margin-top: -10px; margin-bottom: 10px; display: block;">{{ $message }}</span>
        @enderror

        <button type="submit">Enviar</button>
    </form>
</div>
@endsection
