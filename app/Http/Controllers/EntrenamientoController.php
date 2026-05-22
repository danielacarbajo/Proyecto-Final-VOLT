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
use Carbon\Carbon;

class EntrenamientoController extends Controller
{
    /**
     * Lista todos los entrenamientos del usuario (historial).
     */
    public function index(Request $request): View
    {
        // Validar los filtros recibidos.
        $request->validate([
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date', 'after_or_equal:desde'],
            'rutina_id' => ['nullable', 'exists:rutinas,id'],
        ], [
            'hasta.after_or_equal' => 'La fecha hasta debe ser posterior o igual a la fecha desde.',
            'rutina_id.exists' => 'La rutina seleccionada no existe.',
        ]);

        // Construir la consulta base.
        $query = Entrenamiento::where('usuario_id', auth()->id())
            ->with('rutina');

        // Filtro por fecha "desde".
        if ($request->filled('desde')) {
            $query->where('fecha_entrenamiento', '>=', $request->desde);
        }

        // Filtro por fecha "hasta".
        if ($request->filled('hasta')) {
            $query->where('fecha_entrenamiento', '<=', $request->hasta);
        }

        // Filtro por rutina.
        if ($request->filled('rutina_id')) {
            $rutina = Rutina::find($request->rutina_id);
            if ($rutina && $rutina->usuario_id === auth()->id()) {
                $query->where('rutina_id', $request->rutina_id);
            }
        }

        $entrenamientos = $query->orderBy('fecha_entrenamiento', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $rutinas = Rutina::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        return view('entrenamientos.index', compact('entrenamientos', 'rutinas'));
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

        if (!empty($datos['rutina_id'])) {
            $rutina = Rutina::find($datos['rutina_id']);
            if (!$rutina || $rutina->usuario_id !== auth()->id()) {
                abort(403, 'La rutina seleccionada no te pertenece.');
            }
        }

        DB::transaction(function () use ($datos) {
            $entrenamiento = Entrenamiento::create([
                'usuario_id' => auth()->id(),
                'rutina_id' => $datos['rutina_id'] ?? null,
                'fecha_entrenamiento' => $datos['fecha_entrenamiento'],
            ]);

            foreach ($datos['ejercicios'] as $ej) {
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

        $entrenamiento->load(['rutina', 'detalles.ejercicio']);

        return view('entrenamientos.show', compact('entrenamiento'));
    }

    /**
     * Muestra el formulario para editar un entrenamiento.
     */
    public function edit(Entrenamiento $entrenamiento): View
    {
        $this->autorizar($entrenamiento);

        $entrenamiento->load('detalles.ejercicio');

        $rutinas = Rutina::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        $ejercicios = Ejercicio::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        return view('entrenamientos.edit', compact('entrenamiento', 'rutinas', 'ejercicios'));
    }

    /**
     * Actualiza un entrenamiento existente con sus ejercicios.
     */
    public function update(Request $request, Entrenamiento $entrenamiento): RedirectResponse
    {
        $this->autorizar($entrenamiento);

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

        if (!empty($datos['rutina_id'])) {
            $rutina = Rutina::find($datos['rutina_id']);
            if (!$rutina || $rutina->usuario_id !== auth()->id()) {
                abort(403, 'La rutina seleccionada no te pertenece.');
            }
        }

        DB::transaction(function () use ($datos, $entrenamiento) {
            $entrenamiento->update([
                'rutina_id' => $datos['rutina_id'] ?? null,
                'fecha_entrenamiento' => $datos['fecha_entrenamiento'],
            ]);

            $entrenamiento->detalles()->delete();

            foreach ($datos['ejercicios'] as $ej) {
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

        return redirect()->route('entrenamientos.show', $entrenamiento)
            ->with('exito', 'Entrenamiento actualizado correctamente.');
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
     * Duplica un entrenamiento existente.
     * Crea uno nuevo con la fecha de HOY y copia todos los ejercicios.
     */
    public function duplicar(Entrenamiento $entrenamiento): RedirectResponse
    {
        $this->autorizar($entrenamiento);

        // Cargar los detalles para duplicarlos.
        $entrenamiento->load('detalles');

        // Crear el nuevo entrenamiento dentro de una transacción.
        $copia = DB::transaction(function () use ($entrenamiento) {

            // 1. Crear el nuevo entrenamiento con fecha de hoy.
            $nuevo = Entrenamiento::create([
                'usuario_id' => auth()->id(),
                'rutina_id' => $entrenamiento->rutina_id,
                'fecha_entrenamiento' => Carbon::today(),
            ]);

            // 2. Copiar todos los ejercicios (detalles) tal cual.
            foreach ($entrenamiento->detalles as $detalle) {
                DetalleEntrenamiento::create([
                    'entrenamiento_id' => $nuevo->id,
                    'ejercicio_id' => $detalle->ejercicio_id,
                    'series' => $detalle->series,
                    'repeticiones' => $detalle->repeticiones,
                    'peso' => $detalle->peso,
                ]);
            }

            return $nuevo;
        });

        return redirect()->route('entrenamientos.edit', $copia)
            ->with('exito', 'Entrenamiento duplicado con la fecha de hoy. Revisa los datos antes de guardar.');
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
