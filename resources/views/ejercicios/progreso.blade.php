@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('ejercicios.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Mis ejercicios
        </a>
    </div>

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">
            PROGRESO DE {{ strtoupper($ejercicio->nombre) }}
        </h1>
        @if ($ejercicio->grupo_muscular)
            <div class="mt-2">
                <span class="inline-block bg-[#ffd600]/20 text-[#854d0e] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                    {{ $ejercicio->grupo_muscular }}
                </span>
            </div>
        @endif
    </div>

    @if ($totalRegistros === 0)

        {{-- ============================ --}}
        {{-- ESTADO VACÍO (compacto) --}}
        {{-- ============================ --}}

        {{-- Cards vacías arriba para no dejar la pantalla pelada --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Sesiones</div>
                <div class="font-bebas text-3xl text-neutral-300 leading-tight pb-1">—</div>
            </div>
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Mejor peso</div>
                <div class="font-bebas text-3xl text-neutral-300 leading-tight pb-1">— kg</div>
            </div>
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Peso mínimo</div>
                <div class="font-bebas text-3xl text-neutral-300 leading-tight pb-1">— kg</div>
            </div>
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Progreso</div>
                <div class="font-bebas text-3xl text-neutral-300 leading-tight pb-1">— kg</div>
            </div>
        </div>

        {{-- Mensaje compacto --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-8 text-center">
            <div class="w-14 h-14 rounded-full bg-[#ffd600]/20 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="font-bebas text-2xl text-[#0f172a] mb-2 tracking-wide">AÚN NO HAY REGISTROS DE PROGRESO</h2>
            <p class="text-sm text-neutral-500 mb-5 max-w-md mx-auto">
                Registra este ejercicio en un entrenamiento para ver aquí tu evolución de peso, repeticiones y mejores marcas.
            </p>
            <a href="{{ route('entrenamientos.create') }}"
               class="inline-flex items-center gap-2 bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Registrar entrenamiento
            </a>
        </div>

    @else

        {{-- ============================ --}}
        {{-- MÉTRICAS RESUMEN --}}
        {{-- ============================ --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Sesiones</div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $totalRegistros }}</div>
            </div>

            <div class="bg-[#ffd600] border border-[#eab308] rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-[#0f172a] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ffd600]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-[#854d0e] uppercase tracking-wider">Mejor marca</div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $pesoMaximo }} kg</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Peso mínimo</div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $pesoMinimo }} kg</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Progreso</div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">+{{ $diferencia }} kg</div>
            </div>

        </div>

        {{-- Gráfica --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1 mb-4">EVOLUCIÓN DEL PESO</h2>
            <div style="height: 380px;">
                <canvas id="graficaProgreso"></canvas>
            </div>
        </div>

    @endif

</div>

@if ($totalRegistros > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('graficaProgreso');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($etiquetas) !!},
                    datasets: [{
                        label: 'Peso máx. del día (kg)',
                        data: {!! json_encode($pesos) !!},
                        borderColor: '#ffd600',
                        backgroundColor: 'rgba(255, 214, 0, 0.15)',
                        borderWidth: 3,
                        pointBackgroundColor: '#0f172a',
                        pointBorderColor: '#ffd600',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        tension: 0.3,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#ffd600',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) { return context.parsed.y + ' kg'; }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: { callback: v => v + ' kg' },
                            grid: { color: 'rgba(0, 0, 0, 0.05)' }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endif

@endsection