@extends('layouts.header')

@section('title', 'Prendas Populares')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Editar Perfil</h2>
                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Foto de perfil -->
                    <div class="profile-picture-container"
                        onclick="document.getElementById('profile-picture-input').click()">
                        <img src="{{ asset($user->foto_perfil ?? 'storage/profile_pictures/default.jpg') }}"
                            alt="Foto de perfil" class="profile-picture" id="profile-picture">
                        <div class="profile-picture-overlay">
                            <span>Editar foto</span>
                        </div>
                    </div>
                    <input type="file" name="foto_perfil" id="profile-picture-input" accept="image/*">

                    <!-- Nombre (único campo en tu BD) -->
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control my-3"
                                placeholder="Introducir nombre" value="{{ $user->nombre ?? '' }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control my-3"
                        placeholder="Introducir correo electrónico" value="{{ $user->email ?? '' }}">

                    <!-- Contraseña (opcional para edición) -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password">Nueva contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control my-3"
                                placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Repetir contraseña:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control my-3" placeholder="Repetir contraseña">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-dark w-75">Guardar cambios</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Mi Perfil</h2>

                <!-- Slider de Outfits -->
                <div class="outfit-slider">
                    <h4>Outfits publicados</h4>
                    @if ($outfitsPublicados->count() > 0)
                        <div id="outfitsCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($outfitsPublicados->chunk(3) as $key => $chunk)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <div class="row">
                                            @foreach ($chunk as $outfit)
                                                <div class="col-md-4">
                                                    <div class="carousel-card">
                                                        <img src="{{ asset($outfit->image_path) }}"
                                                            alt="{{ $outfit->name }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($outfitsPublicados->count() > 3)
                                <button class="carousel-control-prev" type="button" data-bs-target="#outfitsCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#outfitsCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">No tienes outfits publicados aún.</div>
                    @endif
                </div>

                <!-- Slider de Favoritos -->
                <div class="favorites-slider">
                    <h4>Prendas favoritas</h4>
                    @if ($favorites->count() > 0)
                        <div id="favoritesCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($favorites->chunk(3) as $key => $chunk)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <div class="row">
                                            @foreach ($chunk as $favorite)
                                                <div class="col-md-4">
                                                    <div class="carousel-card">
                                                        <a href="{{ route('prendas.show', $favorite->id_prenda) }}">

                                                            <img src="{{ asset('img/prendas/' . $favorite->img_frontal) }}"
                                                                alt="{{ $favorite->nombre }}" class="d-block w-100">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($favorites->count() > 3)
                                <button class="carousel-control-prev" type="button" data-bs-target="#favoritesCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#favoritesCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">No tienes prendas favoritas aún.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar el SweetAlert con opciones
        function showImageSourceSelector(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Cambiar foto de perfil',
                text: '¿Cómo quieres cambiar tu foto de perfil?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Subir desde dispositivo',
                denyButtonText: 'Tomar una foto',
                cancelButtonText: 'Cancelar',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('profile-picture-input').click();
                } else if (result.isDenied) {
                    openCamera();
                }
            });
        }

        // Función para abrir la cámara
        function openCamera() {
            const video = document.createElement('video');
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Configurar SweetAlert con vista previa de cámara
            Swal.fire({
                title: 'Toma tu foto',
                html: `
                    <video id="camera-preview" autoplay playsinline style="width: 100%; max-height: 300px;"></video>
                    <button id="capture-btn" class="btn btn-primary mt-3">Capturar</button>
                `,
                showCancelButton: true,
                confirmButtonText: 'Usar esta foto',
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    const preview = document.getElementById('camera-preview');

                    // Acceder a la cámara
                    navigator.mediaDevices.getUserMedia({
                            video: true,
                            audio: false
                        })
                        .then((stream) => {
                            preview.srcObject = stream;

                            // Configurar botón de captura
                            document.getElementById('capture-btn').addEventListener('click', () => {
                                // Ajustar el canvas al tamaño del video
                                canvas.width = preview.videoWidth;
                                canvas.height = preview.videoHeight;
                                ctx.drawImage(preview, 0, 0, canvas.width, canvas.height);

                                // Detener la cámara
                                stream.getTracks().forEach(track => track.stop());

                                // Mostrar vista previa de la foto capturada
                                Swal.fire({
                                    title: 'Vista previa',
                                    imageUrl: canvas.toDataURL('image/jpeg'),
                                    imageAlt: 'Foto capturada',
                                    showCancelButton: true,
                                    confirmButtonText: 'Usar esta foto',
                                    cancelButtonText: 'Volver a tomar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Convertir la imagen a Blob y crear un archivo
                                        canvas.toBlob((blob) => {
                                            const file = new File([blob],
                                                'profile-photo.jpg', {
                                                    type: 'image/jpeg'
                                                });

                                            // Crear un DataTransfer para simular un input file
                                            const dataTransfer = new DataTransfer();
                                            dataTransfer.items.add(file);

                                            // Asignar el archivo al input
                                            const input = document.getElementById(
                                                'profile-picture-input');
                                            input.files = dataTransfer.files;

                                            // Mostrar vista previa
                                            updateProfilePreview(canvas.toDataURL(
                                                'image/jpeg'));
                                        }, 'image/jpeg', 0.9);
                                    } else {
                                        // Volver a abrir la cámara
                                        openCamera();
                                    }
                                });
                            });
                        })
                        .catch((error) => {
                            Swal.fire('Error', 'No se pudo acceder a la cámara: ' + error.message, 'error');
                        });
                },
                willClose: () => {
                    // Detener la cámara si está abierta
                    const preview = document.getElementById('camera-preview');
                    if (preview && preview.srcObject) {
                        preview.srcObject.getTracks().forEach(track => track.stop());
                    }
                }
            });
        }

        // Función para actualizar la vista previa de la foto de perfil
        function updateProfilePreview(imageSrc) {
            const imgElement = document.getElementById('profile-picture');
            const tempImg = new Image();
            tempImg.src = imageSrc;

            tempImg.onload = function() {
                const containerWidth = 150;
                const containerHeight = 150;
                const imgRatio = tempImg.width / tempImg.height;
                const containerRatio = containerWidth / containerHeight;

                if (imgRatio > containerRatio) {
                    imgElement.style.width = '100%';
                    imgElement.style.height = 'auto';
                } else {
                    imgElement.style.width = 'auto';
                    imgElement.style.height = '100%';
                }

                imgElement.src = imageSrc;
            };
        }

        // Evento para el contenedor de la foto de perfil
        document.querySelector('.profile-picture-container').addEventListener('click', showImageSourceSelector);

        // Evento para cuando se selecciona un archivo manualmente
        document.getElementById('profile-picture-input').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    updateProfilePreview(event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Inicializar los carruseles (código existente)
        document.addEventListener('DOMContentLoaded', function() {
            @if ($outfitsPublicados->count() > 0)
                const outfitCarousel = new bootstrap.Carousel(document.getElementById('outfitsCarousel'), {
                    interval: 5000,
                    wrap: true
                });
            @endif

            @if ($favorites->count() > 0)
                const favoritesCarousel = new bootstrap.Carousel(document.getElementById('favoritesCarousel'), {
                    interval: 5000,
                    wrap: true
                });
            @endif
        });
    </script>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

@endsection
