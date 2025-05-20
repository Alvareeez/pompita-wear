// Función para mostrar el SweetAlert con opciones
function showImageSourceSelector(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Cambiar foto de perfil',
        text: '¿Qué acción deseas realizar?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Subir desde dispositivo',
        denyButtonText: 'Tomar una foto',
        cancelButtonText: 'Cancelar',
        showCloseButton: true,
        footer: '<button class=\'btn btn-danger\' id=\'swal-delete-button\'>Eliminar foto actual</button>',
        icon: 'question'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('profile-picture-input').click();
        } else if (result.isDenied) {
            openCamera();
        }
    });

    // Agregar evento al botón de eliminar dentro del SweetAlert
    setTimeout(() => {
        const deleteButton = document.getElementById('swal-delete-button');
        if (deleteButton) {
            deleteButton.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.close();
                deleteProfilePicture();
            });
        }
    }, 100);
}

function deleteProfilePicture() {
    console.log('URL:', window.deleteProfilePictureUrl); // Verifica en consola

    if (!window.deleteProfilePictureUrl) {
        console.error('La URL para eliminar la foto no está definida');
        return;
    }
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará tu foto de perfil actual.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(window.deleteProfilePictureUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const profileImg = document.getElementById('profile-picture');
                        if (profileImg) {
                            profileImg.src = window.defaultImage;
                            profileImg.style.width = '100%';
                            profileImg.style.height = 'auto';
                        }

                        Swal.fire({
                            title: '¡Eliminada!',
                            text: 'Tu foto de perfil ha sido eliminada.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Ocurrió un error al eliminar la foto.', 'error');
                });
        }
    });
}
// Función para abrir la cámara
function openCamera() {
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
            navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            })
                .then((stream) => {
                    preview.srcObject = stream;

                    // Configurar botón de captura
                    document.getElementById('capture-btn').addEventListener('click', () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = preview.videoWidth;
                        canvas.height = preview.videoHeight;
                        const ctx = canvas.getContext('2d');
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
                                    const file = new File([blob], 'profile-photo.jpg', {
                                        type: 'image/jpeg'
                                    });

                                    // Crear un DataTransfer para simular un input file
                                    const dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(file);

                                    // Asignar el archivo al input
                                    const input = document.getElementById('profile-picture-input');
                                    input.files = dataTransfer.files;

                                    // Mostrar vista previa
                                    updateProfilePreview(canvas.toDataURL('image/jpeg'));
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
    if (!imgElement) return;

    const tempImg = new Image();
    tempImg.onload = function () {
        imgElement.src = imageSrc;
        // Ajustar proporciones
        const container = imgElement.parentElement;
        const containerRatio = container.offsetWidth / container.offsetHeight;
        const imgRatio = tempImg.width / tempImg.height;

        if (imgRatio > containerRatio) {
            imgElement.style.width = '100%';
            imgElement.style.height = 'auto';
        } else {
            imgElement.style.width = 'auto';
            imgElement.style.height = '100%';
        }
    };
    tempImg.src = imageSrc;
}

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM cargado"); // Verifica que esto aparezca en la consola
    // Evento para el contenedor de la foto de perfil
    const profileContainer = document.querySelector('.profile-picture-container');
    if (profileContainer) {
        profileContainer.addEventListener('click', showImageSourceSelector);
    }

    // Evento para cuando se selecciona un archivo manualmente
    const fileInput = document.getElementById('profile-picture-input');
    if (fileInput) {
        fileInput.addEventListener('change', function (e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    updateProfilePreview(event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // // Inicializar los carruseles
    // @if ($outfitsPublicados -> count() > 0)
    //     new bootstrap.Carousel(document.getElementById('outfitsCarousel'), {
    //         interval: 5000,
    //         wrap: true
    //     });
    // @endif

    // @if ($favorites -> count() > 0)
    //     new bootstrap.Carousel(document.getElementById('favoritesCarousel'), {
    //         interval: 5000,
    //         wrap: true
    //     });
    // @endif
});