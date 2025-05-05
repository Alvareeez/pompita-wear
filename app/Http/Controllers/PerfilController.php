<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function show($id_usuario = null)
    {
        // Si no se proporciona ID, mostrar el perfil del usuario autenticado
        $user = $id_usuario ? Usuario::findOrFail($id_usuario) : Auth::user();

        // Verificar si el usuario existe
        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }

        // Contar seguidores y seguidos (solo relaciones aceptadas)
        $numeroSeguidores = $user->seguidores()->where('estado', 'aceptado')->count();
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
    public function follow(Request $request)
    {
        $followerId = Auth::id();
        $followedId = $request->id_seguido;

        // No permitir seguirse a sí mismo
        if ($followerId == $followedId) {
            return response()->json(['error' => 'No puedes seguirte a ti mismo'], 400);
        }

        $user = Usuario::findOrFail($followedId);
        $follower = Usuario::findOrFail($followerId);

        // Verificar si ya existe una solicitud
        $existingFollow = $follower->seguidos()
            ->where('id_seguido', $followedId)
            ->first();

        if ($existingFollow) {
            return response()->json(['error' => 'Ya has enviado una solicitud a este usuario'], 400);
        }

        // Crear la relación de seguimiento
        $follower->seguidos()->attach($followedId, ['estado' => 'pendiente']);

        return response()->json([
            'success' => true,
            'message' => 'Solicitud de seguimiento enviada'
        ]);
    }
    public function acceptFollow(Request $request)
    {
        $followedId = Auth::id();
        $followerId = $request->id_seguidor;

        $follow = DB::table('seguidores')
            ->where('id_seguidor', $followerId)
            ->where('id_seguido', $followedId)
            ->update(['estado' => 'aceptado']);

        if ($follow) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Solicitud no encontrada'], 404);
    }

    public function rejectFollow(Request $request)
    {
        $followedId = Auth::id();
        $followerId = $request->id_seguidor;

        $deleted = DB::table('seguidores')
            ->where('id_seguidor', $followerId)
            ->where('id_seguido', $followedId)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Solicitud no encontrada'], 404);
    }
    public function enviarSolicitud(Request $request)
    {
        $request->validate([
            'id_seguido' => 'required|exists:usuarios,id_usuario'
        ]);

        $seguidorId = Auth::id();
        $seguidoId = $request->id_seguido;

        // Evitar auto-seguimiento
        if ($seguidorId == $seguidoId) {
            return back()->with('error', 'No puedes enviarte una solicitud a ti mismo');
        }

        // Verificar si ya existe una solicitud
        $solicitudExistente = DB::table('seguidores')
            ->where('id_seguidor', $seguidorId)
            ->where('id_seguido', $seguidoId)
            ->exists();

        if ($solicitudExistente) {
            return back()->with('error', 'Ya has enviado una solicitud a este usuario');
        }

        // Crear la solicitud
        DB::table('seguidores')->insert([
            'id_seguidor' => $seguidorId,
            'id_seguido' => $seguidoId,
            'estado' => 'pendiente',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Solicitud de seguimiento enviada correctamente');
    } // Añade estos métodos al final del controlador:

    public function solicitudesPendientes()
    {
        // Obtener solicitudes pendientes donde el usuario actual es el seguido
        $solicitudes = Auth::user()->seguidores()
            ->where('estado', 'pendiente')
            ->get();

        // O puedes usar esto para incluir toda la información del seguidor:
        $solicitudes = DB::table('seguidores')
            ->join('usuarios', 'seguidores.id_seguidor', '=', 'usuarios.id_usuario')
            ->where('seguidores.id_seguido', Auth::id())
            ->where('seguidores.estado', 'pendiente')
            ->select('usuarios.*', 'seguidores.id_seguimiento')
            ->get();

        return view('solicitudes', compact('solicitudes'));
    }

    public function aceptarSolicitud($idSeguimiento)
    {
        DB::table('seguidores')
            ->where('id_seguimiento', $idSeguimiento)
            ->where('id_seguido', Auth::id())
            ->update(['estado' => 'aceptado']);

        return back()->with('success', 'Solicitud aceptada correctamente');
    }

    public function rechazarSolicitud($idSeguimiento)
    {
        DB::table('seguidores')
            ->where('id_seguimiento', $idSeguimiento)
            ->where('id_seguido', Auth::id())
            ->delete();

        return back()->with('success', 'Solicitud rechazada');
    }
}
