@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">

    {{-- CABECERA --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide">MIS EJERCICIOS</h1>
                <p class="text-sm text-neutral-500 mt-1">Gestiona tu catálogo personal, consulta tus marcas y revisa tu progreso.</p>
            </div>
            <a href="{{ route('ejercicios.create') }}"
               class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-5 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center justify-center gap-2 sm:whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo ejercicio
            </a>
        </div>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('exito'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('exito') }}
        </div>
    @endif

    @if ($ejercicios->isEmpty())

        {{-- ============================ --}}
        {{-- ESTADO VACÍO --}}
        {{-- ============================ --}}
        <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white rounded-2xl p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-[#ffd600] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h2 class="font-bebas text-3xl mb-2 tracking-wide">TODAVÍA NO TIENES EJERCICIOS</h2>
            <p class="text-neutral-300 mb-6 max-w-md mx-auto">
                Añade tu primer ejercicio desde el catálogo para empezar a registrar entrenamientos.
            </p>
            <a href="{{ route('ejercicios.create') }}"
               class="inline-block bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-semibold px-6 py-3 rounded-lg transition">
                + Añadir primer ejercicio
            </a>
        </div>

    @else

        {{-- ============================ --}}
        {{-- MINI RESUMEN (3 tarjetas) --}}
        {{-- ============================ --}}
        @php
            $totalEjercicios = $ejercicios->count();
            $gruposDistintos = $ejercicios->pluck('grupo_muscular')->filter()->unique()->count();
            $conMarca = $ejercicios->filter(fn($e) => $e->pr)->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">
                        Ejercicios totales
                    </div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight mt-2 pb-1">{{ $totalEjercicios }}</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a1.99 1.99 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">
                        Grupos musculares
                    </div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight mt-2 pb-1">{{ $gruposDistintos }}</div>
                <div class="text-xs text-neutral-400 mt-1">distintos</div>
            </div>

            <div class="bg-[#ffd600] border border-[#eab308] rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#0f172a] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#ffd600]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-[#854d0e] uppercase tracking-wider">
                        Con mejor marca
                    </div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight mt-2 pb-1">{{ $conMarca }}</div>
                <div class="text-xs text-[#854d0e] mt-1">registrada</div>
            </div>

        </div>

        {{-- ============================ --}}
        {{-- BARRA DE FILTROS --}}
        {{-- ============================ --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-3">

            <div class="flex-1 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       id="buscador-ejercicios"
                       placeholder="Buscar ejercicio por nombre..."
                       class="w-full pl-10 pr-4 py-2.5 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition text-sm">
            </div>

            <select id="filtro-grupo"
                    class="px-4 py-2.5 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition text-sm cursor-pointer">
                <option value="todos">Todos los grupos musculares</option>
                @foreach ($ejercicios->pluck('grupo_muscular')->filter()->unique()->sort() as $grupo)
                    <option value="{{ strtolower($grupo) }}">{{ $grupo }}</option>
                @endforeach
            </select>
        </div>

        <div id="contador-resultados" class="text-sm text-neutral-500 mb-4">
            Mostrando {{ $ejercicios->count() }} {{ $ejercicios->count() === 1 ? 'ejercicio' : 'ejercicios' }}
        </div>

        {{-- ============================ --}}
        {{-- GRID DE EJERCICIOS --}}
        {{-- ============================ --}}
        <div id="grid-ejercicios" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($ejercicios as $ejercicio)
                <div class="ejercicio-card bg-white border border-neutral-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:border-[#ffd600] transition group"
                     data-nombre="{{ strtolower($ejercicio->nombre) }}"
                     data-grupo="{{ strtolower($ejercicio->grupo_muscular ?? '') }}">

                    {{-- Imagen + badge --}}
                    <div class="relative h-40 bg-neutral-100">
                        <img src="{{ \App\Helpers\EjercicioHelper::imagen($ejercicio->grupo_muscular) }}"
                             alt="{{ $ejercicio->grupo_muscular ?? 'Ejercicio' }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        @if ($ejercicio->grupo_muscular)
                            <div class="absolute top-3 right-3">
                                <span class="inline-block bg-[#ffd600] text-[#0f172a] text-xs font-bold px-2.5 py-1 rounded-full shadow-sm uppercase tracking-wider">
                                    {{ $ejercicio->grupo_muscular }}
                                </span>
                            </div>
                        @endif
                        <div class="absolute bottom-3 left-4 right-4">
                            <h3 class="font-bebas text-2xl text-white tracking-wide drop-shadow pb-1">{{ $ejercicio->nombre }}</h3>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="p-5">

                        {{-- Mejor marca --}}
                        @if ($ejercicio->pr)
                            <div class="mb-4">
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#ffd600]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Mejor marca
                                </div>
                                <div class="flex items-baseline gap-2">
                                    <span class="font-bebas text-3xl text-[#0f172a] pb-0.5">
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
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-neutral-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Mejor marca
                                </div>
                                <div class="text-sm text-neutral-400 italic">Sin registros todavía</div>
                            </div>
                        @endif

                        {{-- Acciones --}}
                        <div class="flex items-center gap-2 pt-3 border-t border-neutral-100">
                            <a href="{{ route('ejercicios.progreso', $ejercicio) }}"
                               class="flex-1 text-center text-sm bg-[#0f172a] hover:bg-[#1e293b] text-white font-semibold px-3 py-2 rounded-lg transition flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Progreso
                            </a>
                            <a href="{{ route('ejercicios.edit', $ejercicio) }}"
                               class="w-9 h-9 flex items-center justify-center text-sm bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition"
                               title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" class="form-eliminar inline" data-nombre="{{ $ejercicio->nombre }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="abrirModalEliminar(this)"
                                        class="w-9 h-9 flex items-center justify-center text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition"
                                        title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div id="sin-resultados" class="hidden text-center py-12">
            <div class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="font-bebas text-2xl text-[#0f172a] mb-2">SIN RESULTADOS</h3>
            <p class="text-neutral-500 text-sm">Prueba a cambiar los filtros o el término de búsqueda.</p>
        </div>

    @endif

</div>

{{-- ============================ --}}
{{-- MODAL DE CONFIRMACIÓN --}}
{{-- ============================ --}}
<div id="modal-eliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModalEliminar()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-red-50 px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">ELIMINAR EJERCICIO</h3>
                <p class="text-sm text-neutral-600 mt-1">Esta acción no se puede deshacer.</p>
            </div>
        </div>

        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700">
                ¿Estás segura de que quieres eliminar <strong id="modal-nombre-ejercicio" class="text-[#0f172a]"></strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">
                Los entrenamientos pasados con este ejercicio <strong>no se eliminarán</strong>.
            </p>
        </div>

        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModalEliminar()"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" id="btn-confirmar-eliminar"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                </svg>
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

@if (!$ejercicios->isEmpty())
<script>
    // Modal eliminación
    let formAEliminar = null;

    function abrirModalEliminar(btn) {
        const form = btn.closest('.form-eliminar');
        formAEliminar = form;
        document.getElementById('modal-nombre-ejercicio').textContent = `"${form.dataset.nombre}"`;
        document.getElementById('modal-eliminar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalEliminar() {
        document.getElementById('modal-eliminar').classList.add('hidden');
        document.body.style.overflow = '';
        formAEliminar = null;
    }

    document.getElementById('btn-confirmar-eliminar').addEventListener('click', () => {
        if (formAEliminar) formAEliminar.submit();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') cerrarModalEliminar();
    });

    // Buscador + Filtro
    const buscador = document.getElementById('buscador-ejercicios');
    const filtroGrupo = document.getElementById('filtro-grupo');
    const grid = document.getElementById('grid-ejercicios');
    const cards = Array.from(document.querySelectorAll('.ejercicio-card'));
    const contador = document.getElementById('contador-resultados');
    const sinResultados = document.getElementById('sin-resultados');

    function actualizarLista() {
        const texto = buscador.value.toLowerCase().trim();
        const grupo = filtroGrupo.value;

        let visibles = cards.filter(card => {
            if (texto && !card.dataset.nombre.includes(texto)) return false;
            if (grupo !== 'todos' && card.dataset.grupo !== grupo) return false;
            return true;
        });

        cards.forEach(card => {
            card.style.display = visibles.includes(card) ? '' : 'none';
        });

        const n = visibles.length;
        if (n === 0) {
            grid.classList.add('hidden');
            sinResultados.classList.remove('hidden');
            contador.textContent = 'No se encontraron ejercicios';
        } else {
            grid.classList.remove('hidden');
            sinResultados.classList.add('hidden');
            contador.textContent = `Mostrando ${n} ${n === 1 ? 'ejercicio' : 'ejercicios'}`;
        }
    }

    buscador.addEventListener('input', actualizarLista);
    filtroGrupo.addEventListener('change', actualizarLista);
</script>
@endif

@endsection
