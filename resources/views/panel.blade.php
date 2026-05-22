@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">

    {{-- ===================================================== --}}
    {{-- CABECERA --}}
    {{-- ===================================================== --}}
    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-4xl font-bold text-[#0f172a] tracking-wide">
                ¡HOLA, {{ strtoupper(auth()->user()->nombre) }}!
            </h1>
            <p class="text-neutral-500 mt-1">
                @if ($sinActividad)
                    Bienvenida a VOLT. Empieza a registrar tus entrenamientos.
                @else
                    Aquí tienes el resumen de tu actividad reciente.
                @endif
            </p>
        </div>
    </div>


    @if ($sinActividad)
        {{-- ===================================================== --}}
        {{-- ESTADO VACÍO --}}
        {{-- ===================================================== --}}
        <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white rounded-2xl p-10 text-center">
            <div class="w-20 h-20 rounded-full bg-[#facc15] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold mb-2 tracking-wide">¿EMPEZAMOS?</h2>
            <p class="text-neutral-300 mb-6 max-w-md mx-auto">
                Crea tu primera rutina o registra tu primer entrenamiento.
                VOLT te ayudará a seguir tu evolución sesión a sesión.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('rutinas.create') }}"
                   class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-3 rounded-lg transition">
                    Crear mi primera rutina
                </a>
                <a href="{{ route('entrenamientos.create') }}"
                   class="inline-block bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-lg transition border border-white/20">
                    Registrar entrenamiento
                </a>
            </div>
        </div>

    @else
        {{-- ===================================================== --}}
        {{-- MÉTRICAS PRINCIPALES (4 tarjetas con iconos amarillos) --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

            {{-- Total entrenamientos --}}
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-11 h-11 rounded-xl bg-[#facc15]/20 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mt-1">
                        Entrenamientos
                    </div>
                </div>
                <div class="numero-metrica text-5xl text-[#0f172a]">{{ $totalEntrenamientos }}</div>
                <div class="text-xs text-neutral-400 mt-1">en total</div>
            </div>

            {{-- Este mes (destacada en amarillo) --}}
            <div class="bg-[#facc15] border border-[#eab308] rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-11 h-11 rounded-xl bg-[#0f172a] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#facc15]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-[#854d0e] uppercase tracking-wider mt-1">
                        Este mes
                    </div>
                </div>
                <div class="numero-metrica text-5xl text-[#0f172a]">{{ $entrenamientosMes }}</div>
                <div class="text-xs text-[#854d0e] font-medium mt-1">
                    {{ $entrenamientosMes === 1 ? 'sesión' : 'sesiones' }}
                </div>
            </div>

            {{-- Rutinas --}}
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-11 h-11 rounded-xl bg-[#facc15]/20 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mt-1">
                        Rutinas
                    </div>
                </div>
                <div class="numero-metrica text-5xl text-[#0f172a]">{{ $totalRutinas }}</div>
                <div class="text-xs text-neutral-400 mt-1">creadas</div>
            </div>

            {{-- Ejercicios --}}
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-11 h-11 rounded-xl bg-[#facc15]/20 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mt-1">
                        Ejercicios
                    </div>
                </div>
                <div class="numero-metrica text-5xl text-[#0f172a]">{{ $totalEjercicios }}</div>
                <div class="text-xs text-neutral-400 mt-1">en tu catálogo</div>
            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- DOS COLUMNAS: ACTIVIDAD SEMANAL + INFO LATERAL --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">

            {{-- Gráfica de actividad semanal --}}
            <div class="lg:col-span-2 bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-[#0f172a]">Actividad semanal</h2>
                        <p class="text-xs text-neutral-500 mt-0.5">Últimos 7 días</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-[#facc15]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <div style="height: 240px;">
                    <canvas id="graficaSemana"></canvas>
                </div>
            </div>

            {{-- Columna lateral: último entreno + favorita --}}
            <div class="space-y-4">

                @if ($ultimoEntrenamiento)
                    @php
                        $diasDesde = (int) floor($ultimoEntrenamiento->fecha_entrenamiento->diffInDays(now()));
                    @endphp
                    <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-[#facc15]/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">
                                Último entreno
                            </div>
                        </div>
                        <div class="numero-metrica text-2xl text-[#0f172a]">
                            {{ $ultimoEntrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-neutral-500 mt-1">
                            @if ($diasDesde === 0)
                                Hoy mismo
                            @elseif ($diasDesde === 1)
                                Ayer
                            @else
                                Hace {{ $diasDesde }} días
                            @endif
                        </div>
                        @if ($ultimoEntrenamiento->rutina)
                            <div class="mt-2">
                                <span class="bg-[#facc15]/20 text-[#854d0e] px-2 py-0.5 rounded-full text-xs font-medium">
                                    {{ $ultimoEntrenamiento->rutina->nombre }}
                                </span>
                            </div>
                        @endif
                        <a href="{{ route('entrenamientos.show', $ultimoEntrenamiento) }}"
                           class="inline-flex items-center gap-1 text-sm text-[#0f172a] font-medium hover:underline mt-3">
                            Ver detalle
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endif

                @if ($rutinaMasUsada && $rutinaMasUsada->rutina)
                    <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-[#facc15]/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">
                                Rutina favorita
                            </div>
                        </div>
                        <div class="text-xl font-bold text-[#0f172a]">
                            {{ $rutinaMasUsada->rutina->nombre }}
                        </div>
                        <div class="text-xs text-neutral-500 mt-1">
                            {{ $rutinaMasUsada->total }} {{ $rutinaMasUsada->total === 1 ? 'sesión en 30 días' : 'sesiones en 30 días' }}
                        </div>
                        <a href="{{ route('rutinas.show', $rutinaMasUsada->rutina) }}"
                           class="inline-flex items-center gap-1 text-sm text-[#0f172a] font-medium hover:underline mt-3">
                            Ver rutina
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="bg-neutral-50 border border-dashed border-neutral-300 rounded-2xl p-5 flex flex-col items-center justify-center text-center">
                        <div class="w-10 h-10 rounded-xl bg-neutral-200 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div class="text-xs text-neutral-500">Usa tus rutinas en entrenamientos para ver aquí tu favorita.</div>
                    </div>
                @endif

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- ACCESOS RÁPIDOS --}}
        {{-- ===================================================== --}}
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-[#0f172a]">Accesos rápidos</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
            <a href="{{ route('entrenamientos.create') }}"
               class="group bg-[#0f172a] hover:bg-[#1e293b] text-white rounded-2xl p-5 transition flex flex-col items-center gap-2 text-center">
                <div class="w-12 h-12 rounded-xl bg-[#facc15] flex items-center justify-center group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold">Nuevo entrenamiento</span>
            </a>

            <a href="{{ route('entrenamientos.index') }}"
               class="group bg-white border border-neutral-200 hover:border-[#facc15] hover:shadow-md rounded-2xl p-5 transition flex flex-col items-center gap-2 text-center">
                <div class="w-12 h-12 rounded-xl bg-[#facc15]/20 flex items-center justify-center group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-[#0f172a]">Ver historial</span>
            </a>

            <a href="{{ route('rutinas.index') }}"
               class="group bg-white border border-neutral-200 hover:border-[#facc15] hover:shadow-md rounded-2xl p-5 transition flex flex-col items-center gap-2 text-center">
                <div class="w-12 h-12 rounded-xl bg-[#facc15]/20 flex items-center justify-center group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-[#0f172a]">Mis rutinas</span>
            </a>

            <a href="{{ route('ejercicios.index') }}"
               class="group bg-white border border-neutral-200 hover:border-[#facc15] hover:shadow-md rounded-2xl p-5 transition flex flex-col items-center gap-2 text-center">
                <div class="w-12 h-12 rounded-xl bg-[#facc15]/20 flex items-center justify-center group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-[#0f172a]">Mis ejercicios</span>
            </a>
        </div>


        {{-- ===================================================== --}}
        {{-- ÚLTIMOS ENTRENAMIENTOS --}}
        {{-- ===================================================== --}}
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-[#0f172a]">Últimos entrenamientos</h2>
            <a href="{{ route('entrenamientos.index') }}" class="text-sm text-[#854d0e] hover:text-[#0f172a] font-medium transition">
                Ver todos →
            </a>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-neutral-100">
                @foreach ($ultimosEntrenamientos as $entreno)
                    <a href="{{ route('entrenamientos.show', $entreno) }}"
                       class="flex items-center justify-between p-5 hover:bg-neutral-50 transition group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#facc15]/20 text-[#854d0e] flex flex-col items-center justify-center flex-shrink-0">
                                <span class="text-[10px] uppercase font-semibold leading-none mt-0.5">{{ $entreno->fecha_entrenamiento->locale('es')->isoFormat('MMM') }}</span>
                                <span class="text-lg font-bold leading-none mb-0.5">{{ $entreno->fecha_entrenamiento->format('d') }}</span>
                            </div>
                            <div>
                                <div class="font-semibold text-[#0f172a]">
                                    {{ $entreno->fecha_entrenamiento->format('d/m/Y') }}
                                    <span class="text-xs text-neutral-400 ml-2 capitalize">
                                        {{ $entreno->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}
                                    </span>
                                </div>
                                <div class="text-xs text-neutral-500 mt-0.5">
                                    @if ($entreno->rutina)
                                        <span class="bg-[#facc15]/20 text-[#854d0e] px-2 py-0.5 rounded-full font-medium">
                                            {{ $entreno->rutina->nombre }}
                                        </span>
                                    @else
                                        <span class="italic">Sin rutina</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-300 group-hover:text-[#0f172a] group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>

    @endif

</div>

{{-- ============================================ --}}
{{-- GRÁFICA DE ACTIVIDAD SEMANAL (Chart.js) --}}
{{-- ============================================ --}}
@if (!$sinActividad)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('graficaSemana');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Entrenamientos',
                    data: {!! json_encode($actividadSemana ?? [0,0,0,0,0,0,0]) !!},
                    backgroundColor: '#facc15',
                    borderColor: '#eab308',
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 28,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#facc15',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#94a3b8' },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        ticks: { color: '#64748b', font: { weight: '600' } },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endif

@endsection
