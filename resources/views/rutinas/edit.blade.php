@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('rutinas.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver a Mis rutinas
        </a>
        <h1 class="text-3xl font-bold text-[#0f172a] mt-2">Editar rutina</h1>
        <p class="text-sm text-neutral-500 mt-1">Modifica los datos de tu rutina.</p>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('rutinas.update', $rutina) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-sm font-medium text-neutral-700 mb-1">
                    Nombre de la rutina <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre"
                    type="text"
                    name="nombre"
                    value="{{ old('nombre', $rutina->nombre) }}"
                    required
                    autofocus
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-neutral-700 mb-1">
                    Descripción <span class="text-neutral-400 text-xs">(opcional)</span>
                </label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none resize-none"
                >{{ old('descripcion', $rutina->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit"
                        class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
                    Guardar cambios
                </button>
                <a href="{{ route('rutinas.index') }}"
                   class="text-neutral-600 hover:text-[#0f172a] px-4 py-2.5 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
