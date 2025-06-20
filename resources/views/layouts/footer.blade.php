@section('css')
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
@endsection


<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <ul class="footer-links">
                <li><a href="#" class="modal-trigger" data-target="privacy-modal">Política de Privacidad</a></li>
                <li><a href="#" class="modal-trigger" data-target="terms-modal">Términos y Condiciones</a></li>
            </ul>
            <p>&copy; {{ date('Y') }} Pompita Wear. Todos los derechos reservados.</p>

        </div>

        <ul class="social-icons example-2">
            <li class="icon-content">
                <a data-social="whatsapp" aria-label="WhatsApp"
                    href="https://api.whatsapp.com/send?phone=+34640262739&text=Hola%20Pompita%20Wear!">
                    <div class="filled"></div>
                    <svg xml:space="preserve" viewBox="0 0 24 24" class="bi bi-whatsapp" fill="currentColor"
                        height="24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z">
                        </path>
                    </svg>
                </a>
                <div class="tooltip">WhatsApp</div>
            </li>
            <li class="icon-content">
                <a data-social="facebook" aria-label="Facebook" href="https://www.facebook.com/pompitawear">
                    <div class="filled"></div>
                    <svg xml:space="preserve" viewBox="0 0 24 24" class="bi bi-facebook" fill="currentColor"
                        height="24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z">
                        </path>
                    </svg>
                </a>
                <div class="tooltip">Facebook</div>
            </li>
            <li class="icon-content">
                <a data-social="instagram" aria-label="Instagram" href="https://www.instagram.com/pompitawear">
                    <div class="filled"></div>
                    <svg xml:space="preserve" viewBox="0 0 16 16" class="bi bi-instagram" fill="currentColor"
                        height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334">
                        </path>
                    </svg>
                </a>
                <div class="tooltip">Instagram</div>
        </ul>
    </div>
    <!-- Modales -->
    <div id="privacy-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Política de Privacidad</h2>
            <div class="modal-body">
                <p>
                <h3>1. Información que recopilamos</h3>
                Recopilamos información cuando los usuarios se registran en nuestro sitio, realizan compras, se
                suscriben a un boletín informativo, responden a una encuesta o navegan por el sitio. Esta información
                puede incluir:

                Nombre
                Dirección de correo electrónico
                Información demográfica (como ubicación, edad, intereses)
                Datos de uso del sitio web
                <h3>2. Uso de cookies</h3>
                Utilizamos cookies y tecnologías similares para mejorar la experiencia del usuario, analizar el tráfico
                del sitio y personalizar contenido. Al utilizar este sitio web, aceptas el uso de cookies conforme a
                esta política.

                <h3>3. Cómo utilizamos su información</h3>
                La información recopilada puede ser utilizada para:

                Personalizar la experiencia del usuario
                Mejorar nuestro sitio web
                Enviar correos electrónicos periódicos
                Procesar transacciones
                <h3>4. Protección de su información</h3>
                Implementamos diversas medidas de seguridad para proteger la información sensible contra acceso no
                autorizado, alteración, divulgación o destrucción.

                <h3>5. Divulgación a terceros</h3>
                No vendemos, intercambiamos ni transferimos a terceros su información personal identificable sin su
                consentimiento expreso, salvo que sea requerido por ley.

                <h3>6. Sus derechos </h3>
                Usted tiene derecho a:

                Acceder a sus datos personales
                Solicitar su corrección o eliminación
                Oponerse al tratamiento de sus datos
                Retirar su consentimiento en cualquier momento
                Puede ejercer estos derechos enviando un correo electrónico a [info@pompitawear.com ].

                <h3>7. Cambios en esta política</h3>
                Nos reservamos el derecho de actualizar esta Política de Privacidad en cualquier momento. Le
                recomendamos revisar esta página periódicamente para estar informado sobre posibles cambios.</p>
            </div>
        </div>
    </div>

    <div id="terms-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Términos y Condiciones</h2>
            <div class="modal-body">
                <p>
                <h3>1. Aceptación de los términos</h3>
                Al acceder y utilizar este sitio web, usted acepta cumplir con los presentes Términos y Condiciones. Si
                no está de acuerdo con alguno de ellos, no debe continuar navegando.

                <h3>2. Descripción del servicio</h3>
                Este sitio web ofrece servicios relacionados con la creación de outfits, gestión de prendas de vestir,
                calendario de uso de ropa, entre otras funcionalidades. Nos reservamos el derecho de modificar o
                interrumpir temporal o permanentemente el servicio.

                <h3>3. Registro de cuenta</h3>
                Para acceder a ciertas funciones, es necesario crear una cuenta. El usuario es responsable de mantener
                la confidencialidad de su contraseña y de todas las actividades que ocurran bajo su cuenta.

                <h3>4. Conducta del usuario</h3>
                El usuario se compromete a:

                No usar el sitio con fines ilegales o prohibidos.
                No interferir con el funcionamiento del sitio.
                No publicar contenido ofensivo, falso o engañoso.
                <h3>5. Contenido generado por los usuarios</h3>
                Los usuarios pueden publicar contenido (fotos, comentarios, outfits, etc.). Al hacerlo, otorgan una
                licencia no exclusiva, mundial y gratuita para mostrar ese contenido en el sitio.

                <h3>6. Propiedad intelectual</h3>
                Todo el contenido del sitio (texto, imágenes, diseño, logos, etc.) es propiedad de [Pompita Wear] o de
                sus proveedores y está protegido por leyes de propiedad intelectual.

                <h3>7. Limitación de responsabilidad</h3>
                No nos hacemos responsables por daños directos, indirectos, incidentales, especiales o consecuentes
                derivados del uso o imposibilidad de uso del sitio.

                <h3>8. Ley aplicable y jurisdicción</h3>
                Estos términos se rigen e interpretan de acuerdo con las leyes de [España]. Cualquier disputa será
                resuelta en los tribunales competentes de dicha jurisdicción.</p>
            </div>
        </div>
    </div>
