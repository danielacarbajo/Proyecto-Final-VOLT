<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas (no requieren autenticación)
|--------------------------------------------------------------------------
*/

// Página de inicio: redirige al login si no hay sesión, al panel si la hay.
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
| Rutas privadas (requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

    // Panel principal (de momento una página simple, después la mejoramos)
    Route::get('/panel', function () {
        return view('panel');
    })->name('panel');

});
