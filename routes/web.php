<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\ProfesionalesController;
use App\Http\Controllers\AdminUsuariosController;
use App\Http\Controllers\EmprendimientosController;
use Illuminate\Support\Facades\Route;


Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('check.admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Organizaciones
    Route::get('/directorio',                    [DirectorioController::class, 'index'])->name('directorio.index');
    Route::get('/directorio/create',             [DirectorioController::class, 'create'])->name('directorio.create');
    Route::post('/directorio',                   [DirectorioController::class, 'store'])->name('directorio.store');
    Route::get('/directorio/{id}/edit',          [DirectorioController::class, 'edit'])->name('directorio.edit');
    Route::put('/directorio/{id}',               [DirectorioController::class, 'update'])->name('directorio.update');
    Route::delete('/directorio/{id}',            [DirectorioController::class, 'destroy'])->name('directorio.destroy');

    // Profesionales
    Route::get('/directorio/profesionales',             [ProfesionalesController::class, 'index'])->name('profesionales.index');
    Route::get('/directorio/profesionales/create',      [ProfesionalesController::class, 'create'])->name('profesionales.create');
    Route::post('/directorio/profesionales',            [ProfesionalesController::class, 'store'])->name('profesionales.store');
    Route::get('/directorio/profesionales/{id}/edit',   [ProfesionalesController::class, 'edit'])->name('profesionales.edit');
    Route::put('/directorio/profesionales/{id}',        [ProfesionalesController::class, 'update'])->name('profesionales.update');
    Route::delete('/directorio/profesionales/{id}',     [ProfesionalesController::class, 'destroy'])->name('profesionales.destroy');

    // Emprendimientos
    Route::get('/emprendimientos',              [EmprendimientosController::class, 'index'])->name('emprendimientos.index');
    Route::get('/emprendimientos/create',       [EmprendimientosController::class, 'create'])->name('emprendimientos.create');
    Route::post('/emprendimientos',             [EmprendimientosController::class, 'store'])->name('emprendimientos.store');
    Route::get('/emprendimientos/{id}/edit',    [EmprendimientosController::class, 'edit'])->name('emprendimientos.edit');
    Route::put('/emprendimientos/{id}',         [EmprendimientosController::class, 'update'])->name('emprendimientos.update');
    Route::delete('/emprendimientos/{id}',      [EmprendimientosController::class, 'destroy'])->name('emprendimientos.destroy');

    // Admin usuarios
    Route::get('/admin-usuarios',               [AdminUsuariosController::class, 'index'])->name('admin-usuarios.index');
    Route::get('/admin-usuarios/create',        [AdminUsuariosController::class, 'create'])->name('admin-usuarios.create');
    Route::post('/admin-usuarios',              [AdminUsuariosController::class, 'store'])->name('admin-usuarios.store');
    Route::get('/admin-usuarios/{id}/edit',     [AdminUsuariosController::class, 'edit'])->name('admin-usuarios.edit');
    Route::put('/admin-usuarios/{id}',          [AdminUsuariosController::class, 'update'])->name('admin-usuarios.update');
    Route::delete('/admin-usuarios/{id}',       [AdminUsuariosController::class, 'destroy'])->name('admin-usuarios.destroy');
});
