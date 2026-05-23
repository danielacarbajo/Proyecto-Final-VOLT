@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">

    {{-- CABECERA --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-2">
            <span class="bg-[#ffd600] text-[#0f172a] text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                Administrador
            </span>
        </div>
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">PANEL DEL ADMINISTRADOR</h1>
        <p class="text-sm text-neutral-500 mt-1">Vista general del sistema VOLT.</p>
    </div>

    {{-- MÉTRICAS GLOBALES (4 tarjetas) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

        <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start gap-3 mb-2">
                <div class="w-11 h-11 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mt-1">Usuarios</div>
            </div>
            <div class="font-bebas text-5xl text-[#0f172a] leading-none">{{ $totalUsuarios }}</div>
            <div class="text-xs text-neutral-400 mt-2">
                + {{ $totalAdmins }} {{ $totalAdmins === 1 ? 'admin' : 'admins' }}
            </div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start gap-3 mb-2">
                <div class="w-11 h-11 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="text-[10px] sm:text-xs font-semibold text-neutral-500 uppercase tracking-wider mt-1 min-w-0">
                    <span class="sm:hidden">Rutinas</span>
                    <span class="hidden sm:inline">Rutinas creadas</span>
                </div>
            </div>
            <div class="font-bebas text-5xl text-[#0f172a] leading-none">{{ $totalRutinas }}</div>
            <div class="text-xs text-neutral-400 mt-2">en toda la plataforma</div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start gap-3 mb-2">
                <div class="w-11 h-11 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mt-1">Ejercicios</div>
            </div>
            <div class="font-bebas text-5xl text-[#0f172a] leading-none">{{ $totalEjercicios }}</div>
            <div class="text-xs text-neutral-400 mt-2">catálogo global</div>
        </div>

        <div class="bg-[#0f172a] border border-[#0f172a] rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-start gap-3 mb-2">
                <div class="w-11 h-11 rounded-xl bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="text-[10px] sm:text-xs font-semibold text-[#ffd600] uppercase tracking-wider mt-1 min-w-0">
                    <span class="sm:hidden">Entrenos</span>
                    <span class="hidden sm:inline">Entrenamientos</span>
                </div>
            </div>
            <div class="font-bebas text-5xl text-[#ffd600] leading-none">{{ $totalEntrenamientos }}</div>
            <div class="text-xs text-neutral-400 mt-2">
                {{ $entrenamientosMes }} este mes
            </div>
        </div>

    </div>

    {{-- GRÁFICAS DE EVOLUCIÓN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <div class="bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h2 class="font-bebas text-xl sm:text-2xl text-[#0f172a] tracking-wide pb-0.5">USUARIOS NUEVOS POR MES</h2>
                    <p class="text-xs text-neutral-500">Últimos 6 meses</p>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="graficaUsuarios"></canvas>
            </div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h2 class="font-bebas text-xl sm:text-2xl text-[#0f172a] tracking-wide pb-0.5">ENTRENAMIENTOS POR MES</h2>
                    <p class="text-xs text-neutral-500">Últimos 6 meses</p>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="graficaEntrenamientos"></canvas>
            </div>
        </div>

    </div>

    {{-- LISTADOS RECIENTES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-5 sm:p-6 border-b border-neutral-100 flex-wrap gap-2">
                <h2 class="font-bebas text-xl sm:text-2xl text-[#0f172a] tracking-wide pb-0.5">USUARIOS RECIENTES</h2>
                <a href="{{ route('admin.usuarios') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-semibold text-[#0f172a] bg-[#ffd600]/10 hover:bg-[#ffd600]/20 border border-[#ffd600]/40 hover:border-[#ffd600] rounded-lg transition">
                    Ver todos
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if ($usuariosRecientes->isEmpty())
                <div class="p-8 text-center text-neutral-400 text-sm italic">
                    No hay usuarios registrados.
                </div>
            @else
                <div class="divide-y divide-neutral-100">
                    @foreach ($usuariosRecientes as $u)
                        <a href="{{ route('admin.usuarios.show', $u) }}"
                           class="flex items-center justify-between p-4 sm:p-5 hover:bg-neutral-50 transition group gap-2">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                @if ($u->foto)
                                    <img src="{{ asset('storage/' . $u->foto) }}" alt="Avatar"
                                         class="w-10 h-10 rounded-full object-cover border-2 {{ $u->rol_id === 2 ? 'border-[#ffd600]' : 'border-neutral-200' }} flex-shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full flex-shrink-0 {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600] border-2 border-[#ffd600]' : 'bg-[#ffd600] text-[#0f172a]' }} flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($u->nombre, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="font-semibold text-[#0f172a] group-hover:text-[#854d0e] transition truncate">
                                        {{ $u->nombre }}
                                    </div>
                                    <div class="text-xs text-neutral-500 truncate">{{ $u->email }}</div>
                                </div>
                            </div>
                            <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider px-2 sm:px-2.5 py-1 rounded-full flex-shrink-0
                                {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600]' : 'bg-neutral-100 text-neutral-700' }}">
                                {{ $u->rol->nombre }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-5 sm:p-6 border-b border-neutral-100">
                <h2 class="font-bebas text-xl sm:text-2xl text-[#0f172a] tracking-wide pb-0.5">ENTRENAMIENTOS RECIENTES</h2>
            </div>

            @if ($entrenamientosRecientes->isEmpty())
                <div class="p-8 text-center text-neutral-400 text-sm italic">
                    Aún no hay entrenamientos registrados.
                </div>
            @else
                <div class="divide-y divide-neutral-100">
                    @foreach ($entrenamientosRecientes as $ent)
                        <div class="flex items-center justify-between p-4 sm:p-5 hover:bg-neutral-50 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 text-[#854d0e] flex flex-col items-center justify-center flex-shrink-0">
                                    <span class="text-[9px] uppercase font-bold leading-none mt-0.5">{{ $ent->fecha_entrenamiento->locale('es')->isoFormat('MMM') }}</span>
                                    <span class="text-base font-bold leading-none mb-0.5">{{ $ent->fecha_entrenamiento->format('d') }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="font-semibold text-[#0f172a] truncate">
                                        {{ $ent->fecha_entrenamiento->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-neutral-500 mt-0.5 truncate">
                                        Por <span class="font-medium">{{ $ent->usuario->nombre }}</span>
                                        @if ($ent->rutina)
                                            <span class="ml-1 bg-[#ffd600]/20 text-[#854d0e] px-2 py-0.5 rounded-full font-semibold">
                                                {{ $ent->rutina->nombre }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const opcionesComunes = {
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
        };

        const ctxUsuarios = document.getElementById('graficaUsuarios');
        if (ctxUsuarios) {
            new Chart(ctxUsuarios, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($etiquetasMeses) !!},
                    datasets: [{
                        label: 'Usuarios nuevos',
                        data: {!! json_encode($usuariosPorMes) !!},
                        backgroundColor: '#ffd600',
                        borderColor: '#eab308',
                        borderWidth: 0,
                        borderRadius: 8,
                    }]
                },
                options: opcionesComunes
            });
        }

        const ctxEntrenos = document.getElementById('graficaEntrenamientos');
        if (ctxEntrenos) {
            new Chart(ctxEntrenos, {
                type: 'line',
                data: {
                    labels: {!! json_encode($etiquetasMeses) !!},
                    datasets: [{
                        label: 'Entrenamientos',
                        data: {!! json_encode($entrenamientosPorMes) !!},
                        borderColor: '#0f172a',
                        backgroundColor: 'rgba(15, 23, 42, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffd600',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        tension: 0.3,
                        fill: true,
                    }]
                },
                options: opcionesComunes
            });
        }

    });
</script>
@endsection