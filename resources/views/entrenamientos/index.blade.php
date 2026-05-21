@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a]">Historial de entrenamientos</h1>
            <p class="text-sm text-neutral-500 mt-1">Tus sesiones de entrenamiento ordenadas por fecha.</p>
        </div>
        <a href="{{ route('entrenamientos.create') }}"
           class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
            + Nuevo entrenamiento
        </a>
    </div>

    @if ($entrenamientos->isEmpty() && !request()->hasAny(['desde', 'hasta', 'rutina_id']))
        <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center">
            <div class="text-6xl mb-4">🏃</div>
            <h2 class="text-xl font-semibold text-[#0f172a] mb-2">Aún no has registrado entrenamientos</h2>
            <p class="text-neutral-500 mb-6">Registra tu primera sesión para empezar tu historial.</p>
            <a href="{{ route('entrenamientos.create') }}"
               class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition">
                Registrar primer entrenamiento
            </a>
        </div>
    @else
        {{-- Filtros --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-5 mb-4">
            <form method="GET" action="{{ route('entrenamientos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                <div>
                    <label for="desde" class="block text-xs font-semibold text-neutral-700 mb-1">Desde</label>
                    <input
                        id="desde"
                        type="date"
                        name="desde"
                        value="{{ request('desde') }}"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    >
                </div>

                <div>
                    <label for="hasta" class="block text-xs font-semibold text-neutral-700 mb-1">Hasta</label>
                    <input
                        id="hasta"
                        type="date"
                        name="hasta"
                        value="{{ request('hasta') }}"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    >
                </div>

                <div>
                    <label for="rutina_id" class="block text-xs font-semibold text-neutral-700 mb-1">Rutina</label>
                    <select
                        id="rutina_id"
                        name="rutina_id"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none bg-white"
                    >
                        <option value="">Todas las rutinas</option>
                        @foreach ($rutinas as $rutina)
                            <option value="{{ $rutina->id }}" {{ request('rutina_id') == $rutina->id ? 'selected' : '' }}>
                                {{ $rutina->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-medium px-4 py-2 rounded-lg text-sm transition flex-1">
                        Filtrar
                    </button>
                    @if (request()->hasAny(['desde', 'hasta', 'rutina_id']))
                        <a href="{{ route('entrenamientos.index') }}"
                           class="bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium px-4 py-2 rounded-lg text-sm transition">
                            Limpiar
                        </a>
                    @endif
                </div>

            </form>

            @error('desde')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
            @error('hasta')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Mensaje cuando hay filtros aplicados pero sin resultados --}}
        @if ($entrenamientos->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
                <p class="text-yellow-800 font-medium mb-2">No se encontraron entrenamientos con esos filtros.</p>
                <a href="{{ route('entrenamientos.index') }}" class="text-sm text-yellow-700 underline hover:text-yellow-900">
                    Quitar filtros
                </a>
            </div>
        @else
            <div class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead class="bg-neutral-50 border-b border-neutral-200">
                        <tr>
                            <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Fecha</th>
                            <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Rutina</th>
                            <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Ejercicios</th>
                            <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @foreach ($entrenamientos as $entrenamiento)
                            <tr class="hover:bg-neutral-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-[#0f172a]">
                                        {{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                                    </span>
                                    <div class="text-xs text-neutral-400 mt-0.5">
                                        {{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($entrenamiento->rutina)
                                        <span class="inline-block bg-[#facc15]/20 text-[#854d0e] text-xs px-2.5 py-1 rounded-full font-medium">
                                            {{ $entrenamiento->rutina->nombre }}
                                        </span>
                                    @else
                                        <span class="text-neutral-400 text-sm italic">Sin rutina</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-neutral-600">
                                    {{ $entrenamiento->detalles()->count() }} {{ $entrenamiento->detalles()->count() === 1 ? 'ejercicio' : 'ejercicios' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('entrenamientos.show', $entrenamiento) }}"
                                           class="text-sm text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                            Ver
                                        </a>
                                        <a href="{{ route('entrenamientos.edit', $entrenamiento) }}"
                                           class="text-sm text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                            Editar
                                        </a>
                                        <form action="{{ route('entrenamientos.destroy', $entrenamiento) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Seguro que quieres eliminar este entrenamiento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

</div>
@endsection
