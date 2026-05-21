@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('entrenamientos.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver al historial
        </a>
        <h1 class="text-3xl font-bold text-[#0f172a] mt-2">Nuevo entrenamiento</h1>
        <p class="text-sm text-neutral-500 mt-1">Registra los ejercicios que has hecho hoy.</p>
    </div>

    @if ($ejercicios->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-6">
            <p class="text-sm text-yellow-800">
                ⚠️ <strong>No tienes ejercicios creados.</strong>
                Antes de registrar un entrenamiento debes
                <a href="{{ route('ejercicios.create') }}" class="underline font-semibold">crear al menos un ejercicio</a>.
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('entrenamientos.store') }}" id="formEntrenamiento">
        @csrf

        {{-- Datos generales --}}
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label for="fecha_entrenamiento" class="block text-sm font-medium text-neutral-700 mb-1">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="fecha_entrenamiento"
                        type="date"
                        name="fecha_entrenamiento"
                        value="{{ old('fecha_entrenamiento', date('Y-m-d')) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    >
                    @error('fecha_entrenamiento')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rutina_id" class="block text-sm font-medium text-neutral-700 mb-1">
                        Rutina <span class="text-neutral-400 text-xs">(opcional)</span>
                    </label>
                    <select
                        id="rutina_id"
                        name="rutina_id"
                        class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none bg-white"
                    >
                        <option value="">Sin rutina</option>
                        @foreach ($rutinas as $rutina)
                            <option value="{{ $rutina->id }}" {{ old('rutina_id') == $rutina->id ? 'selected' : '' }}>
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

        {{-- Ejercicios del entrenamiento --}}
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-[#0f172a]">Ejercicios realizados</h2>
                <button type="button" onclick="anadirEjercicio()"
                        class="bg-[#0f172a] hover:bg-[#1e293b] text-white text-sm font-medium px-4 py-2 rounded-lg transition"
                        @if ($ejercicios->isEmpty()) disabled @endif>
                    + Añadir ejercicio
                </button>
            </div>

            @error('ejercicios')
                <p class="text-sm text-red-600 mb-3">{{ $message }}</p>
            @enderror

            <div id="listaEjercicios" class="space-y-3">
                {{-- Aquí se irán añadiendo las filas dinámicamente --}}
            </div>

            <p id="mensajeVacio" class="text-sm text-neutral-400 text-center py-6 italic">
                Aún no has añadido ningún ejercicio. Pulsa "+ Añadir ejercicio" para empezar.
            </p>
        </div>

        {{-- Botones --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
                Guardar entrenamiento
            </button>
            <a href="{{ route('entrenamientos.index') }}"
               class="text-neutral-600 hover:text-[#0f172a] px-4 py-2.5 transition">
                Cancelar
            </a>
        </div>

    </form>

</div>

{{-- Plantilla oculta para nuevas filas de ejercicio --}}
<template id="plantillaEjercicio">
    <div class="grid grid-cols-12 gap-3 items-end p-4 bg-neutral-50 rounded-lg border border-neutral-200 fila-ejercicio">
        <div class="col-span-12 md:col-span-5">
            <label class="block text-xs font-medium text-neutral-600 mb-1">Ejercicio</label>
            <select name="ejercicios[INDEX][ejercicio_id]" required
                    class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none bg-white">
                <option value="">— Selecciona —</option>
                @foreach ($ejercicios as $ej)
                    <option value="{{ $ej->id }}">{{ $ej->nombre }}@if($ej->grupo_muscular) ({{ $ej->grupo_muscular }})@endif</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 md:col-span-2">
            <label class="block text-xs font-medium text-neutral-600 mb-1">Series</label>
            <input type="number" name="ejercicios[INDEX][series]" min="1" max="99" value="3" required
                   class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none">
        </div>
        <div class="col-span-4 md:col-span-2">
            <label class="block text-xs font-medium text-neutral-600 mb-1">Reps</label>
            <input type="number" name="ejercicios[INDEX][repeticiones]" min="1" max="999" value="10" required
                   class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none">
        </div>
        <div class="col-span-3 md:col-span-2">
            <label class="block text-xs font-medium text-neutral-600 mb-1">Peso (kg)</label>
            <input type="number" name="ejercicios[INDEX][peso]" step="0.01" min="0" max="9999.99" value="0" required
                   class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none">
        </div>
        <div class="col-span-1 md:col-span-1 flex justify-end">
            <button type="button" onclick="eliminarEjercicio(this)"
                    class="text-red-600 hover:text-red-800 transition p-2"
                    title="Eliminar ejercicio">
                ✕
            </button>
        </div>
    </div>
</template>

<script>
    let contadorEjercicios = 0;

    function anadirEjercicio() {
        const plantilla = document.getElementById('plantillaEjercicio');
        const lista = document.getElementById('listaEjercicios');
        const mensajeVacio = document.getElementById('mensajeVacio');

        // Clonar la plantilla y reemplazar INDEX por el contador actual.
        const html = plantilla.innerHTML.replace(/INDEX/g, contadorEjercicios);
        const div = document.createElement('div');
        div.innerHTML = html;
        lista.appendChild(div.firstElementChild);

        contadorEjercicios++;
        mensajeVacio.style.display = 'none';
    }

    function eliminarEjercicio(boton) {
        boton.closest('.fila-ejercicio').remove();

        const lista = document.getElementById('listaEjercicios');
        const mensajeVacio = document.getElementById('mensajeVacio');

        if (lista.children.length === 0) {
            mensajeVacio.style.display = 'block';
        }
    }

    // Añadir automáticamente una fila al cargar la página (para que sea más cómodo).
    document.addEventListener('DOMContentLoaded', function() {
        @if (!$ejercicios->isEmpty())
            anadirEjercicio();
        @endif
    });
</script>
@endsection
