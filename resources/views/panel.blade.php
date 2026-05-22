@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">

    {{-- ===================================================== --}}
    {{-- CABECERA --}}
    {{-- ===================================================== --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#0f172a]">
            ¡Hola, {{ auth()->user()->nombre }}! 👋
        </h1>
        <p class="text-neutral-500 mt-1">
            @if ($sinActividad)
                Bienvenida a VOLT. Empieza a registrar tus entrenamientos para ver aquí tu progreso.
            @else
                Aquí tienes el resumen de tu actividad reciente.
            @endif
        </p>
    </div>


    @if ($sinActividad)
        {{-- ===================================================== --}}
        {{-- ESTADO VACÍO: usuario nuevo sin entrenamientos --}}
        {{-- ===================================================== --}}
        <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white rounded-2xl p-10 text-center">
            <div class="text-6xl mb-4">💪</div>
            <h2 class="text-2xl font-bold mb-2">¿Empezamos?</h2>
            <p class="text-neutral-300 mb-6 max-w-md mx-auto">
                Crea tu primera rutina o registra tu primer entrenamiento.
                VOLT te ayudará a seguir tu evolución sesión a sesión.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('rutinas.create') }}"
                   class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-3 rounded-lg transition">
                    + Crear mi primera rutina
                </a>
                <a href="{{ route('entrenamientos.create') }}"
                   class="inline-block bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-lg transition border border-white/20">
                    + Registrar entrenamiento
                </a>
            </div>
        </div>

    @else
        {{-- ===================================================== --}}
        {{-- MÉTRICAS PRINCIPALES (4 tarjetas) --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

            {{-- Total entrenamientos --}}
            <div class="bg-white border border-neutral-200 rounded-xl p-5 shadow-sm">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Entrenamientos</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $totalEntrenamientos }}</div>
                <div class="text-xs text-neutral-400 mt-1">en total</div>
            </div>

            {{-- Este mes --}}
            <div class="bg-[#facc15] border border-[#eab308] rounded-xl p-5 shadow-sm">
                <div class="text-xs font-medium text-[#854d0e] uppercase tracking-wider mb-1">Este mes</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $entrenamientosMes }}</div>
                <div class="text-xs text-[#854d0e] mt-1">
                    {{ $entrenamientosMes === 1 ? 'sesión' : 'sesiones' }}
                </div>
            </div>

            {{-- Rutinas --}}
            <div class="bg-white border border-neutral-200 rounded-xl p-5 shadow-sm">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Rutinas</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $totalRutinas }}</div>
                <div class="text-xs text-neutral-400 mt-1">creadas</div>
            </div>

            {{-- Ejercicios --}}
            <div class="bg-white border border-neutral-200 rounded-xl p-5 shadow-sm">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Ejercicios</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $totalEjercicios }}</div>
                <div class="text-xs text-neutral-400 mt-1">en tu catálogo</div>
            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- INFO DESTACADA: último entreno + rutina favorita --}}
        {{-- ===================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

            {{-- Último entrenamiento --}}
            @if ($ultimoEntrenamiento)
                @php
                    $diasDesde = (int) floor($ultimoEntrenamiento->fecha_entrenamiento->diffInDays(now()));
                @endphp
                <div class="bg-white border border-neutral-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Último entrenamiento</div>
                        <span class="text-2xl">📅</span>
                    </div>
                    <div class="text-2xl font-bold text-[#0f172a]">
                        {{ $ultimoEntrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                    </div>
                    <div class="text-sm text-neutral-500 mt-1">
                        @if ($diasDesde === 0)
                            Hoy mismo
                        @elseif ($diasDesde === 1)
                            Ayer
                        @else
                            Hace {{ $diasDesde }} días
                        @endif
                        @if ($ultimoEntrenamiento->rutina)
                            · <span class="bg-[#facc15]/20 text-[#854d0e] px-2 py-0.5 rounded-full text-xs font-medium">{{ $ultimoEntrenamiento->rutina->nombre }}</span>
                        @endif
                    </div>
                    <a href="{{ route('entrenamientos.show', $ultimoEntrenamiento) }}"
                       class="inline-block text-sm text-[#0f172a] font-medium hover:underline mt-3">
                        Ver detalle →
                    </a>
                </div>
            @endif

            {{-- Rutina más usada --}}
            @if ($rutinaMasUsada && $rutinaMasUsada->rutina)
                <div class="bg-white border border-neutral-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Rutina más usada (30 días)</div>
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div class="text-2xl font-bold text-[#0f172a]">
                        {{ $rutinaMasUsada->rutina->nombre }}
                    </div>
                    <div class="text-sm text-neutral-500 mt-1">
                        {{ $rutinaMasUsada->total }} {{ $rutinaMasUsada->total === 1 ? 'sesión' : 'sesiones' }}
                    </div>
                    <a href="{{ route('rutinas.show', $rutinaMasUsada->rutina) }}"
                       class="inline-block text-sm text-[#0f172a] font-medium hover:underline mt-3">
                        Ver rutina →
                    </a>
                </div>
            @else
                <div class="bg-neutral-50 border border-dashed border-neutral-300 rounded-xl p-5 flex flex-col items-center justify-center text-center">
                    <span class="text-3xl mb-2">⭐</span>
                    <div class="text-sm text-neutral-500">Empieza a usar tus rutinas en los entrenamientos para ver aquí tu favorita.</div>
                </div>
            @endif

        </div>


        {{-- ===================================================== --}}
        {{-- ACCESOS RÁPIDOS --}}
        {{-- ===================================================== --}}
        <h2 class="text-lg font-semibold text-[#0f172a] mb-3">Accesos rápidos</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
            <a href="{{ route('entrenamientos.create') }}"
               class="group bg-[#0f172a] hover:bg-[#1e293b] text-white rounded-xl p-5 transition flex flex-col items-center gap-2 text-center">
                <span class="text-3xl group-hover:scale-110 transition">➕</span>
                <span class="text-sm font-semibold">Nuevo entrenamiento</span>
            </a>

            <a href="{{ route('entrenamientos.index') }}"
               class="group bg-white border border-neutral-200 hover:border-[#facc15] rounded-xl p-5 transition flex flex-col items-center gap-2 text-center">
                <span class="text-3xl group-hover:scale-110 transition">📋</span>
                <span class="text-sm font-semibold text-[#0f172a]">Ver historial</span>
            </a>

            <a href="{{ route('rutinas.index') }}"
               class="group bg-white border border-neutral-200 hover:border-[#facc15] rounded-xl p-5 transition flex flex-col items-center gap-2 text-center">
                <span class="text-3xl group-hover:scale-110 transition">🗂️</span>
                <span class="text-sm font-semibold text-[#0f172a]">Mis rutinas</span>
            </a>

            <a href="{{ route('ejercicios.index') }}"
               class="group bg-white border border-neutral-200 hover:border-[#facc15] rounded-xl p-5 transition flex flex-col items-center gap-2 text-center">
                <span class="text-3xl group-hover:scale-110 transition">💪</span>
                <span class="text-sm font-semibold text-[#0f172a]">Mis ejercicios</span>
            </a>
        </div>


        {{-- ===================================================== --}}
        {{-- ÚLTIMOS ENTRENAMIENTOS --}}
        {{-- ===================================================== --}}
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-[#0f172a]">Últimos entrenamientos</h2>
            <a href="{{ route('entrenamientos.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
                Ver todos →
            </a>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-neutral-100">
                @foreach ($ultimosEntrenamientos as $entreno)
                    <a href="{{ route('entrenamientos.show', $entreno) }}"
                       class="flex items-center justify-between p-5 hover:bg-neutral-50 transition group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-[#facc15]/20 text-[#854d0e] flex items-center justify-center font-bold text-sm flex-shrink-0">
                                {{ $entreno->fecha_entrenamiento->format('d/m') }}
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
                        <span class="text-neutral-300 group-hover:text-[#0f172a] group-hover:translate-x-1 transition">→</span>
                    </a>
                @endforeach
            </div>
        </div>

    @endif

</div>
@endsection
