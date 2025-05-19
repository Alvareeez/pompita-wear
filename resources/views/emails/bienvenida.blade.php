{{-- filepath: resources/views/emails/bienvenida.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
</head>

<body>
    <h1>¡Bienvenido, {{ $usuario->nombre }}!</h1>
    <p>Gracias por registrarte en nuestra web.</p>
</body>

</html>
