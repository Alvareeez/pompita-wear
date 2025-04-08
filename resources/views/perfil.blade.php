@extends('layouts.header')

@section('title', 'Prendas Populares')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('content')

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Editar Perfil</h2>
                <form action="" enctype="multipart/form-data">
                    <!-- Foto de perfil -->
                    <div class="profile-picture-container" onclick="document.getElementById('profile-picture-input').click()">
                        <img src="{{ asset('storage/profile_pictures/default.jpg') }}" alt="Foto de perfil"
                            class="profile-picture" id="profile-picture">
                        <div class="profile-picture-overlay">
                            <span>Editar foto</span>
                        </div>
                    </div>
                    <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Nombre :</label>
                            <input type="text" name="name" id="name" class="form-control my-3"
                                placeholder="Introducir nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="lastname">Apellido :</label>
                            <input type="text" name="lastname" id="lastname" class="form-control my-3"
                                placeholder="Introducir Apellido">
                        </div>
                    </div>
                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" class="form-control my-3"
                        placeholder="Introducir correo electrónico">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="psswrd">Contraseña :</label>
                            <input type="password" name="psswrd" id="psswrd" class="form-control my-3"
                                placeholder="Introducir contraseña">
                        </div>
                        <div class="col-md-6">
                            <label for="repPsswrd">Repetir contraseña :</label>
                            <input type="password" name="repPsswrd" id="repPsswrd" class="form-control my-3"
                                placeholder="Repetir contraseña">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-outline-dark w-75">Guardar cambios</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Mi Perfil</h2>
                <div>
                    <h4>Outfits publicados</h4>
                    <div class="row">
                        <div class="col-md-4 card">
                            <img src="{{ asset('storage/outfits/outfit1.jpg') }}" alt="Outfit 1" class="outfit-image">
                        </div>
                        <div class="col-md-4 card">
                            <img src="{{ asset('storage/outfits/outfit2.jpg') }}" alt="Outfit 2" class="outfit-image">
                        </div>
                        <div class="col-md-4 card">
                            <img src="{{ asset('storage/outfits/outfit3.jpg') }}" alt="Outfit 3" class="outfit-image">
                        </div>
                    </div>
                    <div>
                        <h4>Prendas favoritas</h4>
                        <div class="row">
                            <div class="col-md-4 card">
                                <img src="{{ asset('storage/favorites/favorite1.jpg') }}" alt="Favorito 1"
                                    class="favorite-image">
                            </div>
                            <div class="col-md-4 card">
                                <img src="{{ asset('storage/favorites/favorite2.jpg') }}" alt="Favorito 2"
                                    class="favorite-image">
                            </div>
                            <div class="col-md-4 card">
                                <img src="{{ asset('storage/favorites/favorite3.jpg') }}" alt="Favorito 3"
                                    class="favorite-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Mostrar la imagen seleccionada con ajuste de tamaño
                document.getElementById('profile-picture-input').addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        const imgElement = document.getElementById('profile-picture');

                        reader.onload = function(event) {
                            // Crear una imagen temporal para calcular las dimensiones
                            const tempImg = new Image();
                            tempImg.src = event.target.result;

                            tempImg.onload = function() {
                                const containerWidth = 150; // Ancho del contenedor
                                const containerHeight = 150; // Alto del contenedor

                                // Calcular relación de aspecto
                                const imgRatio = tempImg.width / tempImg.height;
                                const containerRatio = containerWidth / containerHeight;

                                // Ajustar según la relación de aspecto
                                if (imgRatio > containerRatio) {
                                    imgElement.style.width = '100%';
                                    imgElement.style.height = 'auto';
                                } else {
                                    imgElement.style.width = 'auto';
                                    imgElement.style.height = '100%';
                                }

                                imgElement.src = event.target.result;
                            };
                        }

                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            </script>
        @endsection
