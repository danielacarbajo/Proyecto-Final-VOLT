@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('entrenamientos.show', $entrenamiento) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al detalle
        </a>
    </div>

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">EDITAR ENTRENAMIENTO</h1>
        <p class="text-sm text-neutral-500 mt-1">Modifica los datos de tu sesión.</p>
    </div>

    @if ($ejercicios->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-6 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-sm text-yellow-800">
                <strong>No tienes ejercicios creados.</strong>
                Antes de editar este entrenamiento debes
                <a href="{{ route('ejercicios.create') }}" class="underline font-semibold">crear al menos un ejercicio</a>.
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('entrenamientos.update', $entrenamiento) }}" id="formEntrenamiento">
        @csrf
        @method('PUT')

        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label for="fecha_entrenamiento" class="block text-sm font-semibold text-neutral-700 mb-2">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="fecha_entrenamiento"
                        type="date"
                        name="fecha_entrenamiento"
                        value="{{ old('fecha_entrenamiento', $entrenamiento->fecha_entrenamiento->format('Y-m-d')) }}"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                    >
                    @error('fecha_entrenamiento')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rutina_id" class="block text-sm font-semibold text-neutral-700 mb-2">
                        Rutina <span class="text-neutral-400 text-xs font-normal">(opcional)</span>
                    </label>
                    <select
                        id="rutina_id"
                        name="rutina_id"
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none bg-white"
                    >
                        <option value="">Sin rutina</option>
                        @foreach ($rutinas as $rutina)
                            <option value="{{ $rutina->id }}" {{ old('rutina_id', $entrenamiento->rutina_id) == $rutina->id ? 'selected' : '' }}>
                                {{ $rutina->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('rutina_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">EJERCICIOS REALIZADOS</h2>
                <button type="button" onclick="anadirEjercicio()"
                        class="bg-white border border-[#0f172a] hover:bg-[#0f172a] hover:text-white text-[#0f172a] text-sm font-semibold px-4 py-2 rounded-lg transition flex items-center gap-2"
                        @if ($ejercicios->isEmpty()) disabled @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir ejercicio
                </button>
            </div>

            @error('ejercicios')
                <p class="text-sm text-red-600 mb-3">{{ $message }}</p>
            @enderror

            <div id="listaEjercicios" class="space-y-3"></div>

            <p id="mensajeVacio" class="text-sm text-neutral-400 text-center py-6 italic hidden">
                Has eliminado todos los ejercicios. Añade al menos uno para guardar.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-6 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar cambios
            </button>
            <a href="{{ route('entrenamientos.show', $entrenamiento) }}"
               class="text-sm text-neutral-500 hover:text-[#0f172a] px-3 py-2 transition">
                Cancelar
            </a>
        </div>

    </form>

</div>

<template id="plantillaEjercicio">
    <div class="bg-neutral-50 rounded-lg border border-neutral-200 p-4 fila-ejercicio">
        {{-- Ejercicio (ancho completo) --}}
        <div class="mb-3">
            <label class="block text-xs font-semibold text-neutral-600 mb-1">Ejercicio</label>
            <select name="ejercicios[INDEX][ejercicio_id]" required
                    class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none bg-white">
                <option value="">— Selecciona —</option>
                @foreach ($ejercicios as $ej)
                    <option value="{{ $ej->id }}" data-id="{{ $ej->id }}">{{ $ej->nombre }}@if($ej->grupo_muscular) ({{ $ej->grupo_muscular }})@endif</option>
                @endforeach
            </select>
        </div>

        {{-- Series / Reps / Peso / Papelera --}}
        <div class="grid grid-cols-[1fr_1fr_1fr_auto] gap-2 items-end">
            <div>
                <label class="block text-xs font-semibold text-neutral-600 mb-1">Series</label>
                <input type="number" name="ejercicios[INDEX][series]" min="1" max="99" value="3" required
                       class="w-full px-2 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-neutral-600 mb-1">Reps</label>
                <input type="number" name="ejercicios[INDEX][repeticiones]" min="1" max="999" value="10" required
                       class="w-full px-2 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-neutral-600 mb-1">Peso (kg)</label>
                <input type="number" name="ejercicios[INDEX][peso]" step="0.01" min="0" max="9999.99" value="0" required
                       class="w-full px-2 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-transparent mb-1 select-none">.</label>
                <button type="button" onclick="eliminarEjercicio(this)"
                        class="w-10 h-10 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition"
                        title="Eliminar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    let contadorEjercicios = 0;

    function anadirEjercicio(datosPrecarga = null) {
        const plantilla = document.getElementById('plantillaEjercicio');
        const lista = document.getElementById('listaEjercicios');
        const mensajeVacio = document.getElementById('mensajeVacio');

        const html = plantilla.innerHTML.replace(/INDEX/g, contadorEjercicios);
        const div = document.createElement('div');
        div.innerHTML = html;
        const nuevaFila = div.firstElementChild;
        lista.appendChild(nuevaFila);

        if (datosPrecarga) {
            nuevaFila.querySelector('select[name*="[ejercicio_id]"]').value = datosPrecarga.ejercicio_id;
            nuevaFila.querySelector('input[name*="[series]"]').value = datosPrecarga.series;
            nuevaFila.querySelector('input[name*="[repeticiones]"]').value = datosPrecarga.repeticiones;
            nuevaFila.querySelector('input[name*="[peso]"]').value = datosPrecarga.peso;
        }

        contadorEjercicios++;
        mensajeVacio.classList.add('hidden');
    }

    function eliminarEjercicio(boton) {
        boton.closest('.fila-ejercicio').remove();
        const lista = document.getElementById('listaEjercicios');
        const mensajeVacio = document.getElementById('mensajeVacio');
        if (lista.children.length === 0) mensajeVacio.classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($entrenamiento->detalles as $detalle)
            anadirEjercicio({
                ejercicio_id: {{ $detalle->ejercicio_id }},
                series: {{ $detalle->series }},
                repeticiones: {{ $detalle->repeticiones }},
                peso: {{ $detalle->peso }}
            });
        @endforeach
    });
</script>
@endsection