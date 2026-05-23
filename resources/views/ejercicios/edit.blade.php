@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('ejercicios.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Mis ejercicios
        </a>
    </div>

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">EDITAR EJERCICIO</h1>
        <p class="text-sm text-neutral-500 mt-1">Cambia el ejercicio seleccionado del catálogo.</p>
    </div>

    {{-- Ejercicio actual --}}
    <div class="bg-gradient-to-br from-[#ffd600]/10 to-[#ffd600]/5 border border-[#ffd600]/30 rounded-2xl p-5 mb-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-[#ffd600] flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <div class="flex-1">
            <div class="text-xs font-semibold text-[#854d0e] uppercase tracking-wider mb-0.5">Ejercicio actual</div>
            <div class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-0.5">{{ $ejercicio->nombre }}</div>
            @if ($ejercicio->grupo_muscular)
                <span class="inline-block bg-[#ffd600] text-[#0f172a] text-xs font-bold px-2 py-0.5 rounded-full uppercase tracking-wider mt-1">
                    {{ $ejercicio->grupo_muscular }}
                </span>
            @endif
        </div>
    </div>

    {{-- Formulario --}}
    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('ejercicios.update', $ejercicio) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-sm font-semibold text-neutral-700 mb-2">
                    Ejercicio <span class="text-red-500">*</span>
                </label>
                <select
                    id="nombre"
                    name="nombre"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none bg-white"
                >
                    <option value="">— Selecciona un ejercicio —</option>
                    @foreach ($ejerciciosAgrupados as $grupo => $ejercicios)
                        <optgroup label="{{ $grupo }}">
                            @foreach ($ejercicios as $ej)
                                <option value="{{ $ej }}" {{ old('nombre', $ejercicio->nombre) === $ej ? 'selected' : '' }}>
                                    {{ $ej }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-neutral-500 mt-2 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    El grupo muscular y la imagen se actualizarán automáticamente al cambiar el ejercicio.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-neutral-100">
                <button type="submit"
                        class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-6 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar cambios
                </button>
                <a href="{{ route('ejercicios.index') }}"
                   class="text-sm text-neutral-500 hover:text-[#0f172a] px-3 py-2 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection