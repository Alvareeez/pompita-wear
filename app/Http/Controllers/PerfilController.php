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

        // Contar seguidores (usuarios que siguen al usuario actual)
        $numeroSeguidores = $user->seguidores()->where('estado', 'aceptado')->count();

        // Contar seguidos (usuarios que el usuario actual sigue)
        $numeroSeguidos = $user->seguidos()->where('estado', 'aceptado')->count();

        $outfitsPublicados = $user->outfits;
        $favorites = $user->favoritosPrendas;

        return view('perfil', compact('user', 'numeroSeguidores', 'numeroSeguidos', 'outfitsPublicados', 'favorites'));
    }
    public function showPublicProfile($id)
{
    // Buscamos al usuario por su ID
    $user = Usuario::with(['outfits'])->findOrFail($id);

    return view('cliente.perfil_publico', compact('user'));
}

    public function update(Request $request)
    {
        $user = Usuario::findOrFail(Auth::user()->id_usuario);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'password' => 'nullable|confirmed|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar datos básicos
        $user->nombre = $request->nombre;

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
    public function deleteProfilePicture()
    {
        $user = Usuario::findOrFail(Auth::user()->id_usuario);

        if ($user->foto_perfil) {
            // Eliminar la imagen del almacenamiento
            Storage::disk('public')->delete(str_replace('storage/', '', $user->foto_perfil));

            // Establecer la imagen por defecto
            $user->foto_perfil = null;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'default_image' => asset('img/default-profile.png')
        ]);
    }
}
