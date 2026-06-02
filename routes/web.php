<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;

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

