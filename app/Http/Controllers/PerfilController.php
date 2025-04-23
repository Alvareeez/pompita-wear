<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Outfits publicados por el usuario (no los favoritos)
        $outfitsPublicados = $user->outfits;

        // Prendas favoritas del usuario
        $favorites = $user->favoritosPrendas;

        return view('perfil', compact('user', 'outfitsPublicados', 'favorites'));
    }

    public function update(Request $request)
    {
        // Obtener el usuario por ID
        $user = Usuario::findOrFail(Auth::user()->id_usuario);
        // Verificar si el usuario autenticado tiene el rol de administrador
        if (Auth::user()->id_rol != 1) {
            return redirect()->route('admin.usuarios.index')->with('error', 'No tienes permiso para editar este usuario.');
        }
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
            'password' => 'nullable|confirmed|min:8',
            'foto_perfil' => 'nullable|image|max:2048',
        ]);

        // Actualizar datos básicos
        $user->nombre = $request->nombre;
        $user->email = $request->email;

        // Actualizar contraseña si se proporcionó
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Actualizar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('profile_pictures', 'public');
            $user->foto_perfil = 'storage/' . $path;
        }

        // Guardar cambios
        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}
