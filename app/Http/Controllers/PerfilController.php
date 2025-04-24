<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $outfitsPublicados = $user->outfits;
        $favorites = $user->favoritosPrendas;

        return view('perfil', compact('user', 'outfitsPublicados', 'favorites'));
    }

    public function update(Request $request)
    {
        $user = Usuario::findOrFail(Auth::user()->id_usuario);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
            'password' => 'nullable|confirmed|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            // Eliminar la imagen anterior si existe
            if ($user->foto_perfil) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->foto_perfil));
            }

            // Guardar la nueva imagen
            $path = $request->file('foto_perfil')->store('profile_pictures', 'public');
            $user->foto_perfil = 'storage/' . $path;
        }

        // Guardar cambios
        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}
