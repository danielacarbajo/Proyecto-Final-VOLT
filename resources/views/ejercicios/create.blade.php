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
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide">AÑADIR EJERCICIO</h1>
        <p class="text-sm text-neutral-500 mt-1">Selecciona un ejercicio del catálogo para guardarlo en tu lista personal.</p>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('ejercicios.store') }}" class="space-y-5">
            @csrf

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
                            @foreach ($ejercicios as $ejercicio)
                                <option value="{{ $ejercicio }}" {{ old('nombre') === $ejercicio ? 'selected' : '' }}>
                                    {{ $ejercicio }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-neutral-500 mt-2 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    El grupo muscular y la imagen se asignarán automáticamente.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-neutral-100">
                <button type="submit"
                        class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-6 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir ejercicio
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
