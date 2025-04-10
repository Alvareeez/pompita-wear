//Dar like
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.getElementById('like-button');

    if (likeButton) {
        likeButton.addEventListener('click', function(e) {
            e.preventDefault();
            const prendaId = this.dataset.prendaId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/prendas/${prendaId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            window.location.href = '{{ route("login") }}';
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('likes-count').textContent = data.likes_count;
                    if (data.liked) {
                        likeButton.classList.add('liked');
                    } else {
                        likeButton.classList.remove('liked');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar tu like');
                });
        });
    }
});

// Likes para comentarios
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-like-comentario').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const comentarioId = this.dataset.comentarioId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/comentarios/${comentarioId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            window.location.href = '{{ route("login") }}';
                        }
                        throw new Error('Error en la respuesta');
                    }
                    return response.json();
                })
                .then(data => {
                    const likesCountElement = this.querySelector('.likes-count');
                    if (likesCountElement) {
                        likesCountElement.textContent = data.likes_count;
                    }
                    if (data.liked) {
                        this.classList.add('liked');
                    } else {
                        this.classList.remove('liked');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar tu like');
                });
        });
    });
});

//Contador comentarios
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="comentario"]');
    const contador = document.querySelector('.contador-caracteres');

    if (textarea && contador) {
        const maxCaracteres = 500;

        textarea.addEventListener('input', function() {
            const caracteresRestantes = maxCaracteres - this.value.length;
            contador.textContent = `${caracteresRestantes} caracteres restantes`;

            if (caracteresRestantes < 0) {
                contador.style.color = 'red';
                this.value = this.value.substring(0, maxCaracteres);
            } else {
                contador.style.color = '#6c757d';
            }
        });
    }
});