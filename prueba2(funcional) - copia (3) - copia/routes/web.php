<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/reserva', function () {
    return view('reserva');
});
Route::get('/administrador', function () {
    return view('admin_dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
use App\Http\Controllers\ClaseController;

Route::get('/clases', [ClaseController::class, 'index'])->name('clases.index');
Route::get('/clases/create', [ClaseController::class, 'create'])->name('clases.create');
Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');
Route::get('/clases/list', [ClaseController::class, 'listarClases'])->name('clases.list'); 
Route::get('/clases/{clase}', [ClaseController::class, 'show'])->name('clases.show');
Route::get('/clases/{clase}/edit', [ClaseController::class, 'edit'])->name('clases.edit');
Route::put('/clases/{clase}', [ClaseController::class, 'update'])->name('clases.update');
Route::delete('/clases/{clase}', [ClaseController::class, 'destroy'])->name('clases.destroy');


use App\Http\Controllers\ReservaController;

Route::get('/seleccionarCancha', [ReservaController::class, 'seleccionarCancha'])->name('seleccionarCancha');
Route::get('/reservar/{cancha}', [ReservaController::class, 'index'])->name('reservar');
Route::post('/reservar/{cancha}', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/getHorarios/{cancha}', [ReservaController::class, 'getHorarios']);
Route::post('/resumen', [ReservaController::class, 'resumen'])->name('resumen');

Route::get('/reservas', [ReservaController::class, 'listarReservas'])->name('reservas.index');
Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
Route::get('/mis-reservas', [ReservaController::class, 'listarReservasUsuario'])->name('reservas.usuario');

use App\Http\Controllers\InscripcionController;

Route::middleware(['auth'])->group(function () {
    Route::post('/clases/{clase}/inscribir', [InscripcionController::class, 'inscribir'])->name('inscripciones.inscribir');
    Route::get('/clases/{clase}/inscripcion', [InscripcionController::class, 'show'])->name('inscripciones.show');
    Route::get('/mis-clases', [InscripcionController::class, 'misClases'])->name('inscripciones.mis_clases');

});


require __DIR__.'/auth.php';
