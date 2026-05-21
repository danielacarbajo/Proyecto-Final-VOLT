@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

    {{-- Cabecera --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a]">Mis ejercicios</h1>
            <p class="text-sm text-neutral-500 mt-1">Gestiona tu catálogo personal de ejercicios.</p>
        </div>
        <a href="{{ route('ejercicios.create') }}"
           class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
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
        <div class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">
                            Ejercicio
                        </th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">
                            Grupo muscular
                        </th>
                        <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach ($ejercicios as $ejercicio)
                        <tr class="hover:bg-neutral-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-[#0f172a]">{{ $ejercicio->nombre }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($ejercicio->grupo_muscular)
                                    <span class="inline-block bg-neutral-100 text-neutral-700 text-xs px-2.5 py-1 rounded-full">
                                        {{ $ejercicio->grupo_muscular }}
                                    </span>
                                @else
                                    <span class="text-neutral-400 text-sm italic">Sin grupo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('ejercicios.edit', $ejercicio) }}"
                                       class="text-sm text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                        Editar
                                    </a>
                                    <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar el ejercicio &quot;{{ $ejercicio->nombre }}&quot;?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
