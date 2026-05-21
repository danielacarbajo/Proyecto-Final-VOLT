@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">

    {{-- Cabecera con título y botón --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a]">Mis rutinas</h1>
            <p class="text-sm text-neutral-500 mt-1">Organiza tus entrenamientos por rutinas reutilizables.</p>
        </div>
        <a href="{{ route('rutinas.create') }}"
           class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
            + Nueva rutina
        </a>
    </div>

    {{-- Listado --}}
    @if ($rutinas->isEmpty())
        <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center">
            <div class="text-6xl mb-4">🏋️</div>
            <h2 class="text-xl font-semibold text-[#0f172a] mb-2">Aún no tienes rutinas</h2>
            <p class="text-neutral-500 mb-6">Crea tu primera rutina para empezar a organizar tus entrenamientos.</p>
            <a href="{{ route('rutinas.create') }}"
               class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition">
                Crear primera rutina
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($rutinas as $rutina)
                <div class="bg-white border border-neutral-200 rounded-xl p-5 hover:shadow-md transition group">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-lg font-semibold text-[#0f172a] group-hover:text-[#eab308] transition">
                            {{ $rutina->nombre }}
                        </h3>
                    </div>

                    @if ($rutina->descripcion)
                        <p class="text-sm text-neutral-600 mb-4 line-clamp-2">{{ $rutina->descripcion }}</p>
                    @else
                        <p class="text-sm text-neutral-400 italic mb-4">Sin descripción</p>
                    @endif

                    <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
                        <span class="text-xs text-neutral-400">
                            Creada {{ $rutina->created_at->diffForHumans() }}
                        </span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('rutinas.show', $rutina) }}"
                               class="text-xs text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                Ver
                            </a>
                            <span class="text-neutral-300">·</span>
                            <a href="{{ route('rutinas.edit', $rutina) }}"
                               class="text-xs text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                Editar
                            </a>
                            <span class="text-neutral-300">·</span>
                            <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar la rutina &quot;{{ $rutina->nombre }}&quot;?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
