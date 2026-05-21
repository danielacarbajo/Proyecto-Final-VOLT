<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\EntrenamientoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'iniciarSesion']);


/*
|--------------------------------------------------------------------------
| Rutas privadas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

    Route::get('/panel', function () {
        return view('panel');
    })->name('panel');

    Route::resource('rutinas', RutinaController::class);

    Route::resource('ejercicios', EjercicioController::class)->except('show');

    Route::resource('entrenamientos', EntrenamientoController::class);

});
