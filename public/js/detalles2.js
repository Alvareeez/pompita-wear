// Likes
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.getElementById('like-button');

    if (likeButton) {
        likeButton.addEventListener('click', function(e) {
            e.preventDefault();
            const outfit = this.dataset.outfitId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/outfit/${outfit}/like`, {
                    method: 'GET',
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