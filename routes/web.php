<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\ProfesionalesController;
use App\Http\Controllers\AdminUsuariosController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function() { return 'pong — Laravel OK — ' . now(); });
Route::get('/test-dir', [DirectorioController::class, 'index']);
Route::get('/test-session', function() {
    return 'session admin: ' . (session('admin') ? json_encode(session('admin')) : 'VACÍA');
});

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('check.admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('directorio', DirectorioController::class)->except(['show']);
    Route::resource('directorio/profesionales', ProfesionalesController::class)
        ->except(['show'])
        ->names('profesionales');
    Route::resource('admin-usuarios', AdminUsuariosController::class)->except(['show']);
});
