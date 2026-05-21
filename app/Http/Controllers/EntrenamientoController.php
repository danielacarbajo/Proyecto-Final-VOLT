<?php

namespace App\Http\Controllers;

use App\Models\Entrenamiento;
use App\Models\Ejercicio;
use App\Models\Rutina;
use App\Models\DetalleEntrenamiento;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntrenamientoController extends Controller
{
    /**
     * Lista todos los entrenamientos del usuario (historial).
     */
    public function index(): View
    {
        $entrenamientos = Entrenamiento::where('usuario_id', auth()->id())
            ->with('rutina') // Carga la rutina relacionada de una vez (evita queries extra).
            ->orderBy('fecha_entrenamiento', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('entrenamientos.index', compact('entrenamientos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo entrenamiento.
     */
    public function create(): View
    {
        $rutinas = Rutina::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        $ejercicios = Ejercicio::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        return view('entrenamientos.create', compact('rutinas', 'ejercicios'));
    }

    /**
     * Guarda un nuevo entrenamiento con sus ejercicios.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación principal.
        $datos = $request->validate([
            'fecha_entrenamiento' => ['required', 'date'],
            'rutina_id' => ['nullable', 'exists:rutinas,id'],
            'ejercicios' => ['required', 'array', 'min:1'],
            'ejercicios.*.ejercicio_id' => ['required', 'exists:ejercicios,id'],
            'ejercicios.*.series' => ['required', 'integer', 'min:1', 'max:99'],
            'ejercicios.*.repeticiones' => ['required', 'integer', 'min:1', 'max:999'],
            'ejercicios.*.peso' => ['required', 'numeric', 'min:0', 'max:9999.99'],
        ], [
            'fecha_entrenamiento.required' => 'La fecha del entrenamiento es obligatoria.',
            'fecha_entrenamiento.date' => 'La fecha no es válida.',
            'rutina_id.exists' => 'La rutina seleccionada no existe.',
            'ejercicios.required' => 'Tienes que añadir al menos un ejercicio.',
            'ejercicios.min' => 'Tienes que añadir al menos un ejercicio.',
            'ejercicios.*.ejercicio_id.required' => 'Selecciona un ejercicio en cada fila.',
            'ejercicios.*.series.required' => 'Las series son obligatorias.',
            'ejercicios.*.series.integer' => 'Las series tienen que ser un número entero.',
            'ejercicios.*.series.min' => 'Tiene que haber al menos 1 serie.',
            'ejercicios.*.repeticiones.required' => 'Las repeticiones son obligatorias.',
            'ejercicios.*.repeticiones.integer' => 'Las repeticiones tienen que ser un número entero.',
            'ejercicios.*.repeticiones.min' => 'Tiene que haber al menos 1 repetición.',
            'ejercicios.*.peso.required' => 'El peso es obligatorio.',
            'ejercicios.*.peso.numeric' => 'El peso tiene que ser un número.',
            'ejercicios.*.peso.min' => 'El peso no puede ser negativo.',
        ]);

        // 2. Verificar que la rutina (si se ha indicado) pertenece al usuario.
        if (!empty($datos['rutina_id'])) {
            $rutina = Rutina::find($datos['rutina_id']);
            if (!$rutina || $rutina->usuario_id !== auth()->id()) {
                abort(403, 'La rutina seleccionada no te pertenece.');
            }
        }

        // 3. Guardar en una transacción para que todo o nada.
        DB::transaction(function () use ($datos) {
            // Crear el entrenamiento principal.
            $entrenamiento = Entrenamiento::create([
                'usuario_id' => auth()->id(),
                'rutina_id' => $datos['rutina_id'] ?? null,
                'fecha_entrenamiento' => $datos['fecha_entrenamiento'],
            ]);

            // Crear cada detalle (ejercicio realizado).
            foreach ($datos['ejercicios'] as $ej) {
                // Verificar que el ejercicio pertenece al usuario.
                $ejercicio = Ejercicio::find($ej['ejercicio_id']);
                if (!$ejercicio || $ejercicio->usuario_id !== auth()->id()) {
                    abort(403, 'Un ejercicio seleccionado no te pertenece.');
                }

                DetalleEntrenamiento::create([
                    'entrenamiento_id' => $entrenamiento->id,
                    'ejercicio_id' => $ej['ejercicio_id'],
                    'series' => $ej['series'],
                    'repeticiones' => $ej['repeticiones'],
                    'peso' => $ej['peso'],
                ]);
            }
        });

        return redirect()->route('entrenamientos.index')
            ->with('exito', 'Entrenamiento registrado correctamente.');
    }

    /**
     * Muestra el detalle de un entrenamiento.
     */
    public function show(Entrenamiento $entrenamiento): View
    {
        $this->autorizar($entrenamiento);

        // Cargamos los detalles y sus ejercicios relacionados.
        $entrenamiento->load(['rutina', 'detalles.ejercicio']);

        return view('entrenamientos.show', compact('entrenamiento'));
    }

    /**
     * Elimina un entrenamiento (junto con sus detalles, por la FK con cascade).
     */
    public function destroy(Entrenamiento $entrenamiento): RedirectResponse
    {
        $this->autorizar($entrenamiento);

        $entrenamiento->delete();

        return redirect()->route('entrenamientos.index')
            ->with('exito', 'Entrenamiento eliminado correctamente.');
    }

    /**
     * Helper de autorización.
     */
    private function autorizar(Entrenamiento $entrenamiento): void
    {
        if ($entrenamiento->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este entrenamiento.');
        }
    }
}
