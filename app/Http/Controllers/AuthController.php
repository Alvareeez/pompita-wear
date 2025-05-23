<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Empresa;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:usuarios,email',
            'password'     => 'required|string|min:8|confirmed',
            'rol'          => 'required|in:cliente,empresa,gestor',
            'razon_social' => 'required_if:rol,empresa|string|max:255',
            'nif'          => 'nullable|string|max:20',
        ]);

        DB::transaction(function() use ($request) {
            $rol = Rol::where('nombre', $request->rol)->firstOrFail();

            $usuario = Usuario::create([
                'nombre'     => $request->nombre,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'id_rol'     => $rol->id_rol,
                'estado'     => 'activo',
                'is_private' => $request->rol === 'cliente',
            ]);

            if ($request->rol === 'empresa') {
                Empresa::create([
                    'usuario_id'   => $usuario->id_usuario,
                    'slug'         => Str::slug($request->razon_social),
                    'razon_social' => $request->razon_social,
                    'nif'          => $request->nif,
                ]);
            }

            Mail::to($usuario->email)->queue(new WelcomeMail($usuario));
        });

        return redirect()->route('login')
                         ->with('success', 'Registro completado. Por favor, inicia sesión.');
    }

    // Login de usuario
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (! $usuario) {
            return back()->withErrors(['email' => 'El correo no está registrado.']);
        }

        if ($usuario->estado === 'baneado') {
            return back()->withErrors(['email' => 'Tu cuenta ha sido baneada. Contacta con soporte.']);
        }

        if ($usuario->estado === 'inactivo') {
            return back()->with('reactivar', $usuario->id_usuario);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $usuario = Auth::user();
            $rolNombre = $usuario->rol->nombre;

            if ($rolNombre === 'empresa') {
                return redirect()->route('empresas.index')
                                 ->with('success', 'Bienvenido, '.$usuario->nombre.' (Empresa).');
            }

            if ($rolNombre === 'gestor') {
                return redirect()->route('gestor.index')
                                 ->with('success', 'Bienvenido, '.$usuario->nombre.' (Gestor).');
            }

            if ($rolNombre === 'programador') {
                return redirect()->route('programador.index')
                                 ->with('success', 'Bienvenido, '.$usuario->nombre.' (Programador).');
            }

            // Por defecto cliente u otros roles
            return redirect()->route('home')
                             ->with('success', 'Has iniciado sesión correctamente.');
        }

        return back()->withErrors(['password' => 'Contraseña incorrecta.']);
    }

    // Logout de usuario
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Reactivar cuenta
    public function reactivarCuenta(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
        ]);

        $usuario = Usuario::findOrFail($request->id_usuario);
        $usuario->estado = 'activo';
        $usuario->save();

        return redirect()->route('login')
                         ->with('success', 'Tu cuenta ha sido reactivada.');
    }
}
