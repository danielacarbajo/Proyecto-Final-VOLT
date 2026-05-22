@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('ejercicios.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver a Mis ejercicios
        </a>
        <h1 class="text-3xl font-bold text-[#0f172a] mt-2">Nuevo ejercicio</h1>
        <p class="text-sm text-neutral-500 mt-1">Selecciona un ejercicio del catálogo para añadirlo a tu lista personal.</p>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('ejercicios.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-neutral-700 mb-1">
                    Ejercicio <span class="text-red-500">*</span>
                </label>
                <select
                    id="nombre"
                    name="nombre"
                    required
                    autofocus
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none bg-white"
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
                <p class="text-xs text-neutral-500 mt-2">
                    El grupo muscular y la imagen se asignarán automáticamente según el ejercicio seleccionado.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit"
                        class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
                    Añadir ejercicio
                </button>
                <a href="{{ route('ejercicios.index') }}"
                   class="text-neutral-600 hover:text-[#0f172a] px-4 py-2.5 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
