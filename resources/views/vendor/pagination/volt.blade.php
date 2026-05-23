@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-2">

        {{-- Botón "Anterior" --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-400 bg-neutral-100 border border-neutral-200 rounded-lg cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="hidden sm:inline">Anterior</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-[#0f172a] bg-white border border-neutral-200 rounded-lg hover:bg-[#ffd600]/10 hover:border-[#ffd600] transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="hidden sm:inline">Anterior</span>
            </a>
        @endif

        {{-- Indicador de página actual --}}
        <div class="flex items-center gap-1 text-sm">
            <span class="font-bebas text-2xl text-[#0f172a] leading-none tracking-wide">
                {{ $paginator->currentPage() }}
            </span>
            <span class="text-neutral-400 mx-1">/</span>
            <span class="text-neutral-500 font-semibold">
                {{ $paginator->lastPage() }}
            </span>
        </div>

        {{-- Botón "Siguiente" --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-[#0f172a] bg-white border border-neutral-200 rounded-lg hover:bg-[#ffd600]/10 hover:border-[#ffd600] transition shadow-sm">
                <span class="hidden sm:inline">Siguiente</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-400 bg-neutral-100 border border-neutral-200 rounded-lg cursor-not-allowed">
                <span class="hidden sm:inline">Siguiente</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        @endif

    </nav>
@endif