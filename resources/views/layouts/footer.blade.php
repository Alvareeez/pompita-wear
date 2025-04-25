<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Pompita Wear. Todos los derechos reservados.</p>
            <ul class="footer-links">
                <li><a href="#">Política de Privacidad</a></li>
                <li><a href="#">Términos y Condiciones</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #002f6c;
        color: white;
        padding: 20px 0;
        margin-top: 30px;
    }

    .footer .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .footer-content {
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
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
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
</style>