<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;

// RUTA 1 — Inicio
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');

// RUTA 2 — Sobre mí
Route::get('/sobre-mi', [PaginaController::class, 'sobreMi'])->name('sobre-mi');

// RUTA 3 — Materias
Route::get('/materias', [PaginaController::class, 'materias'])->name('materias');

// RUTA 4 — Contacto (formulario)
Route::get('/contacto', [PaginaController::class, 'contacto'])->name('contacto');

// RUTA 5 — Contacto (procesar)
Route::post('/contacto', [PaginaController::class, 'procesarContacto'])->name('contacto.procesar');

// RUTA
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (solo para el usuario logueado)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Crea esta vista después
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
