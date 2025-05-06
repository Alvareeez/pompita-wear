@foreach($partes as $parte => $prendas)
    @php $parteKey = strtolower($parte); @endphp

    <div class="carousel-container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title">Prendas de {{ $parte }}</div>
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
            id="carousel{{ $parte }}"
            class="carousel slide"
            data-bs-interval="false"
            data-parte="{{ $parteKey }}"
        >
            <div class="carousel-inner">
                @foreach($prendas as $prenda)
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
                @endforeach
            </div>
            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#carousel{{ $parte }}"
                data-bs-slide="prev"
            >
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#carousel{{ $parte }}"
                data-bs-slide="next"
            >
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
@endforeach
