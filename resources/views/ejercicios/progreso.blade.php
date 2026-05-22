@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

    {{-- Volver --}}
    <div class="mb-6">
        <a href="{{ route('ejercicios.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver a ejercicios
        </a>
    </div>

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#0f172a]">
            Progreso · {{ $ejercicio->nombre }}
        </h1>
        @if ($ejercicio->grupo_muscular)
            <p class="text-sm text-neutral-500 mt-1">
                <span class="inline-block bg-neutral-100 text-neutral-700 text-xs px-2.5 py-1 rounded-full">
                    {{ $ejercicio->grupo_muscular }}
                </span>
            </p>
        @endif
    </div>

    @if ($totalRegistros === 0)
        {{-- Sin datos --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center">
            <div class="text-6xl mb-4">📊</div>
            <h2 class="text-xl font-semibold text-[#0f172a] mb-2">Aún no hay datos de progreso</h2>
            <p class="text-neutral-500 mb-6">
                Registra entrenamientos con el ejercicio "{{ $ejercicio->nombre }}" para ver aquí tu evolución.
            </p>
            <a href="{{ route('entrenamientos.create') }}"
               class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition">
                + Registrar entrenamiento
            </a>
        </div>
    @else
        {{-- Métricas resumen --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Sesiones</div>
                <div class="text-2xl font-bold text-[#0f172a]">{{ $totalRegistros }}</div>
            </div>
            <div class="bg-[#facc15] border border-[#eab308] rounded-xl p-4 shadow-sm">
                <div class="text-xs font-medium text-[#854d0e] uppercase tracking-wider mb-1">Mejor marca</div>
                <div class="text-2xl font-bold text-[#0f172a]">{{ $pesoMaximo }} kg</div>
            </div>
            <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Peso mínimo</div>
                <div class="text-2xl font-bold text-[#0f172a]">{{ $pesoMinimo }} kg</div>
            </div>
            <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Progreso total</div>
                <div class="text-2xl font-bold text-[#0f172a]">+{{ $diferencia }} kg</div>
            </div>
        </div>

        {{-- Gráfica --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-[#0f172a] mb-4">Evolución del peso</h2>
            <div style="height: 380px;">
                <canvas id="graficaProgreso"></canvas>
            </div>
        </div>
    @endif

</div>

@if ($totalRegistros > 0)
    {{-- Chart.js desde CDN --}}
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
                        borderColor: '#facc15',
                        backgroundColor: 'rgba(250, 204, 21, 0.15)',
                        borderWidth: 3,
                        pointBackgroundColor: '#0f172a',
                        pointBorderColor: '#facc15',
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
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#facc15',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' kg';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value) {
                                    return value + ' kg';
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endif

@endsection
