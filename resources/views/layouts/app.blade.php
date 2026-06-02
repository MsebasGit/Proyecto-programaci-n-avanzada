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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jersey+10&display=swap');

        .jersey-15-regular, .jersey-10-regular {
            font-family: "Jersey 10", sans-serif !important;
            font-weight: 400 !important;
            font-style: normal !important;
        }
    </style>
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
        @yield('contenido')
    </main>

    <footer>
        <div class="footer-contenedor">
            <p class="copyleft">
                <span>©</span> {{ date('Y') }} Medrano Sebastian. Copyleft
            </p>
            <div class="footer-redes">
                <a href="https://github.com" target="_blank">GitHub</a>
                <a href="mailto:s.medrano@e.usfa.edu.bo">Email</a>
            </div>
        </div>
    </footer>
</body>

</html>
