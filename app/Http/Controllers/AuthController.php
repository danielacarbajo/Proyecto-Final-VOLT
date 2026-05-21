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
        // 1. Validación de los datos del formulario.
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

        // 2. Crear el nuevo usuario. La contraseña se cifra automáticamente
        //    porque en el modelo Usuario tenemos 'contrasena' => 'hashed'.
        $usuario = Usuario::create([
            'rol_id' => 1, // 1 = usuario normal (admin sería 2)
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'contrasena' => $datos['contrasena'],
            'fecha_creacion' => now(),
        ]);

        // 3. Iniciar sesión automáticamente con el nuevo usuario.
        Auth::login($usuario);

        // 4. Redirigir al panel principal.
        return redirect()->route('panel')->with('exito', '¡Bienvenido a VOLT, ' . $usuario->nombre . '!');
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
        // 1. Validación.
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'contrasena' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        // 2. Buscamos el usuario por email y validamos la contraseña manualmente.
        $usuario = Usuario::where('email', $datos['email'])->first();

        if ($usuario && Hash::check($datos['contrasena'], $usuario->contrasena)) {
            Auth::login($usuario, $request->boolean('recordar'));
            $request->session()->regenerate(); // Por seguridad, regeneramos el ID de sesión.
            return redirect()->intended(route('panel'));
        }

        // 3. Si falla, volver al formulario con un mensaje genérico (por seguridad, no decimos si el error es el email o la contraseña).
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
