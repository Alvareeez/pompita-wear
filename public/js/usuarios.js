function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const spinner = document.getElementById("loading-spinner");

    function filtrarUsuarios() {
        const nombre = document.getElementById("filtro-nombre").value;
        const correo = document.getElementById("filtro-correo").value;
        const rol = document.getElementById("filtro-rol").value;

        spinner.style.display = "flex";

        fetch(`${usuariosIndexUrl}?nombre=${nombre}&correo=${correo}&rol=${rol}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("tabla-usuarios").innerHTML = data;
            spinner.style.display = "none";
        })
        .catch(error => {
            console.error('Error:', error);
            spinner.style.display = "none";
        });
    }

    document.getElementById("filtro-nombre").addEventListener("keyup", filtrarUsuarios);
    document.getElementById("filtro-correo").addEventListener("keyup", filtrarUsuarios);
    document.getElementById("filtro-rol").addEventListener("change", filtrarUsuarios);

    // Estado usuario
    const estadoSelects = document.querySelectorAll(".estado-select");
    estadoSelects.forEach(select => {
        select.addEventListener("change", function () {
            const userId = this.getAttribute("data-id");
            const nuevoEstado = this.value;

            fetch(usuariosUpdateEstadoUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    id_usuario: userId,
                    estado: nuevoEstado
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Estado actualizado",
                        text: `El estado del usuario ha sido cambiado a ${nuevoEstado}.`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudo actualizar el estado del usuario.",
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error al intentar actualizar el estado.",
                });
            });
        });
    });
});