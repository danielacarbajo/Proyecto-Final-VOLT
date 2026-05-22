<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function mostrarRegistro(): View
    {
        return view('auth.registro');
    }

    /**
     * Procesa el registro de un nuevo usuario.
     */
    public function registrar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email'],
            'contrasena' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe una cuenta con ese correo electrónico.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuario::create([
            'rol_id' => 1,
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'contrasena' => $datos['contrasena'],
            'activo' => true,
            'fecha_creacion' => now(),
        ]);

        Auth::login($usuario);

        return redirect()->route('panel');
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión.
     */
    public function iniciarSesion(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'contrasena' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        $usuario = Usuario::where('email', $datos['email'])->first();

        if ($usuario && Hash::check($datos['contrasena'], $usuario->contrasena)) {

            // Comprobar que la cuenta no esté bloqueada por el administrador.
            if (!$usuario->activo) {
                return back()->withErrors([
                    'email' => 'Tu cuenta está bloqueada. Contacta con el administrador.',
                ])->onlyInput('email');
            }

            Auth::login($usuario, $request->boolean('recordar'));
            $request->session()->regenerate();

            if ($usuario->rol_id === 2) {
                return redirect()->route('admin.panel');
            }

            return redirect()->intended(route('panel'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function cerrarSesion(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('exito', 'Sesión cerrada correctamente.');
    }
}
