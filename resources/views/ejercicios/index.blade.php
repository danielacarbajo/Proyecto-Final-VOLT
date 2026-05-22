@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">

    {{-- Cabecera --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a]">Mis ejercicios</h1>
            <p class="text-sm text-neutral-500 mt-1">Gestiona tu catálogo personal de ejercicios y consulta tus mejores marcas.</p>
        </div>
        <a href="{{ route('ejercicios.create') }}"
           class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md whitespace-nowrap">
            + Nuevo ejercicio
        </a>
    </div>

    {{-- Listado --}}
    @if ($ejercicios->isEmpty())
        <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center">
            <div class="text-6xl mb-4">💪</div>
            <h2 class="text-xl font-semibold text-[#0f172a] mb-2">Aún no tienes ejercicios</h2>
            <p class="text-neutral-500 mb-6">Crea tu primer ejercicio para empezar a registrar entrenamientos.</p>
            <a href="{{ route('ejercicios.create') }}"
               class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition">
                Crear primer ejercicio
            </a>
        </div>
    @else
        {{-- Grid de tarjetas con foto --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($ejercicios as $ejercicio)
                <div class="bg-white border border-neutral-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">

                    {{-- Imagen del grupo muscular --}}
                    <div class="relative h-40 bg-neutral-100">
                        <img src="{{ \App\Helpers\EjercicioHelper::imagen($ejercicio->grupo_muscular) }}"
                             alt="{{ $ejercicio->grupo_muscular ?? 'Ejercicio' }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @if ($ejercicio->grupo_muscular)
                            <div class="absolute top-3 right-3">
                                <span class="inline-block bg-white/90 backdrop-blur text-[#0f172a] text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">
                                    {{ $ejercicio->grupo_muscular }}
                                </span>
                            </div>
                        @endif
                        <div class="absolute bottom-3 left-4 right-4">
                            <h3 class="text-white font-bold text-lg drop-shadow">{{ $ejercicio->nombre }}</h3>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="p-5">

                        {{-- Mejor marca --}}
                        @if ($ejercicio->pr)
                            <div class="mb-4">
                                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">
                                    Mejor marca 🏆
                                </div>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-bold text-[#0f172a]">
                                        {{ rtrim(rtrim(number_format($ejercicio->pr->peso, 2, ',', ''), '0'), ',') }} kg
                                    </span>
                                    <span class="text-sm text-neutral-500">
                                        × {{ $ejercicio->pr->repeticiones }} reps
                                    </span>
                                </div>
                                <div class="text-xs text-neutral-400 mt-1">
                                    {{ $ejercicio->pr->entrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                                </div>
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">
                                    Mejor marca 🏆
                                </div>
                                <div class="text-sm text-neutral-400 italic">Sin registros aún</div>
                            </div>
                        @endif

                        {{-- Acciones --}}
                        <div class="flex items-center gap-2 pt-3 border-t border-neutral-100">
                            <a href="{{ route('ejercicios.progreso', $ejercicio) }}"
                               class="flex-1 text-center text-sm bg-[#0f172a] hover:bg-[#1e293b] text-white font-medium px-3 py-2 rounded-lg transition">
                                📊 Progreso
                            </a>
                            <a href="{{ route('ejercicios.edit', $ejercicio) }}"
                               class="text-sm bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium px-3 py-2 rounded-lg transition">
                                Editar
                            </a>
                            <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar el ejercicio &quot;{{ $ejercicio->nombre }}&quot;?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-sm bg-red-50 hover:bg-red-100 text-red-700 font-medium px-3 py-2 rounded-lg transition">
                                    🗑️
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
