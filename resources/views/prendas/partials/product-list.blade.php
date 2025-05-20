<div id="product-list">
    <div class="prendas">
        @forelse ($prendas as $prenda)
            <div class="prenda">
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                    <img
                      src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                      alt="{{ $prenda->descripcion }}"
                    >
                </a>
                <p><strong>{{ $prenda->nombre }}</strong></p>
                <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
                <p><strong>Valoración:</strong> {{ number_format($prenda->valoraciones_avg_puntuacion, 1) ?? '-' }}</p>
            </div>
        @empty
            <p>No se encontraron prendas con esos criterios.</p>
        @endforelse
    </div>

    @if($prendas->hasPages())
        <nav aria-label="Paginación de prendas">
            <ul class="pagination justify-content-center my-4" id="pagination-links">
                {{-- Página anterior --}}
                <li class="page-item {{ $prendas->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $prendas->previousPageUrl() }}">&laquo;</a>
                </li>

                {{-- Todos los números --}}
                @foreach ($prendas->getUrlRange(1, $prendas->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $prendas->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Página siguiente --}}
                <li class="page-item {{ !$prendas->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $prendas->nextPageUrl() }}">&raquo;</a>
                </li>
            </ul>
        </nav>
    @endif
</div>
