<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sistema de Perfil Universitario — SIS-500

Aplicación web desarrollada como proyecto final del curso de Programación Avanzada en la Universidad Privada San Francisco de Asís.

## Tecnologías utilizadas
- PHP 8.x
- Laravel 11.x
- CSS3 (diseño propio, sin frameworks externos)
- MySQL / SQLite
- Haskell + GHC (para el solucionador lógico de Sudoku)
- GIT + GitHub

## Funcionalidades
- Página de perfil personal del estudiante
- Listado de materias con notas y estados
- Formulario de contacto con validación PHP
- Creación de un administrador con la capacidad de agregar, modificar y eliminar materias y habilidades
- **Juego de Sudoku Interactivo**:
  - Pistas editables basadas en la dificultad seleccionada (30 a 80 pistas).
  - Integrado con un solucionador lógico (algoritmo DPLL) desarrollado y compilado en Haskell.
  - Opción de autocompletar el juego ("¡Haskell, resuélvelo!").
  - Opción de verificar en tiempo real si el tablero rellenado por el usuario es correcto ("Verificar mi solución").

## Instalación local
1. Clonar el repositorio: `git clone [URL-de-tu-repo]`
2. Entrar a la carpeta: `cd proyecto-final`
3. Instalar dependencias: `composer install`
4. Copiar variables de entorno: `cp .env.example .env`
5. Generar clave de aplicación: `php artisan key:generate`
6. Configurar base de datos en `.env`
7. Ejecutar migraciones: `php artisan migrate`
8. Compilar el solucionador de Sudoku (Haskell):
   ```bash
   mkdir -p bin
   ghc -O2 sudokuCompleto.hs -o bin/solucionador_sudoku
   ```
9. Levantar servidor: `php artisan serve`
10. Abrir en el navegador: http://127.0.0.1:8000


## Configuración de administrador
Para configurar un usuario como administradir ejecute en su terminal:
```
$ php artisan tinker
    
```
Y dentro de la consola de Tinker:
```
App\Models\User::create([
    'name' => '[NOMBRE]',
    'email' => '[EMAIL]',
    'password' => Hash::make('[]')
]);
````

## Autor
Sebastian Jorge Medrano Chacolla
Estudiante de Ingeniería de Sistemas — USFA
GitHub: [@MSebasGit](https://github.com/MSebasGit)

