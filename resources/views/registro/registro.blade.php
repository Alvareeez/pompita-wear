<!-- resources/views/registro/registro.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro - Pompita Wear</title>
  <link rel="stylesheet" href="{{ asset('css/stylesRegistro.css') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="logo-container">
      <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear" class="logo">
    </div>
    <div class="form-container">
      <h2 class="title-container">Registro</h2>

      <a href="{{ route('google.redirect') }}" class="btn-google">
        <i class="fab fa-google"></i> Registrarse con Google
      </a>
      <p class="divider">— o —</p>

      <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form-group">
          <input type="text" name="nombre" placeholder="Nombre completo"
                 value="{{ old('nombre') }}" required>
          <span class="error">@error('nombre'){{ $message }}@enderror</span>
        </div>

        <div class="form-group">
          <input type="email" name="email" placeholder="Correo electrónico"
                 value="{{ old('email') }}" required>
          <span class="error">@error('email'){{ $message }}@enderror</span>
        </div>

        <div class="form-group">
          <div class="password-toggle-container">
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <span class="toggle-password" data-target="password"><i class="fas fa-eye"></i></span>
          </div>
          <span class="error">@error('password'){{ $message }}@enderror</span>
        </div>

        <div class="form-group">
          <div class="password-toggle-container">
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Repetir contraseña" required>
            <span class="toggle-password" data-target="password_confirmation"><i class="fas fa-eye"></i></span>
          </div>
          <span class="error">@error('password_confirmation'){{ $message }}@enderror</span>
        </div>

        <div class="form-group">
          <label for="rol">Tipo de cuenta</label>
          <select name="rol" id="rol" required>
            <option value="cliente" {{ old('rol')=='cliente' ? 'selected':'' }}>Cliente</option>
            <option value="empresa" {{ old('rol')=='empresa' ? 'selected':'' }}>Empresa</option>
          </select>
          <span class="error">@error('rol'){{ $message }}@enderror</span>
        </div>

        <div id="datos-empresa" style="display:none;">
          <div class="form-group">
            <input type="text" name="razon_social" placeholder="Nombre marca"
                   value="{{ old('razon_social') }}">
            <span class="error">@error('razon_social'){{ $message }}@enderror</span>
          </div>
          <div class="form-group">
            <input type="text" name="nif" placeholder="NIF/CIF" value="{{ old('nif') }}">
            <span class="error">@error('nif'){{ $message }}@enderror</span>
          </div>
        </div>

        <button type="submit">CREAR USUARIO</button>
      </form>

      <p class="mt-3">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
      </p>
    </div>
  </div>

  <script>
    document.querySelectorAll('.toggle-password').forEach(toggle => {
      const input = document.getElementById(toggle.dataset.target);
      const icon  = toggle.querySelector('i');
      toggle.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
      });
    });

    const rolSelect = document.getElementById('rol');
    const datosEmpresa = document.getElementById('datos-empresa');
    function toggleEmpresa() {
      datosEmpresa.style.display = rolSelect.value === 'empresa' ? 'block' : 'none';
    }
    rolSelect.addEventListener('change', toggleEmpresa);
    document.addEventListener('DOMContentLoaded', toggleEmpresa);
  </script>
</body>
</html>
