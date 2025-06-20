@foreach($partes as $parte => $prendas)
    @php $parteKey = strtolower($parte); @endphp

    <div class="carousel-container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                @if(request("color_$parteKey"))
                    <span class="badge bg-info">Color</span>
                @endif
                @if(request("estilo_$parteKey"))
                    <span class="badge bg-warning text-dark">Estilo</span>
                @endif
            </div>
        </div>

        <div
            id="carousel{{ $parteKey }}"
            class="carousel slide"
            data-bs-interval="false"
            data-parte="{{ $parteKey }}"
        >
            <div class="carousel-inner">
                @forelse($prendas as $prenda)
                    <div
                        class="carousel-item @if($loop->first) active @endif"
                        data-prenda-id="{{ $prenda->id_prenda }}"
                    >
                        <div class="carousel-slide-container">
                            <img
                                src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                                class="d-block img-fluid"
                                alt="{{ $prenda->nombre }}"
                            >
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        No hay prendas disponibles para {{ strtolower($parte) }}.
                    </div>
                @endforelse
            </div>
            @if($prendas->count())
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carousel{{ $parteKey }}"
                    data-bs-slide="prev"
                >
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carousel{{ $parteKey }}"
                    data-bs-slide="next"
                >
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            @endif
        </div>
    </div>
@endforeach
