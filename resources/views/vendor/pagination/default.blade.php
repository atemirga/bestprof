@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:center;gap:0.35rem;">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="pg-btn pg-disabled">&laquo;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pg-btn">&laquo;</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="pg-btn pg-disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="pg-btn pg-active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pg-btn">&raquo;</a>
    @else
        <span class="pg-btn pg-disabled">&raquo;</span>
    @endif
</nav>

<style>
    .pg-btn {
        display:inline-flex;align-items:center;justify-content:center;
        min-width:38px;height:38px;padding:0 0.5rem;
        border-radius:8px;font-size:0.88rem;font-weight:600;
        text-decoration:none;transition:all 0.15s;
        color:var(--dark,#1a1a2e);background:#fff;
        border:1px solid #e0e4ec;
    }
    .pg-btn:hover { border-color:var(--blue,#193EEA);color:var(--blue,#193EEA); }
    .pg-active { background:var(--blue,#193EEA);color:#fff!important;border-color:var(--blue,#193EEA); }
    .pg-disabled { opacity:0.4;pointer-events:none; }
</style>
@endif
