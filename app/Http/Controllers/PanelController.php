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
        // ÚLTIMO ENTRENAMIENTO
        // ====================

        $ultimoEntrenamiento = Entrenamiento::where('usuario_id', $usuario->id)
            ->orderBy('fecha_entrenamiento', 'desc')
            ->first();

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
        // ACTIVIDAD SEMANAL (últimos 7 días, lunes a domingo)
        // ====================

        $actividadSemana = [];

        // Empezamos por el lunes de esta semana.
        $inicioSemana = $ahora->copy()->startOfWeek(); // Lunes 00:00:00

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
            'ultimoEntrenamiento',
            'ultimosEntrenamientos',
            'rutinaMasUsada',
            'actividadSemana',
            'sinActividad'
        ));
    }
}
