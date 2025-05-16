@forelse($outfits as $outfit)
<a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
    <div class="outfit">
        <div class="card-body">
            <h5 class="card-title">{{ $outfit->nombre }}</h5>
            <p>Creado por: {{ $outfit->usuario->nombre }}</p>
            <p>Precio total: ${{ number_format($outfit->precio_total, 2) }}</p>

            @foreach($outfit->prendas as $prenda)
                <div class="prenda-row">
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                    <p>{{ $prenda->nombre }} - ${{ number_format($prenda->precio, 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</a>
@empty
    <div class="no-results">
        <p>No se encontraron outfits que coincidan con tu búsqueda.</p>
    </div>
@endforelse