<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RutinaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Registro
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar']);

// Login
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'iniciarSesion']);


/*
|--------------------------------------------------------------------------
| Rutas privadas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

    // Panel principal
    Route::get('/panel', function () {
        return view('panel');
    })->name('panel');

    // Rutinas (CRUD completo)
    Route::resource('rutinas', RutinaController::class);

});
