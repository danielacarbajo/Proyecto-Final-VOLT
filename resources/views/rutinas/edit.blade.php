@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">

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

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">EDITAR RUTINA</h1>
        <p class="text-sm text-neutral-500 mt-1">Modifica el nombre o la descripción de tu rutina.</p>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('rutinas.update', $rutina) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-sm font-semibold text-neutral-700 mb-2">
                    Nombre de la rutina <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre"
                    type="text"
                    name="nombre"
                    value="{{ old('nombre', $rutina->nombre) }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                >
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-semibold text-neutral-700 mb-2">
                    Descripción <span class="text-neutral-400 text-xs font-normal">(opcional)</span>
                </label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none resize-none"
                >{{ old('descripcion', $rutina->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-neutral-100">
                <button type="submit"
                        class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-6 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar cambios
                </button>
                <a href="{{ route('rutinas.index') }}"
                   class="text-sm text-neutral-500 hover:text-[#0f172a] px-3 py-2 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection