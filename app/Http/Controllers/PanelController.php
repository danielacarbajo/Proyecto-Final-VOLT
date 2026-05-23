<?php

namespace App\Http\Controllers;

use App\Models\Entrenamiento;
use App\Models\Rutina;
use App\Models\Ejercicio;
use Illuminate\View\View;
use Carbon\Carbon;

class PanelController extends Controller
{
    /**
     * Muestra el panel principal del usuario con métricas y resumen de actividad.
     */
    public function index(): View
    {
        $usuario = auth()->user();
        $ahora = Carbon::now();

        // ====================
        // MÉTRICAS BÁSICAS
        // ====================

        $totalEntrenamientos = Entrenamiento::where('usuario_id', $usuario->id)->count();

        $entrenamientosMes = Entrenamiento::where('usuario_id', $usuario->id)
            ->whereMonth('fecha_entrenamiento', $ahora->month)
            ->whereYear('fecha_entrenamiento', $ahora->year)
            ->count();

        $totalRutinas = Rutina::where('usuario_id', $usuario->id)->count();

        $totalEjercicios = Ejercicio::where('usuario_id', $usuario->id)->count();

        // ====================
        // COMPARATIVA: ESTA SEMANA vs SEMANA PASADA
        // ====================

        $inicioSemanaActual = $ahora->copy()->startOfWeek();   // Lunes 00:00 esta semana
        $finSemanaActual = $ahora->copy()->endOfWeek();        // Domingo 23:59 esta semana

        $inicioSemanaPasada = $inicioSemanaActual->copy()->subWeek();
        $finSemanaPasada = $finSemanaActual->copy()->subWeek();

        $entrenamientosSemanaActual = Entrenamiento::where('usuario_id', $usuario->id)
            ->whereBetween('fecha_entrenamiento', [$inicioSemanaActual, $finSemanaActual])
            ->count();

        $entrenamientosSemanaPasada = Entrenamiento::where('usuario_id', $usuario->id)
            ->whereBetween('fecha_entrenamiento', [$inicioSemanaPasada, $finSemanaPasada])
            ->count();

        // Diferencia: positiva, negativa o cero
        $diferenciaSemana = $entrenamientosSemanaActual - $entrenamientosSemanaPasada;

        // ====================
        // ÚLTIMO ENTRENAMIENTO (con sus detalles cargados)
        // ====================

        $ultimoEntrenamiento = Entrenamiento::where('usuario_id', $usuario->id)
            ->with(['rutina', 'detalles'])
            ->orderBy('fecha_entrenamiento', 'desc')
            ->first();

        // Calcular nº de ejercicios y nº total de series del último entreno
        $ultimoEntrenoEjercicios = 0;
        $ultimoEntrenoSeries = 0;

        if ($ultimoEntrenamiento) {
            $ultimoEntrenoEjercicios = $ultimoEntrenamiento->detalles->count();
            $ultimoEntrenoSeries = $ultimoEntrenamiento->detalles->sum('series');
        }

        // ====================
        // ÚLTIMOS 5 ENTRENAMIENTOS
        // ====================

        $ultimosEntrenamientos = Entrenamiento::where('usuario_id', $usuario->id)
            ->with('rutina')
            ->orderBy('fecha_entrenamiento', 'desc')
            ->take(5)
            ->get();

        // ====================
        // RUTINA MÁS USADA (en los últimos 30 días)
        // ====================

        $rutinaMasUsada = Entrenamiento::where('usuario_id', $usuario->id)
            ->whereNotNull('rutina_id')
            ->where('fecha_entrenamiento', '>=', $ahora->copy()->subDays(30))
            ->selectRaw('rutina_id, COUNT(*) as total')
            ->groupBy('rutina_id')
            ->orderByDesc('total')
            ->with('rutina')
            ->first();

        // ====================
        // ACTIVIDAD SEMANAL (lunes a domingo)
        // ====================

        $actividadSemana = [];
        $inicioSemana = $ahora->copy()->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $dia = $inicioSemana->copy()->addDays($i);

            $cantidad = Entrenamiento::where('usuario_id', $usuario->id)
                ->whereDate('fecha_entrenamiento', $dia->toDateString())
                ->count();

            $actividadSemana[] = $cantidad;
        }

        // ====================
        // FLAG: usuario sin actividad
        // ====================

        $sinActividad = $totalEntrenamientos === 0;

        return view('panel', compact(
            'totalEntrenamientos',
            'entrenamientosMes',
            'totalRutinas',
            'totalEjercicios',
            'entrenamientosSemanaActual',
            'entrenamientosSemanaPasada',
            'diferenciaSemana',
            'ultimoEntrenamiento',
            'ultimoEntrenoEjercicios',
            'ultimoEntrenoSeries',
            'ultimosEntrenamientos',
            'rutinaMasUsada',
            'actividadSemana',
            'sinActividad'
        ));
    }
}
