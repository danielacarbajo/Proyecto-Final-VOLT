@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">

    {{-- Cabecera --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-1">
            <span class="bg-[#facc15] text-[#0f172a] text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                Administrador
            </span>
        </div>
        <h1 class="text-3xl font-bold text-[#0f172a]">
            Panel de administración 🛡️
        </h1>
        <p class="text-sm text-neutral-500 mt-1">Vista general del sistema VOLT.</p>
    </div>

    {{-- Tarjetas de métricas globales --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

        <div class="bg-white border border-neutral-200 rounded-xl p-5">
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Usuarios</div>
            <div class="text-3xl font-bold text-[#0f172a]">{{ $totalUsuarios }}</div>
            <div class="text-xs text-neutral-400 mt-2">
                + {{ $totalAdmins }} {{ $totalAdmins === 1 ? 'admin' : 'admins' }}
            </div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-xl p-5">
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Rutinas creadas</div>
            <div class="text-3xl font-bold text-[#0f172a]">{{ $totalRutinas }}</div>
            <div class="text-xs text-neutral-400 mt-2">en toda la plataforma</div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-xl p-5">
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Ejercicios</div>
            <div class="text-3xl font-bold text-[#0f172a]">{{ $totalEjercicios }}</div>
            <div class="text-xs text-neutral-400 mt-2">catálogo global</div>
        </div>

        <div class="bg-[#0f172a] border border-[#0f172a] rounded-xl p-5">
            <div class="text-xs font-medium text-[#facc15] uppercase tracking-wider mb-1">Entrenamientos</div>
            <div class="text-3xl font-bold text-[#facc15]">{{ $totalEntrenamientos }}</div>
            <div class="text-xs text-neutral-400 mt-2">
                {{ $entrenamientosMes }} este mes
            </div>
        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- GRÁFICAS DE EVOLUCIÓN (últimos 6 meses) --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- Gráfica de usuarios nuevos por mes --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xl">📈</span>
                <div>
                    <h2 class="text-lg font-semibold text-[#0f172a]">Usuarios nuevos por mes</h2>
                    <p class="text-xs text-neutral-500">Últimos 6 meses</p>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="graficaUsuarios"></canvas>
            </div>
        </div>

        {{-- Gráfica de entrenamientos por mes --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-xl">📊</span>
                <div>
                    <h2 class="text-lg font-semibold text-[#0f172a]">Entrenamientos por mes</h2>
                    <p class="text-xs text-neutral-500">Últimos 6 meses</p>
                </div>
            </div>
            <div style="height: 280px;">
                <canvas id="graficaEntrenamientos"></canvas>
            </div>
        </div>

    </div>

    {{-- Dos columnas: usuarios recientes y entrenamientos recientes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Usuarios recientes --}}
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-neutral-100">
                <h2 class="text-lg font-semibold text-[#0f172a]">Usuarios recientes</h2>
                <a href="{{ route('admin.usuarios') }}" class="text-sm text-[#eab308] hover:text-[#854d0e] font-medium transition">
                    Ver todos →
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
                           class="flex items-center justify-between p-5 hover:bg-neutral-50 transition group">
                            <div class="flex items-center gap-3">
                                @if ($u->foto)
                                    <img src="{{ asset('storage/' . $u->foto) }}" alt="Avatar"
                                         class="w-10 h-10 rounded-full object-cover border {{ $u->rol_id === 2 ? 'border-[#facc15]' : 'border-neutral-200' }}">
                                @else
                                    <div class="w-10 h-10 rounded-full {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15]' : 'bg-[#facc15] text-[#0f172a]' }} flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($u->nombre, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-[#0f172a] group-hover:text-[#eab308] transition">
                                        {{ $u->nombre }}
                                    </div>
                                    <div class="text-xs text-neutral-500">{{ $u->email }}</div>
                                </div>
                            </div>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15]' : 'bg-neutral-100 text-neutral-700' }}">
                                {{ $u->rol->nombre }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Entrenamientos recientes --}}
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-neutral-100">
                <h2 class="text-lg font-semibold text-[#0f172a]">Entrenamientos recientes</h2>
            </div>

            @if ($entrenamientosRecientes->isEmpty())
                <div class="p-8 text-center text-neutral-400 text-sm italic">
                    Aún no hay entrenamientos registrados.
                </div>
            @else
                <div class="divide-y divide-neutral-100">
                    @foreach ($entrenamientosRecientes as $ent)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <div class="font-medium text-[#0f172a]">
                                    {{ $ent->fecha_entrenamiento->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-neutral-500 mt-1">
                                    Por <span class="font-medium">{{ $ent->usuario->nombre }}</span>
                                    @if ($ent->rutina)
                                        ·
                                        <span class="bg-[#facc15]/20 text-[#854d0e] px-2 py-0.5 rounded-full font-medium">
                                            {{ $ent->rutina->nombre }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>

{{-- Chart.js desde CDN --}}
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
                    titleColor: '#facc15',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        };

        // Gráfica 1: Usuarios nuevos por mes (barras amarillas)
        const ctxUsuarios = document.getElementById('graficaUsuarios');
        if (ctxUsuarios) {
            new Chart(ctxUsuarios, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($etiquetasMeses) !!},
                    datasets: [{
                        label: 'Usuarios nuevos',
                        data: {!! json_encode($usuariosPorMes) !!},
                        backgroundColor: '#facc15',
                        borderColor: '#eab308',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: opcionesComunes
            });
        }

        // Gráfica 2: Entrenamientos por mes (línea navy)
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
                        pointBackgroundColor: '#facc15',
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
