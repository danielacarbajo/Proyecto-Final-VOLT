<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PerfilController;
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
| Rutas privadas (usuarios normales)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'no.admin'])->group(function () {

    Route::get('/panel', [PanelController::class, 'index'])->name('panel');

    Route::post('/rutinas/{rutina}/duplicar', [RutinaController::class, 'duplicar'])->name('rutinas.duplicar');
    Route::resource('rutinas', RutinaController::class);

    Route::get('/ejercicios/{ejercicio}/progreso', [EjercicioController::class, 'progreso'])->name('ejercicios.progreso');
    Route::resource('ejercicios', EjercicioController::class)->except('show');

    Route::post('/entrenamientos/{entrenamiento}/duplicar', [EntrenamientoController::class, 'duplicar'])->name('entrenamientos.duplicar');
    Route::resource('entrenamientos', EntrenamientoController::class);

});


/*
|--------------------------------------------------------------------------
| Rutas comunes (admin y usuario): logout y perfil
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

    Route::get('/perfil', [PerfilController::class, 'editar'])->name('perfil.editar');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::put('/perfil/contrasena', [PerfilController::class, 'cambiarContrasena'])->name('perfil.contrasena');
    Route::delete('/perfil/foto', [PerfilController::class, 'eliminarFoto'])->name('perfil.foto.eliminar');
});


/*
|--------------------------------------------------------------------------
| Rutas de administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'panel'])->name('panel');

    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');

    Route::get('/usuarios/crear', [AdminController::class, 'crearUsuarioForm'])->name('usuarios.crear');
    Route::post('/usuarios/crear', [AdminController::class, 'crearUsuario'])->name('usuarios.crear.guardar');

    Route::get('/usuarios/{usuario}', [AdminController::class, 'verUsuario'])->name('usuarios.show');
    Route::patch('/usuarios/{usuario}/rol', [AdminController::class, 'cambiarRol'])->name('usuarios.rol');
    Route::patch('/usuarios/{usuario}/resetear-contrasena', [AdminController::class, 'resetearContrasena'])->name('usuarios.contrasena');
    Route::patch('/usuarios/{usuario}/estado', [AdminController::class, 'cambiarEstado'])->name('usuarios.estado');
    Route::delete('/usuarios/{usuario}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.destroy');

});
