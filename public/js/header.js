document.addEventListener('DOMContentLoaded', function () {
    // Notificaciones desktop
    const setupDesktopNotifications = () => {
        const btn = document.getElementById('notification-button');
        const panel = document.getElementById('notification-panel');
        if (btn && panel) {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                panel.classList.toggle('active');
            });
            document.addEventListener('click', e => {
                if (!panel.contains(e.target) && !btn.contains(e.target)) {
                    panel.classList.remove('active');
                }
            });
        }
    };

    // Notificaciones mobile
    const setupMobileNotifications = () => {
        const mobileBtn = document.getElementById('mobile-notification-button');
        const mobilePanel = document.getElementById('mobile-notification-panel');
        if (mobileBtn && mobilePanel) {
            mobileBtn.addEventListener('click', e => {
                e.stopPropagation();
                mobilePanel.classList.toggle('active');
            });
            document.addEventListener('click', e => {
                if (!mobilePanel.contains(e.target) && !mobileBtn.contains(e.target)) {
                    mobilePanel.classList.remove('active');
                }
            });
        }
    };

    // Buscador AJAX
    const setupSearch = (inputId, resultsId) => {
        const input = document.getElementById(inputId);
        const results = document.getElementById(resultsId);
        let timer;

        if (input && results) {
            input.addEventListener('keyup', () => {
                clearTimeout(timer);
                const q = input.value.trim();
                if (!q) {
                    results.innerHTML = '';
                    return;
                }
                timer = setTimeout(() => {
                    fetch(`${window.Laravel.searchRoute}?query=${encodeURIComponent(q)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(users => {
                            if (!Array.isArray(users)) {
                                console.error('Expected array, received:', users);
                                results.innerHTML = '<div class="search-error">No se encontraron resultados</div>';
                                return;
                            }

                            if (users.length === 0) {
                                results.innerHTML = '<div class="search-error">No se encontraron coincidencias</div>';
                                return;
                            }

                            results.innerHTML = users.map(u => `
                        <div class="search-item" data-id="${u.id_usuario}">
                            <img src="${u.avatar}" class="search-avatar" onerror="this.src='/img/default-profile.png'">
                            <span>${u.nombre}</span>
                        </div>
                    `).join('');

                            document.querySelectorAll(`#${resultsId} .search-item`).forEach(item => {
                                item.addEventListener('click', () => {
                                    window.location.href = `/perfil/publico/${item.dataset.id}`;
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error en la búsqueda:', error);
                            results.innerHTML = '<div class="search-error">Error al buscar usuarios</div>';
                        });
                }, 300);
            });

            document.addEventListener('click', e => {
                if (!input.contains(e.target) && !results.contains(e.target)) {
                    results.innerHTML = '';
                }
            });
        }
    };

    // Inicializar todas las funcionalidades
    setupDesktopNotifications();
    setupMobileNotifications();
    setupSearch('user-search', 'search-results');
    setupSearch('mobile-user-search', 'mobile-search-results');
});