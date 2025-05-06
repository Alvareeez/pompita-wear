{{-- resources/views/prendas/partials/product-list.blade.php --}}
<div id="product-list">
    <div class="prendas">
        @forelse ($prendas as $prenda)
            <div class="prenda">
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->descripcion }}">
                </a>
                <p><strong>{{ $prenda->nombre }}</strong></p>
                <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
                <p><strong>Valoración:</strong> {{ number_format($prenda->valoraciones_avg_puntuacion, 1) ?? '-' }}</p>
            </div>
        @empty
            <p>No se encontraron prendas con esos criterios.</p>
        @endforelse
    </div>

    <div class="pagination" id="pagination-links">
        {{ $prendas->links() }}
    </div>
</div>
