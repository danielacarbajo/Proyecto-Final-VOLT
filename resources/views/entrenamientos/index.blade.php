@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a]">Historial de entrenamientos</h1>
            <p class="text-sm text-neutral-500 mt-1">Tus sesiones de entrenamiento ordenadas por fecha.</p>
        </div>
        <a href="{{ route('entrenamientos.create') }}"
           class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
            + Nuevo entrenamiento
        </a>
    </div>

    @if ($entrenamientos->isEmpty())
        <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center">
            <div class="text-6xl mb-4">🏃</div>
            <h2 class="text-xl font-semibold text-[#0f172a] mb-2">Aún no has registrado entrenamientos</h2>
            <p class="text-neutral-500 mb-6">Registra tu primera sesión para empezar tu historial.</p>
            <a href="{{ route('entrenamientos.create') }}"
               class="inline-block bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition">
                Registrar primer entrenamiento
            </a>
        </div>
    @else
        <div class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Fecha</th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Rutina</th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Ejercicios</th>
                        <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach ($entrenamientos as $entrenamiento)
                        <tr class="hover:bg-neutral-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-[#0f172a]">
                                    {{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                                </span>
                                <div class="text-xs text-neutral-400 mt-0.5">
                                    {{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($entrenamiento->rutina)
                                    <span class="inline-block bg-[#facc15]/20 text-[#854d0e] text-xs px-2.5 py-1 rounded-full font-medium">
                                        {{ $entrenamiento->rutina->nombre }}
                                    </span>
                                @else
                                    <span class="text-neutral-400 text-sm italic">Sin rutina</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600">
                                {{ $entrenamiento->detalles()->count() }} {{ $entrenamiento->detalles()->count() === 1 ? 'ejercicio' : 'ejercicios' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('entrenamientos.show', $entrenamiento) }}"
                                       class="text-sm text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                        Ver
                                    </a>
                                    <form action="{{ route('entrenamientos.destroy', $entrenamiento) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar este entrenamiento?');">
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
