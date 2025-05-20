<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombre'     => $request->nombre,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'id_rol'     => 2,           // rol cliente por defecto
            'estado'     => 'activo',    // estado activo por defecto
            'is_private' => true,        // cuenta privada por defecto
        ]);

        // Enviar el correo de bienvenida
        Mail::to($usuario->email)
        ->send(new WelcomeMail($usuario));

        return redirect('/login')
            ->with('success', 'Usuario registrado correctamente. Por favor, inicia sesión.');
    }


    // Login de usuario
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario) {
            return back()->withErrors(['email' => 'El correo electrónico no está registrado.']);
        }

        if ($usuario->estado === 'baneado') {
            return back()->withErrors(['email' => 'Tu cuenta ha sido baneada. Contacta con el administrador.']);
        }

        if ($usuario->estado === 'inactivo') {
            return back()->with('reactivar', $usuario->id_usuario);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/')->with('success', 'Sesión iniciada correctamente.');
        }

        return back()->withErrors(['email' => 'Las credenciales proporcionadas son incorrectas.']);
    }

    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario
        Auth::logout();

        // Invalidar la sesión actual
        $request->session()->invalidate();

        // Regenerar el token CSRF para mayor seguridad
        $request->session()->regenerateToken();

        return redirect('/login'); // Cambia '/login' por la ruta que prefieras
    }

    public function reactivarCuenta(Request $request)
    {
        try {
            $usuario = Usuario::findOrFail($request->id_usuario);
            $usuario->estado = 'activo';
            $usuario->save();

            return redirect()->route('login')->with('success', 'Tu cuenta ha sido reactivada. Ahora puedes iniciar sesión.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ocurrió un error al reactivar tu cuenta.']);
        }
    }
}
