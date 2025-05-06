// Likes para comentarios de outfits
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-like-comentario').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const comentarioId = this.dataset.comentarioId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/comentarios-outfits/${comentarioId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
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
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

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