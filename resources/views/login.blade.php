@extends('layouts.app')

@section('titulo', 'Panel de Administrador')

@section('contenido')

<h1>Iniciar Sesión</h1>

<div class="caja">
    <h2>Formulario de inicio de sesión</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="email">Correo:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <span class="mensaje-error">{{ $message }}</span>
        @enderror


        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>


        <button type="submit">Entrar</button>
    </form>
</div>
@endsection
