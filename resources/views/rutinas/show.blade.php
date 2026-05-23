@extends('layouts.app')

@section('contenido')
<div class="max-w-3xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('rutinas.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Mis rutinas
        </a>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Cabecera con gradient amarillo --}}
        <div class="bg-gradient-to-br from-[#ffd600]/20 to-[#ffd600]/5 px-6 sm:px-8 py-6 border-b border-neutral-100">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-14 h-14 rounded-2xl bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="font-bebas text-3xl sm:text-4xl text-[#0f172a] tracking-wide pb-1 break-words">{{ $rutina->nombre }}</h1>
                        <p class="text-xs text-neutral-500">
                            Creada {{ $rutina->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('rutinas.edit', $rutina) }}"
                       class="flex-1 sm:flex-initial text-sm bg-white border border-neutral-200 hover:bg-neutral-50 text-[#0f172a] font-medium px-4 py-2 rounded-lg transition flex items-center justify-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" class="form-eliminar flex-1 sm:flex-initial" data-nombre="{{ $rutina->nombre }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="abrirModalEliminar(this)"
                                class="w-full text-sm bg-red-50 hover:bg-red-100 text-red-600 font-medium px-4 py-2 rounded-lg transition flex items-center justify-center gap-1.5">
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
        <div class="p-6 sm:p-8">

            @if ($rutina->descripcion)
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Descripción</h2>
                    <p class="text-neutral-700">{{ $rutina->descripcion }}</p>
                </div>
            @else
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Descripción</h2>
                    <p class="text-sm text-neutral-400 italic">Sin descripción</p>
                </div>
            @endif

            {{-- Acciones rápidas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-6 border-t border-neutral-100">
                <a href="{{ route('entrenamientos.create') }}"
                   class="flex items-center gap-3 p-4 bg-[#0f172a] hover:bg-[#1e293b] text-white rounded-xl transition">
                    <div class="w-10 h-10 rounded-lg bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-sm">Registrar entrenamiento</div>
                        <div class="text-xs text-neutral-300">Con esta rutina</div>
                    </div>
                </a>

                <a href="{{ route('rutinas.duplicar', $rutina) }}"
                   onclick="event.preventDefault(); document.getElementById('form-duplicar').submit();"
                   class="flex items-center gap-3 p-4 bg-white border border-neutral-200 hover:border-[#ffd600] hover:shadow-md text-[#0f172a] rounded-xl transition">
                    <div class="w-10 h-10 rounded-lg bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-sm">Duplicar rutina</div>
                        <div class="text-xs text-neutral-500">Crear una copia</div>
                    </div>
                </a>
            </div>

            {{-- Form oculto para duplicar --}}
            <form id="form-duplicar" action="{{ route('rutinas.duplicar', $rutina) }}" method="POST" class="hidden">
                @csrf
            </form>

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
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">ELIMINAR RUTINA</h3>
                <p class="text-sm text-neutral-600 mt-1">Esta acción no se puede deshacer.</p>
            </div>
        </div>

        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700">
                ¿Estás segura de que quieres eliminar la rutina <strong id="modal-nombre-rutina" class="text-[#0f172a]"></strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">
                Los entrenamientos pasados que la usaron <strong>no se eliminarán</strong>.
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
        document.getElementById('modal-nombre-rutina').textContent = `"${form.dataset.nombre}"`;
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