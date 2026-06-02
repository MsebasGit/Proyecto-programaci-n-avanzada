<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Final — {{ $nombre }}</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 80px auto; padding: 0 20px; background: #f0f4f8; }
        .tarjeta { background: white; border-radius: 10px; padding: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0,08); text-align: center; }
        h1 { color: #1a3c5e; margin-bottom: 8px; font-size: 28px; }
        .subtitulo { color: #666; margin: 0; }
        .badge { display: inline-block; background: #1a3c5e; color: white; padding: 8px 20px; border-radius: 20px; font-size: 13px; margin-top: 20px; }
        .pie { margin-top: 35px; color: #bbb; font-size: 12px; }
    </style>
</head>
<body>
    <div class="tarjeta">
        {{-- {{ $variable }} en Blade = <?= htmlspecialchars($variable) ?> en PHP puro --}}
        {{-- Blade aplica la protección XSS automáticamente con las llaves dobles --}}
        <h1>{{ $nombre }}</h1>
        <p class="subtitulo">{{ $carrera }} &middot; {{ $semestre }}</p>
        <span class="badge">SIS-500 &mdash; Programación Avanzada &middot; {{ $año }}</span>
        <p class="pie">Construido con Laravel &mdash; Universidad Privada San Francisco de Asís</p>
    </div>
</body>
</html>
