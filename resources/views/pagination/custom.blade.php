@if ($paginator->hasPages())
    <nav class="pagination">
        {{-- Botón "Anterior" --}}
        @if ($paginator->onFirstPage())
            <span class="disabled">&laquo; Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Anterior</a>
        @endif

        {{-- Enlaces de Páginas --}}
        @foreach ($elements as $element)
            {{-- Tres puntos --}}
            @if (is_string($element))
                <span class="dots">{{ $element }}</span>
            @endif

            {{-- Enlaces de páginas --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botón "Siguiente" --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente &raquo;</a>
        @else
            <span class="disabled">Siguiente &raquo;</span>
        @endif
    </nav>
@endif