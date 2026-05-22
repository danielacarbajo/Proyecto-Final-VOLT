<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PerfilController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     */
    public function editar(): View
    {
        return view('perfil.editar', [
            'usuario' => auth()->user(),
        ]);
    }

    /**
     * Actualiza los datos básicos del perfil (nombre, email y foto).
     */
    public function actualizar(Request $request): RedirectResponse
    {
        $usuario = auth()->user();

        // 1. Validar los datos.
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email,' . $usuario->id],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe otra cuenta con ese correo electrónico.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser JPG, PNG o WEBP.',
            'foto.max' => 'La imagen no puede pesar más de 2 MB.',
        ]);

        // 2. Si se ha subido una foto nueva, gestionarla.
        if ($request->hasFile('foto')) {
            // Borrar la foto anterior (si la tenía) para no acumular basura.
            if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
                Storage::disk('public')->delete($usuario->foto);
            }

            // Guardar la nueva en storage/app/public/avatares/
            $ruta = $request->file('foto')->store('avatares', 'public');
            $datos['foto'] = $ruta;
        } else {
            // Si no se ha subido foto nueva, no tocamos el campo foto.
            unset($datos['foto']);
        }

        // 3. Actualizar el usuario.
        $usuario->update($datos);

        return redirect()->route('perfil.editar')
            ->with('exito', 'Datos del perfil actualizados correctamente.');
    }

    /**
     * Elimina la foto de perfil del usuario.
     */
    public function eliminarFoto(): RedirectResponse
    {
        $usuario = auth()->user();

        if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
            Storage::disk('public')->delete($usuario->foto);
        }

        $usuario->update(['foto' => null]);

        return redirect()->route('perfil.editar')
            ->with('exito', 'Foto de perfil eliminada.');
    }

    /**
     * Cambia la contraseña del usuario autenticado.
     */
    public function cambiarContrasena(Request $request): RedirectResponse
    {
        $usuario = auth()->user();

        $request->validate([
            'contrasena_actual' => ['required'],
            'contrasena_nueva' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'contrasena_actual.required' => 'Debes introducir tu contraseña actual.',
            'contrasena_nueva.required' => 'La nueva contraseña es obligatoria.',
            'contrasena_nueva.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'contrasena_nueva.confirmed' => 'Las contraseñas nuevas no coinciden.',
        ]);

        if (!Hash::check($request->contrasena_actual, $usuario->contrasena)) {
            return back()->withErrors([
                'contrasena_actual' => 'La contraseña actual no es correcta.',
            ]);
        }

        $usuario->update([
            'contrasena' => $request->contrasena_nueva,
        ]);

        return redirect()->route('perfil.editar')
            ->with('exito', 'Contraseña cambiada correctamente.');
    }
}
