@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('entrenamientos.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al historial
        </a>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Cabecera con icono amarillo --}}
        <div class="bg-gradient-to-br from-[#ffd600]/20 to-[#ffd600]/5 px-8 py-6 border-b border-neutral-100">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">
                            {{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                        </h1>
                        <p class="text-sm text-neutral-500 capitalize">
                            {{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </p>
                        @if ($entrenamiento->rutina)
                            <span class="inline-block mt-2 bg-[#ffd600] text-[#0f172a] text-xs px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">
                                {{ $entrenamiento->rutina->nombre }}
                            </span>
                        @else
                            <span class="inline-block mt-2 text-xs text-neutral-400 italic">Sin rutina asociada</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('entrenamientos.edit', $entrenamiento) }}"
                       class="text-sm bg-white border border-neutral-200 hover:bg-neutral-50 text-[#0f172a] font-medium px-4 py-2 rounded-lg transition flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('entrenamientos.destroy', $entrenamiento) }}" method="POST" class="form-eliminar" data-fecha="{{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="abrirModalEliminar(this)"
                                class="text-sm bg-red-50 hover:bg-red-100 text-red-600 font-medium px-4 py-2 rounded-lg transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Contenido --}}
        <div class="p-8">

            <h2 class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-4">
                Ejercicios realizados ({{ $entrenamiento->detalles->count() }})
            </h2>

            <div class="overflow-hidden rounded-xl border border-neutral-200">
                <table class="w-full">
                    <thead class="bg-neutral-50 border-b border-neutral-200">
                        <tr>
                            <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Ejercicio</th>
                            <th class="text-center text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Series</th>
                            <th class="text-center text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Reps</th>
                            <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Peso</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @foreach ($entrenamiento->detalles as $detalle)
                            <tr class="hover:bg-neutral-50 transition">
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-[#0f172a]">{{ $detalle->ejercicio->nombre }}</span>
                                    @if ($detalle->ejercicio->grupo_muscular)
                                        <div class="text-xs text-neutral-400 mt-0.5">{{ $detalle->ejercicio->grupo_muscular }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-bebas text-lg text-[#0f172a]">{{ $detalle->series }}</td>
                                <td class="px-4 py-3 text-center font-bebas text-lg text-[#0f172a]">{{ $detalle->repeticiones }}</td>
                                <td class="px-4 py-3 text-right">
                                    <span class="font-bebas text-lg text-[#0f172a]">{{ rtrim(rtrim(number_format($detalle->peso, 2), '0'), '.') }}</span>
                                    <span class="text-xs text-neutral-500 ml-1">kg</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

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
            <p class="text-xs text-neutral-500 mt-2">
                Se eliminarán también todos los ejercicios registrados en esta sesión.
            </p>
        </div>

        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModalEliminar()"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" id="btn-confirmar-eliminar"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition flex items-center gap-2">
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