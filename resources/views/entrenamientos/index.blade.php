@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

    {{-- Cabecera --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">HISTORIAL DE ENTRENAMIENTOS</h1>
                <p class="text-sm text-neutral-500 mt-1">Tus sesiones de entrenamiento ordenadas por fecha.</p>
            </div>
            <a href="{{ route('entrenamientos.create') }}"
               class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-5 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center justify-center gap-2 sm:whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo entrenamiento
            </a>
        </div>
    </div>

    @if ($entrenamientos->isEmpty() && !request()->hasAny(['desde', 'hasta', 'rutina_id']))

        {{-- Estado vacío --}}
        <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white rounded-2xl p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-[#ffd600] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="font-bebas text-3xl mb-2 tracking-wide">SIN ENTRENAMIENTOS</h2>
            <p class="text-neutral-300 mb-6 max-w-md mx-auto">
                Registra tu primera sesión para empezar tu historial.
            </p>
            <a href="{{ route('entrenamientos.create') }}"
               class="inline-block bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-semibold px-6 py-3 rounded-lg transition">
                + Registrar primer entrenamiento
            </a>
        </div>

    @else
        {{-- Filtros --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-5 mb-4 shadow-sm">
            <form method="GET" action="{{ route('entrenamientos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                <div>
                    <label for="desde" class="block text-xs font-semibold text-neutral-700 mb-1.5">Desde</label>
                    <input id="desde" type="date" name="desde" value="{{ request('desde') }}"
                           class="w-full px-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none">
                </div>

                <div>
                    <label for="hasta" class="block text-xs font-semibold text-neutral-700 mb-1.5">Hasta</label>
                    <input id="hasta" type="date" name="hasta" value="{{ request('hasta') }}"
                           class="w-full px-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none">
                </div>

                <div>
                    <label for="rutina_id" class="block text-xs font-semibold text-neutral-700 mb-1.5">Rutina</label>
                    <select id="rutina_id" name="rutina_id"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none bg-white">
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
                            class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-semibold px-4 py-2.5 rounded-lg text-sm transition flex-1">
                        Filtrar
                    </button>
                    @if (request()->hasAny(['desde', 'hasta', 'rutina_id']))
                        <a href="{{ route('entrenamientos.index') }}"
                           class="bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium px-4 py-2.5 rounded-lg text-sm transition">
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

        @if ($entrenamientos->isEmpty())
            <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="font-bebas text-2xl text-[#0f172a] mb-2">SIN RESULTADOS</h3>
                <p class="text-sm text-neutral-500 mb-4">No se encontraron entrenamientos con esos filtros.</p>
                <a href="{{ route('entrenamientos.index') }}" class="inline-block text-sm text-[#0f172a] hover:underline font-medium">
                    Quitar filtros
                </a>
            </div>
        @else

            {{-- TABLA (desktop) / LISTA TARJETAS (móvil) --}}

            {{-- MÓVIL: tarjetas --}}
            <div class="md:hidden space-y-3">
                @foreach ($entrenamientos as $entrenamiento)
                    <div class="bg-white border border-neutral-200 rounded-2xl p-4 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-xl bg-[#ffd600]/20 text-[#854d0e] flex flex-col items-center justify-center flex-shrink-0">
                                <span class="text-[10px] uppercase font-bold leading-none mt-0.5">{{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('MMM') }}</span>
                                <span class="text-lg font-bold leading-none mb-0.5">{{ $entrenamiento->fecha_entrenamiento->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-[#0f172a]">{{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}</div>
                                <div class="text-xs text-neutral-500 capitalize">{{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-3 text-xs">
                            @if ($entrenamiento->rutina)
                                <span class="bg-[#ffd600]/20 text-[#854d0e] px-2 py-0.5 rounded-full font-semibold">
                                    {{ $entrenamiento->rutina->nombre }}
                                </span>
                            @else
                                <span class="text-neutral-400 italic">Sin rutina</span>
                            @endif
                            <span class="text-neutral-300">·</span>
                            <span class="text-neutral-600">{{ $entrenamiento->detalles()->count() }} {{ $entrenamiento->detalles()->count() === 1 ? 'ejercicio' : 'ejercicios' }}</span>
                        </div>

                        <div class="flex items-center gap-2 pt-3 border-t border-neutral-100">
                            <a href="{{ route('entrenamientos.show', $entrenamiento) }}"
                               class="flex-1 text-center text-xs bg-[#0f172a] hover:bg-[#1e293b] text-white font-semibold px-3 py-2 rounded-lg transition">
                                Ver
                            </a>
                            <a href="{{ route('entrenamientos.edit', $entrenamiento) }}"
                               class="w-9 h-9 flex items-center justify-center bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('entrenamientos.duplicar', $entrenamiento) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="w-9 h-9 flex items-center justify-center bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition" title="Duplicar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </form>
                            <form action="{{ route('entrenamientos.destroy', $entrenamiento) }}" method="POST" class="form-eliminar inline" data-fecha="{{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="abrirModalEliminar(this)" class="w-9 h-9 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- DESKTOP: tabla --}}
            <div class="hidden md:block bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-x-auto">
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
                                    <span class="font-semibold text-[#0f172a]">{{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}</span>
                                    <div class="text-xs text-neutral-400 mt-0.5 capitalize">{{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($entrenamiento->rutina)
                                        <span class="inline-block bg-[#ffd600]/20 text-[#854d0e] text-xs px-2.5 py-1 rounded-full font-semibold">{{ $entrenamiento->rutina->nombre }}</span>
                                    @else
                                        <span class="text-neutral-400 text-sm italic">Sin rutina</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-neutral-600">{{ $entrenamiento->detalles()->count() }} {{ $entrenamiento->detalles()->count() === 1 ? 'ejercicio' : 'ejercicios' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('entrenamientos.show', $entrenamiento) }}" class="text-xs font-semibold bg-[#0f172a] hover:bg-[#1e293b] text-white px-3 py-1.5 rounded-lg transition">Ver</a>
                                        <a href="{{ route('entrenamientos.edit', $entrenamiento) }}" class="w-8 h-8 flex items-center justify-center bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('entrenamientos.duplicar', $entrenamiento) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition" title="Duplicar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('entrenamientos.destroy', $entrenamiento) }}" method="POST" class="form-eliminar inline" data-fecha="{{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="abrirModalEliminar(this)" class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                                </svg>
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

{{-- Modal eliminación --}}
<div id="modal-eliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModalEliminar()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-red-50 px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">ELIMINAR ENTRENAMIENTO</h3>
                <p class="text-sm text-neutral-600 mt-1">Esta acción no se puede deshacer.</p>
            </div>
        </div>

        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700">
                ¿Estás segura de que quieres eliminar el entrenamiento del <strong id="modal-fecha" class="text-[#0f172a]"></strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">Se eliminarán también todos los ejercicios registrados en esta sesión.</p>
        </div>

        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModalEliminar()" class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">Cancelar</button>
            <button type="button" id="btn-confirmar-eliminar" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                </svg>
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

<script>
    let formAEliminar = null;

    function abrirModalEliminar(btn) {
        const form = btn.closest('.form-eliminar');
        formAEliminar = form;
        document.getElementById('modal-fecha').textContent = form.dataset.fecha;
        document.getElementById('modal-eliminar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalEliminar() {
        document.getElementById('modal-eliminar').classList.add('hidden');
        document.body.style.overflow = '';
        formAEliminar = null;
    }

    document.getElementById('btn-confirmar-eliminar').addEventListener('click', () => {
        if (formAEliminar) formAEliminar.submit();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') cerrarModalEliminar();
    });
</script>

@endsection