    document.addEventListener('DOMContentLoaded', function () {
        const toggler = document.querySelector('.navbar-toggler');
        const menu = document.querySelector('.admin-header nav');

        if (toggler && menu) {
            toggler.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('active');
            });

            // Cerrar el menú al hacer clic fuera de él
            document.addEventListener('click', function (e) {
                if (!menu.contains(e.target) && !toggler.contains(e.target)) {
                    menu.classList.remove('active');
                }
            });
        }
    });
