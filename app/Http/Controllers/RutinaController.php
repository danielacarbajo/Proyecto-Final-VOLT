<?php

namespace App\Http\Controllers;

use App\Models\Rutina;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RutinaController extends Controller
{
    /**
     * Lista todas las rutinas del usuario autenticado.
     */
    public function index(): View
    {
        $rutinas = Rutina::where('usuario_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rutinas.index', compact('rutinas'));
    }

    /**
     * Muestra el formulario para crear una nueva rutina.
     */
    public function create(): View
    {
        return view('rutinas.create');
    }

    /**
     * Guarda una nueva rutina en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre de la rutina es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
        ]);

        Rutina::create([
            'usuario_id' => auth()->id(),
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
        ]);

        return redirect()->route('rutinas.index')
            ->with('exito', 'Rutina creada correctamente.');
    }

    /**
     * Muestra el detalle de una rutina concreta.
     */
    public function show(Rutina $rutina): View
    {
        $this->autorizar($rutina);

        return view('rutinas.show', compact('rutina'));
    }

    /**
     * Muestra el formulario para editar una rutina.
     */
    public function edit(Rutina $rutina): View
    {
        $this->autorizar($rutina);

        return view('rutinas.edit', compact('rutina'));
    }

    /**
     * Actualiza una rutina existente.
     */
    public function update(Request $request, Rutina $rutina): RedirectResponse
    {
        $this->autorizar($rutina);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre de la rutina es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 255 caracteres.',
        ]);

        $rutina->update($datos);

        return redirect()->route('rutinas.index')
            ->with('exito', 'Rutina actualizada correctamente.');
    }

    /**
     * Elimina una rutina.
     */
    public function destroy(Rutina $rutina): RedirectResponse
    {
        $this->autorizar($rutina);

        $rutina->delete();

        return redirect()->route('rutinas.index')
            ->with('exito', 'Rutina eliminada correctamente.');
    }

    /**
     * Duplica una rutina existente del usuario.
     * Crea una copia con el mismo nombre + " (copia)" y la misma descripción.
     * Si la rutina tiene ejercicios asociados (tabla detalle_rutina),
     * también se duplican.
     */
    public function duplicar(Rutina $rutina): RedirectResponse
    {
        $this->autorizar($rutina);

        // Crear la rutina duplicada.
        $copia = Rutina::create([
            'usuario_id' => auth()->id(),
            'nombre' => $rutina->nombre . ' (copia)',
            'descripcion' => $rutina->descripcion,
        ]);

        // Si la rutina tiene ejercicios asociados, los duplicamos también.
        // Esto solo se ejecuta si la relación `detalles` está definida en el modelo Rutina.
        if (method_exists($rutina, 'detalles')) {
            foreach ($rutina->detalles as $detalle) {
                $copia->detalles()->create([
                    'ejercicio_id' => $detalle->ejercicio_id,
                    'series_por_defecto' => $detalle->series_por_defecto,
                    'repeticiones_por_defecto' => $detalle->repeticiones_por_defecto,
                    'posicion' => $detalle->posicion,
                ]);
            }
        }

        return redirect()->route('rutinas.index')
            ->with('exito', 'Rutina duplicada correctamente.');
    }

    /**
     * Helper para verificar que la rutina pertenece al usuario autenticado.
     * Si no, aborta con un error 403 (acceso denegado).
     */
    private function autorizar(Rutina $rutina): void
    {
        if ($rutina->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a esta rutina.');
        }
    }
}
