<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    // CRUD Materias
    Route::post('/admin/materias', [AdminController::class, 'storeMateria'])->name('admin.materias.store');
    Route::put('/admin/materias/{materia}', [AdminController::class, 'updateMateria'])->name('admin.materias.update');
    Route::delete('/admin/materias/{materia}', [AdminController::class, 'destroyMateria'])->name('admin.materias.destroy');

    // CRUD Habilidades
    Route::post('/admin/habilidades', [AdminController::class, 'storeHabilidad'])->name('admin.habilidades.store');
    Route::put('/admin/habilidades/{habilidad}', [AdminController::class, 'updateHabilidad'])->name('admin.habilidades.update');
    Route::delete('/admin/habilidades/{habilidad}', [AdminController::class, 'destroyHabilidad'])->name('admin.habilidades.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
