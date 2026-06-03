<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        MathJax = {
            loader: { load: ["input/asciimath", "output/chtml", "ui/menu"] },
            output: { font: "mathjax-newcm" }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/mathjax@4/startup.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <title>@yield('titulo') — Mi Proyecto</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="{{ route('inicio') }}">Inicio</a></li>
            <li><a href="{{ route('sobre-mi') }}">Sobre mí</a></li>
            <li><a href="{{ route('materias') }}">Materias</a></li>
            <li><a href="{{ route('contacto') }}">Contacto</a></li>
        </ul>
    </nav>

    <main>
