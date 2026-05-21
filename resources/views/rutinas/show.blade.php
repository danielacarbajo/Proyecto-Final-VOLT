@extends('layouts.app')

@section('contenido')
<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('rutinas.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver a Mis rutinas
        </a>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">

        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#0f172a]">{{ $rutina->nombre }}</h1>
                <p class="text-xs text-neutral-400 mt-1">
                    Creada {{ $rutina->created_at->diffForHumans() }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('rutinas.edit', $rutina) }}"
                   class="text-sm bg-neutral-100 hover:bg-neutral-200 text-[#0f172a] px-4 py-2 rounded-lg transition">
                    Editar
                </a>
                <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" class="inline"
                      onsubmit="return confirm('¿Seguro que quieres eliminar esta rutina?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg transition">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        @if ($rutina->descripcion)
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-neutral-700 uppercase tracking-wide mb-2">Descripción</h2>
                <p class="text-neutral-700">{{ $rutina->descripcion }}</p>
            </div>
        @endif

        <div class="border-t border-neutral-200 pt-6">
            <p class="text-sm text-neutral-500 text-center">
                💡 Pronto podrás añadir ejercicios y registrar entrenamientos para esta rutina.
            </p>
        </div>

    </div>

</div>
@endsection
