<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EjercicioController extends Controller
{
    /**
     * Lista todos los ejercicios del usuario autenticado.
     */
    public function index(): View
    {
        $ejercicios = Ejercicio::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        return view('ejercicios.index', compact('ejercicios'));
    }

    /**
     * Muestra el formulario para crear un nuevo ejercicio.
     */
    public function create(): View
    {
        return view('ejercicios.create');
    }

    /**
     * Guarda un nuevo ejercicio.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'grupo_muscular' => ['nullable', 'string', 'max:50'],
        ], [
            'nombre.required' => 'El nombre del ejercicio es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'grupo_muscular.max' => 'El grupo muscular no puede tener más de 50 caracteres.',
        ]);

        Ejercicio::create([
            'usuario_id' => auth()->id(),
            'nombre' => $datos['nombre'],
            'grupo_muscular' => $datos['grupo_muscular'] ?? null,
        ]);

        return redirect()->route('ejercicios.index')
            ->with('exito', 'Ejercicio creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un ejercicio.
     */
    public function edit(Ejercicio $ejercicio): View
    {
        $this->autorizar($ejercicio);

        return view('ejercicios.edit', compact('ejercicio'));
    }

    /**
     * Actualiza un ejercicio.
     */
    public function update(Request $request, Ejercicio $ejercicio): RedirectResponse
    {
        $this->autorizar($ejercicio);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'grupo_muscular' => ['nullable', 'string', 'max:50'],
        ], [
            'nombre.required' => 'El nombre del ejercicio es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'grupo_muscular.max' => 'El grupo muscular no puede tener más de 50 caracteres.',
        ]);

        $ejercicio->update($datos);

        return redirect()->route('ejercicios.index')
            ->with('exito', 'Ejercicio actualizado correctamente.');
    }

    /**
     * Elimina un ejercicio.
     */
    public function destroy(Ejercicio $ejercicio): RedirectResponse
    {
        $this->autorizar($ejercicio);

        $ejercicio->delete();

        return redirect()->route('ejercicios.index')
            ->with('exito', 'Ejercicio eliminado correctamente.');
    }

    /**
     * Helper de autorización.
     */
    private function autorizar(Ejercicio $ejercicio): void
    {
        if ($ejercicio->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este ejercicio.');
        }
    }
}
