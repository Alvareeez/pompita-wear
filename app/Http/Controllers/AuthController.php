<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

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
    
        Usuario::create([
            'nombre'     => $request->nombre,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'id_rol'     => 2,           // rol cliente por defecto
            'estado'     => 'activo',    // estado activo por defecto
            'is_private' => true,        // cuenta privada por defecto
        ]);
    
        return redirect('/login')
               ->with('success', 'Usuario registrado correctamente. Por favor, inicia sesión.');
    }
    

    // Login de usuario
    public function login(Request $request)
    {
        // Validación de los campos de login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentamos autenticar al usuario con los datos proporcionados
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Si es exitoso, redirigimos a la página principal
            return redirect('/')->with('success', 'Sesión iniciada correctamente.');
        }

        // Si las credenciales son incorrectas, devolvemos un error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
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
}

