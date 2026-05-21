@extends('layouts.app')

@section('contenido')
<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('entrenamientos.index') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver al historial
        </a>
    </div>

    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8 mb-6">

        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#0f172a]">
                    Entrenamiento del {{ $entrenamiento->fecha_entrenamiento->format('d/m/Y') }}
                </h1>
                <p class="text-sm text-neutral-500 mt-1 capitalize">
                    {{ $entrenamiento->fecha_entrenamiento->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
                @if ($entrenamiento->rutina)
                    <span class="inline-block mt-3 bg-[#facc15]/20 text-[#854d0e] text-xs px-3 py-1 rounded-full font-medium">
                        Rutina: {{ $entrenamiento->rutina->nombre }}
                    </span>
                @else
                    <span class="inline-block mt-3 text-xs text-neutral-400 italic">Sin rutina asociada</span>
                @endif
            </div>

<div class="flex items-center gap-2">
    <a href="{{ route('entrenamientos.edit', $entrenamiento) }}"
       class="text-sm bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-4 py-2 rounded-lg transition">
        Editar
    </a>

    <form action="{{ route('entrenamientos.destroy', $entrenamiento) }}" method="POST" class="inline"
          onsubmit="return confirm('¿Seguro que quieres eliminar este entrenamiento?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg transition">
            Eliminar
        </button>
    </form>
</div>

        {{-- Detalles --}}
        <h2 class="text-sm font-semibold text-neutral-700 uppercase tracking-wide mb-4">
            Ejercicios realizados ({{ $entrenamiento->detalles->count() }})
        </h2>

        <div class="overflow-hidden rounded-lg border border-neutral-200">
            <table class="w-full">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Ejercicio</th>
                        <th class="text-center text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Series</th>
                        <th class="text-center text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Reps</th>
                        <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-4 py-3">Peso</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach ($entrenamiento->detalles as $detalle)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="font-medium text-[#0f172a]">{{ $detalle->ejercicio->nombre }}</span>
                                @if ($detalle->ejercicio->grupo_muscular)
                                    <div class="text-xs text-neutral-400 mt-0.5">{{ $detalle->ejercicio->grupo_muscular }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-neutral-700">{{ $detalle->series }}</td>
                            <td class="px-4 py-3 text-center text-neutral-700">{{ $detalle->repeticiones }}</td>
                            <td class="px-4 py-3 text-right">
                                <span class="font-semibold text-[#0f172a]">{{ rtrim(rtrim(number_format($detalle->peso, 2), '0'), '.') }}</span>
                                <span class="text-xs text-neutral-500 ml-1">kg</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
