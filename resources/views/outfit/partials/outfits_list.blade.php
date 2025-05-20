<div id="outfits-list">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($outfits as $outfit)
      <div class="col">
        <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="text-decoration-none">
          <div class="card h-100">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $outfit->nombre }}</h5>
              <p class="text-muted mb-2">Creado por {{ $outfit->usuario->nombre }}</p>
              <div class="d-flex flex-wrap justify-content-center gap-2 prenda-stack">
                @foreach($outfit->prendas as $prenda)
                    <img
                    src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                    class="img-thumbnail"
                    alt="{{ $prenda->nombre }}"
                    title="{{ $prenda->nombre }}"
                    >
                @endforeach
                </div>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center">No se encontraron outfits.</div>
      </div>
    @endforelse
  </div>

  {{-- Paginación Bootstrap --}}
  @if($outfits->hasPages())
    <nav aria-label="Paginación de outfits" class="mt-4">
      <ul class="pagination justify-content-center" id="pagination-links">
        <li class="page-item {{ $outfits->onFirstPage() ? 'disabled' : '' }}">
          <a class="page-link" href="{{ $outfits->previousPageUrl() }}" aria-label="Anterior">&laquo;</a>
        </li>
        @foreach($outfits->getUrlRange(1, $outfits->lastPage()) as $page => $url)
          <li class="page-item {{ $page == $outfits->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach
        <li class="page-item {{ !$outfits->hasMorePages() ? 'disabled' : '' }}">
          <a class="page-link" href="{{ $outfits->nextPageUrl() }}" aria-label="Siguiente">&raquo;</a>
        </li>
      </ul>
    </nav>
  @endif
</div>