</footer>

<style>
    li {
        list-style: none;
    }

    main {
        padding: 0px;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    /* Modifica el estilo del footer */
    .footer {
        background-color: #002f6c;
        color: white;
        padding: 50px 0 30px 0;
        margin: 0;
        width: 100%;
        /* Asegura que ocupe todo el ancho */
        position: relative;
        box-sizing: border-box;
        min-height: 220px;
        margin-bottom: -50px !important;
    }

    /* Asegúrate de que el contenedor principal no tenga márgenes no deseados */
    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Elimina cualquier margen o padding adicional en el body */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* Si estás usando un layout principal, asegúrate de que el contenido empuje el footer hacia abajo */
    .main-content {
        flex: 1 0 auto;
    }

    .footer .container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 0 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 18px;
    }

    .footer-content {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .footer-content p {
        margin: 0;
        font-size: 14px;
    }

    .footer-links {
        display: flex;
        gap: 25px;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        display: inline;
    }

    .footer-links a {
        color: white;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: #ffdd57;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
        margin: 0;
        padding: 0;
    }

    .icon-content {
        position: relative;
    }

    .icon-content .tooltip {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        padding: 6px 10px;
        border-radius: 5px;
        opacity: 0;
        visibility: hidden;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .icon-content:hover .tooltip {
        opacity: 1;
        visibility: visible;
        top: -50px;
    }

    .icon-content a {
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        color: #4d4d4d;
        background-color: #fff;
        transition: all 0.3s ease-in-out;
    }

    .icon-content a:hover {
        box-shadow: 3px 2px 45px 0px rgb(0 0 0 / 12%);
    }

    .icon-content a svg {
        position: relative;
        z-index: 1;
        width: 30px;
        height: 30px;
    }

    .icon-content a:hover {
        color: white;
    }

    .icon-content a .filled {
        position: absolute;
        top: auto;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0;
        background-color: #000;
        transition: all 0.3s ease-in-out;
    }

    .icon-content a:hover .filled {
        height: 100%;
    }

    .icon-content a[data-social="whatsapp"] .filled,
    .icon-content a[data-social="whatsapp"]~.tooltip {
        background-color: #128c7e;
    }

    .icon-content a[data-social="facebook"] .filled,
    .icon-content a[data-social="facebook"]~.tooltip {
        background-color: #3b5998;
    }

    .icon-content a[data-social="instagram"] .filled,
    .icon-content a[data-social="instagram"]~.tooltip {
        background: linear-gradient(45deg, #405de6, #5b51db, #b33ab4, #c135b4, #e1306c, #fd1f1f);
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 2% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 8px;
        color: #333;
    }

    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: black;
        text-decoration: none;
    }

    .modal-body {
        margin-top: 0px;
        padding: 10px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal h2 {
        color: #002f6c;
        margin-bottom: 20px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Abrir modal
        document.querySelectorAll('.modal-trigger').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');
                document.getElementById(target).style.display = 'block';
            });
        });

        // Cerrar modal
        document.querySelectorAll('.close-modal').forEach(span => {
            span.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });

        // Cerrar al hacer clic fuera del contenido
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
    });
</script>
