@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">

{{-- Cabecera --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">MIS RUTINAS</h1>
                <p class="text-sm text-neutral-500 mt-1">Crea, organiza y reutiliza tus rutinas de entrenamiento.</p>
            </div>
            <a href="{{ route('rutinas.create') }}"
               class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-5 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center justify-center gap-2 sm:whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva rutina
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

    @if ($rutinas->isEmpty())

        {{-- ============================ --}}
        {{-- ESTADO VACÍO --}}
        {{-- ============================ --}}
        <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white rounded-2xl p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-[#ffd600] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h2 class="font-bebas text-3xl mb-2 tracking-wide">TODAVÍA NO TIENES RUTINAS</h2>
            <p class="text-neutral-300 mb-6 max-w-md mx-auto">
                Crea tu primera rutina para empezar a organizar tus entrenamientos por grupo muscular o día de la semana.
            </p>
            <a href="{{ route('rutinas.create') }}"
               class="inline-block bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-semibold px-6 py-3 rounded-lg transition">
                + Crear primera rutina
            </a>
        </div>

    @else

        {{-- ============================ --}}
        {{-- MINI RESUMEN (3 tarjetas) --}}
        {{-- ============================ --}}
        @php
            $totalRutinas = $rutinas->count();
            $ultimaRutina = $rutinas->first();
            $totalEjerciciosUsados = $rutinas->sum('detalles_count');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

            {{-- Total rutinas --}}
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">
                        Rutinas creadas
                    </div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight mt-2 pb-1">{{ $totalRutinas }}</div>
            </div>

            {{-- Última rutina --}}
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">
                        Última creada
                    </div>
                </div>
                <div class="font-bebas text-2xl text-[#0f172a] leading-tight mt-2 truncate pb-1">
                    {{ $ultimaRutina->nombre }}
                </div>
                <div class="text-xs text-neutral-400 mt-1">
                    {{ $ultimaRutina->created_at->diffForHumans() }}
                </div>
            </div>

            {{-- Total ejercicios usados --}}
            <div class="bg-[#ffd600] border border-[#eab308] rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#0f172a] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#ffd600]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-[#854d0e] uppercase tracking-wider">
                        Total ejercicios
                    </div>
                </div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight mt-2 pb-1">{{ $totalEjerciciosUsados }}</div>
                <div class="text-xs text-[#854d0e] mt-1">en tus rutinas</div>
            </div>

        </div>

        {{-- ============================ --}}
        {{-- BARRA DE FILTROS --}}
        {{-- ============================ --}}
        <div class="bg-white border border-neutral-200 rounded-2xl p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-3">

            {{-- Buscador --}}
            <div class="flex-1 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       id="buscador-rutinas"
                       placeholder="Buscar rutina por nombre o descripción..."
                       class="w-full pl-10 pr-4 py-2.5 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition text-sm">
            </div>

            {{-- Filtro --}}
            <select id="filtro-rutinas"
                    class="px-4 py-2.5 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition text-sm cursor-pointer">
                <option value="todas">Todas las rutinas</option>
                <option value="con-ejercicios">Con ejercicios</option>
                <option value="sin-ejercicios">Sin ejercicios</option>
                <option value="usadas">Más usadas</option>
                <option value="recientes">Más recientes</option>
            </select>
        </div>

        {{-- Contador de resultados --}}
        <div id="contador-resultados" class="text-sm text-neutral-500 mb-4">
            Mostrando {{ $rutinas->count() }} {{ $rutinas->count() === 1 ? 'rutina' : 'rutinas' }}
        </div>

        {{-- ============================ --}}
        {{-- GRID DE RUTINAS --}}
        {{-- ============================ --}}
        <div id="grid-rutinas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($rutinas as $rutina)
                <div class="rutina-card bg-white border border-neutral-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-[#ffd600] transition group"
                     data-nombre="{{ strtolower($rutina->nombre) }}"
                     data-descripcion="{{ strtolower($rutina->descripcion ?? '') }}"
                     data-ejercicios="{{ $rutina->detalles_count }}"
                     data-usada="{{ $rutina->entrenamientos_count }}"
                     data-creada="{{ $rutina->created_at->timestamp }}">

                    {{-- Cabecera con icono --}}
                    <div class="bg-gradient-to-br from-[#ffd600]/20 to-[#ffd600]/5 p-6 flex items-center justify-center border-b border-neutral-100">
                        <div class="w-16 h-16 rounded-2xl bg-[#ffd600] flex items-center justify-center group-hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="p-5">

                        {{-- Nombre --}}
                        <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide mb-2 pb-1 group-hover:text-[#854d0e] transition">
                            {{ $rutina->nombre }}
                        </h3>

                        {{-- Descripción --}}
                        @if ($rutina->descripcion)
                            <p class="text-sm text-neutral-600 mb-4 line-clamp-2 min-h-[40px]">
                                {{ $rutina->descripcion }}
                            </p>
                        @else
                            <p class="text-sm text-neutral-400 italic mb-4 min-h-[40px]">
                                Sin descripción
                            </p>
                        @endif

                        {{-- Mini-stats --}}
                        <div class="grid grid-cols-3 gap-2 mb-4 pb-4 border-b border-neutral-100">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-[#854d0e]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <span class="font-bebas text-xl">{{ $rutina->detalles_count }}</span>
                                </div>
                                <div class="text-[10px] uppercase tracking-wider text-neutral-500 mt-0.5">
                                    {{ $rutina->detalles_count === 1 ? 'Ejercicio' : 'Ejercicios' }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-[#854d0e]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-bebas text-xl">{{ $rutina->entrenamientos_count }}</span>
                                </div>
                                <div class="text-[10px] uppercase tracking-wider text-neutral-500 mt-0.5">
                                    {{ $rutina->entrenamientos_count === 1 ? 'Vez usada' : 'Veces usada' }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-[#854d0e]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-bebas text-xs leading-tight">{{ $rutina->created_at->diffForHumans(null, true) }}</span>
                                </div>
                                <div class="text-[10px] uppercase tracking-wider text-neutral-500 mt-0.5">
                                    Creada
                                </div>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex items-center justify-between gap-2">
                            <a href="{{ route('rutinas.show', $rutina) }}"
                               class="flex-1 bg-[#0f172a] hover:bg-[#1e293b] text-white text-sm font-semibold px-4 py-2 rounded-lg transition text-center">
                                Ver rutina
                            </a>

                            {{-- Menú dropdown --}}
                            <div class="relative">
                                <button type="button"
                                        onclick="toggleMenu(this)"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-neutral-200 hover:bg-neutral-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                    </svg>
                                </button>

                                <div class="menu-dropdown hidden absolute right-0 bottom-full mb-2 w-44 bg-white border border-neutral-200 rounded-lg shadow-lg z-10 overflow-hidden">
                                    <a href="{{ route('rutinas.edit', $rutina) }}"
                                       class="flex items-center gap-2 px-4 py-2.5 text-sm text-[#0f172a] hover:bg-neutral-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('rutinas.duplicar', $rutina) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-[#0f172a] hover:bg-neutral-50 transition text-left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            Duplicar
                                        </button>
                                    </form>
                                    <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" class="form-eliminar" data-nombre="{{ $rutina->nombre }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="abrirModalEliminar(this)" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-left border-t border-neutral-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Mensaje cuando no hay resultados del filtro --}}
        <div id="sin-resultados" class="hidden text-center py-12">
            <div class="text-5xl mb-3">🔍</div>
            <h3 class="font-bebas text-2xl text-[#0f172a] mb-2">SIN RESULTADOS</h3>
            <p class="text-neutral-500 text-sm">Prueba a cambiar los filtros o el término de búsqueda.</p>
        </div>

    @endif

</div>

{{-- ============================ --}}
{{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
{{-- ============================ --}}
<div id="modal-eliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModalEliminar()"></div>

    {{-- Contenido del modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        {{-- Cabecera con icono de aviso --}}
        <div class="bg-red-50 px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">ELIMINAR RUTINA</h3>
                <p class="text-sm text-neutral-600 mt-1">Esta acción no se puede deshacer.</p>
            </div>
        </div>

        {{-- Cuerpo --}}
        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700">
                ¿Estás segura de que quieres eliminar la rutina <strong id="modal-nombre-rutina" class="text-[#0f172a]"></strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">
                Los entrenamientos pasados que la usaron <strong>no se eliminarán</strong>.
            </p>
        </div>

        {{-- Botones --}}
        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button"
                    onclick="cerrarModalEliminar()"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button"
                    id="btn-confirmar-eliminar"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                </svg>
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

{{-- ============================ --}}
{{-- SCRIPTS --}}
{{-- ============================ --}}
@if (!$rutinas->isEmpty())
<script>
    // ============================
    // Modal de eliminación
    // ============================
    let formAEliminar = null;

    function abrirModalEliminar(btn) {
        const form = btn.closest('.form-eliminar');
        const nombre = form.dataset.nombre;

        formAEliminar = form;
        document.getElementById('modal-nombre-rutina').textContent = `"${nombre}"`;
        document.getElementById('modal-eliminar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalEliminar() {
        document.getElementById('modal-eliminar').classList.add('hidden');
        document.body.style.overflow = '';
        formAEliminar = null;
    }

    document.getElementById('btn-confirmar-eliminar').addEventListener('click', function () {
        if (formAEliminar) formAEliminar.submit();
    });

    // Cerrar con ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrarModalEliminar();
    });

    // ============================
    // Toggle del menú dropdown
    // ============================
    function toggleMenu(btn) {
        const menu = btn.nextElementSibling;
        document.querySelectorAll('.menu-dropdown').forEach(m => {
            if (m !== menu) m.classList.add('hidden');
        });
        menu.classList.toggle('hidden');
    }

    // Cerrar dropdowns al hacer click fuera
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.menu-dropdown').forEach(m => m.classList.add('hidden'));
        }
    });

    // ============================
    // Buscador + Filtro
    // ============================
    const buscador = document.getElementById('buscador-rutinas');
    const filtro = document.getElementById('filtro-rutinas');
    const grid = document.getElementById('grid-rutinas');
    const cards = Array.from(document.querySelectorAll('.rutina-card'));
    const contador = document.getElementById('contador-resultados');
    const sinResultados = document.getElementById('sin-resultados');

    function actualizarLista() {
        const texto = buscador.value.toLowerCase().trim();
        const tipo = filtro.value;

        let visibles = cards.filter(card => {
            const nombre = card.dataset.nombre;
            const descripcion = card.dataset.descripcion;
            const ejercicios = parseInt(card.dataset.ejercicios);
            const usada = parseInt(card.dataset.usada);

            if (texto && !nombre.includes(texto) && !descripcion.includes(texto)) {
                return false;
            }

            if (tipo === 'con-ejercicios' && ejercicios === 0) return false;
            if (tipo === 'sin-ejercicios' && ejercicios > 0) return false;

            return true;
        });

        if (tipo === 'usadas') {
            visibles.sort((a, b) => parseInt(b.dataset.usada) - parseInt(a.dataset.usada));
        } else if (tipo === 'recientes') {
            visibles.sort((a, b) => parseInt(b.dataset.creada) - parseInt(a.dataset.creada));
        }

        visibles.forEach(card => grid.appendChild(card));

        cards.forEach(card => {
            card.style.display = visibles.includes(card) ? '' : 'none';
        });

        const n = visibles.length;
        if (n === 0) {
            grid.classList.add('hidden');
            sinResultados.classList.remove('hidden');
            contador.textContent = 'No se encontraron rutinas';
        } else {
            grid.classList.remove('hidden');
            sinResultados.classList.add('hidden');
            contador.textContent = `Mostrando ${n} ${n === 1 ? 'rutina' : 'rutinas'}`;
        }
    }

    buscador.addEventListener('input', actualizarLista);
    filtro.addEventListener('change', actualizarLista);
</script>
@endif

@endsection
