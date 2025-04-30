document.addEventListener('DOMContentLoaded', function () {
    // Manejar el botón de seguir
    const followButtons = document.querySelectorAll('.follow-button');

    followButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.getAttribute('data-user-id');

            fetch('/enviar-solicitud', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id_seguido: userId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Solicitud enviada!',
                            text: data.message,
                            icon: 'success',
                            timer: 2000
                        });
                        button.disabled = true;
                        button.textContent = 'Solicitud enviada';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.error,
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al enviar la solicitud',
                        icon: 'error'
                    });
                });
        });
    });

    // Manejar aceptar/rechazar solicitudes
    const acceptButtons = document.querySelectorAll('.accept-request');
    const rejectButtons = document.querySelectorAll('.reject-request');

    function handleRequest(url, button, successMessage) {
        button.disabled = true;
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: successMessage,
                        icon: 'success',
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.error || 'Ocurrió un error',
                        icon: 'error'
                    });
                    button.disabled = false;
                }
            });
    }

    acceptButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            handleRequest(url, this, 'Solicitud aceptada correctamente');
        });
    });

    rejectButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            handleRequest(url, this, 'Solicitud rechazada');
        });
    });
});