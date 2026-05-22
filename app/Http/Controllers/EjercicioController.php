<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\DetalleEntrenamiento;
use App\Helpers\EjercicioHelper;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EjercicioController extends Controller
{
    /**
     * Lista todos los ejercicios del usuario autenticado.
     * Incluye el mejor récord (PR) de cada ejercicio.
     */
    public function index(): View
    {
        $ejercicios = Ejercicio::where('usuario_id', auth()->id())
            ->orderBy('nombre')
            ->get();

        $usuarioId = auth()->id();
        foreach ($ejercicios as $ejercicio) {
            $mejorDetalle = DetalleEntrenamiento::where('ejercicio_id', $ejercicio->id)
                ->whereHas('entrenamiento', function ($q) use ($usuarioId) {
                    $q->where('usuario_id', $usuarioId);
                })
                ->with('entrenamiento')
                ->orderByDesc('peso')
                ->orderByDesc('repeticiones')
                ->first();

            $ejercicio->pr = $mejorDetalle;
        }

        return view('ejercicios.index', compact('ejercicios'));
    }

    /**
     * Muestra el formulario para crear un nuevo ejercicio.
     */
    public function create(): View
    {
        $ejerciciosAgrupados = EjercicioHelper::ejerciciosAgrupados();
        return view('ejercicios.create', compact('ejerciciosAgrupados'));
    }

    /**
     * Guarda un nuevo ejercicio.
     * El grupo muscular se asigna automáticamente desde el catálogo.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
        ], [
            'nombre.required' => 'Debes seleccionar un ejercicio del catálogo.',
        ]);

        // Asignar automáticamente el grupo muscular según el catálogo.
        $grupo = EjercicioHelper::grupoDeEjercicio($datos['nombre']);

        Ejercicio::create([
            'usuario_id' => auth()->id(),
            'nombre' => $datos['nombre'],
            'grupo_muscular' => $grupo, // Será null si es personalizado.
        ]);

        return redirect()->route('ejercicios.index')
            ->with('exito', 'Ejercicio añadido a tu catálogo personal.');
    }

    /**
     * Muestra el formulario para editar un ejercicio.
     */
    public function edit(Ejercicio $ejercicio): View
    {
        $this->autorizar($ejercicio);

        $ejerciciosAgrupados = EjercicioHelper::ejerciciosAgrupados();
        return view('ejercicios.edit', compact('ejercicio', 'ejerciciosAgrupados'));
    }

    /**
     * Actualiza un ejercicio.
     */
    public function update(Request $request, Ejercicio $ejercicio): RedirectResponse
    {
        $this->autorizar($ejercicio);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
        ], [
            'nombre.required' => 'Debes seleccionar un ejercicio del catálogo.',
        ]);

        // Reasignar grupo según el nuevo nombre.
        $grupo = EjercicioHelper::grupoDeEjercicio($datos['nombre']);

        $ejercicio->update([
            'nombre' => $datos['nombre'],
            'grupo_muscular' => $grupo,
        ]);

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
     * Muestra la gráfica de progreso de un ejercicio.
     */
    public function progreso(Ejercicio $ejercicio): View
    {
        $this->autorizar($ejercicio);

        $usuarioId = auth()->id();

        $registros = DetalleEntrenamiento::where('ejercicio_id', $ejercicio->id)
            ->whereHas('entrenamiento', function ($q) use ($usuarioId) {
                $q->where('usuario_id', $usuarioId);
            })
            ->with('entrenamiento')
            ->get()
            ->sortBy(fn($d) => $d->entrenamiento->fecha_entrenamiento);

        $datosPorFecha = $registros
            ->groupBy(fn($d) => $d->entrenamiento->fecha_entrenamiento->format('Y-m-d'))
            ->map(function ($detallesDeUnDia) {
                return [
                    'peso_max' => $detallesDeUnDia->max('peso'),
                    'reps_max' => $detallesDeUnDia->max('repeticiones'),
                    'series_total' => $detallesDeUnDia->sum('series'),
                ];
            });

        $etiquetas = $datosPorFecha->keys()->map(function ($fecha) {
            return \Carbon\Carbon::parse($fecha)->format('d/m/Y');
        })->values();

        $pesos = $datosPorFecha->pluck('peso_max')->values();

        $totalRegistros = $registros->count();
        $pesoMaximo = $registros->max('peso');
        $pesoMinimo = $registros->min('peso');
        $diferencia = $pesoMaximo !== null && $pesoMinimo !== null ? ($pesoMaximo - $pesoMinimo) : 0;

        return view('ejercicios.progreso', compact(
            'ejercicio',
            'etiquetas',
            'pesos',
            'totalRegistros',
            'pesoMaximo',
            'pesoMinimo',
            'diferencia'
        ));
    }

    private function autorizar(Ejercicio $ejercicio): void
    {
        if ($ejercicio->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este ejercicio.');
        }
    }
}
