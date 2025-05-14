<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Muestra el perfil propio.
     */
    public function show()
    {
        $user = Auth::user();

        // Contadores: relaciones ya filtran status='aceptada'
        $numeroSeguidores = $user->seguidores()->count();
        $numeroSeguidos   = $user->siguiendo()->count();

        // Outfits y favoritos
        $outfitsPublicados = $user->outfits;
        $favorites         = $user->favoritosPrendas;

        // Solicitudes recibidas pendientes
        $pendientes = $user
            ->solicitudesRecibidas()
            ->where('status', 'pendiente')
            ->with('emisor')
            ->get();

        return view('perfil', compact(
            'user',
            'numeroSeguidores',
            'numeroSeguidos',
            'outfitsPublicados',
            'favorites',
            'pendientes'
        ));
    }

    /**
     * Acepta una solicitud pendiente (solo el receptor).
     */
    public function aceptar($id)
    {
        $sol = Solicitud::findOrFail($id);

        if ($sol->id_receptor !== Auth::id() || $sol->status !== 'pendiente') {
            return back()->with('error', 'No puedes aceptar esta solicitud.');
        }

        $sol->status = 'aceptada';
        $sol->save();

        return back()->with('success', 'Solicitud aceptada correctamente.');
    }

    /**
     * Rechaza (elimina) una solicitud pendiente.
     */
    public function rechazar($id)
    {
        $sol = Solicitud::findOrFail($id);

        if ($sol->id_receptor !== Auth::id()) {
            return back()->with('error', 'No puedes rechazar esta solicitud.');
        }

        $sol->delete();

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }

    /**
     * Actualiza nombre, contraseña, foto y privacidad.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombre'       => 'required|string|max:100',
            'password'     => 'nullable|confirmed|min:8',
            'foto_perfil'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_private'   => 'required|boolean',
        ]);

        // Estado anterior
        $oldPrivacy = $user->is_private;

        // Actualizar campos
        $user->nombre     = $request->nombre;
        $user->is_private = $request->is_private;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::disk('public')
                    ->delete(str_replace('storage/', '', $user->foto_perfil));
            }
            $path = $request->file('foto_perfil')->store('profile_pictures', 'public');
            $user->foto_perfil = 'storage/' . $path;
        }

        $user->save();

        // Si pasó de privado a público, aceptamos todas las solicitudes pendientes
        if ($oldPrivacy && ! $user->is_private) {
            Solicitud::where('id_receptor', $user->id_usuario)
                ->where('status', 'pendiente')
                ->update(['status' => 'aceptada']);
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Elimina la foto de perfil y devuelve la ruta por JSON.
     */
    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->foto_perfil) {
            Storage::disk('public')
                ->delete(str_replace('storage/', '', $user->foto_perfil));
            $user->foto_perfil = null;
            $user->save();
        }

        return response()->json([
            'success'       => true,
            'default_image' => asset('img/default-profile.png'),
        ]);
    }

    /**
     * Búsqueda AJAX de usuarios por nombre.
     */
    public function search(Request $request)
    {
        $q = $request->get('query', '');
        $users = Usuario::where('nombre', 'LIKE', "%{$q}%")
                        ->take(5)
                        ->get(['id_usuario', 'nombre', 'foto_perfil']);

        $users->transform(function($u) {
            $u->avatar = $u->foto_perfil && preg_match('/^https?:\/\//', $u->foto_perfil)
                        ? $u->foto_perfil
                        : ($u->foto_perfil
                            ? asset($u->foto_perfil)
                            : asset('img/default-profile.png'));
            return $u;
        });

        return response()->json($users);
    }

    /**
     * Muestra perfil público de otro usuario.
     */
    public function showPublicProfile($id)
    {
        $user = Usuario::with(['outfits'])->findOrFail($id);
        return view('cliente.perfil_publico', compact('user'));
    }

     /**
     * Quita de mis seguidores al usuario $id.
     */
    public function removeFollower($id)
    {
        $me = Auth::user();

        // Eliminamos la solicitud que ese usuario nos envió y que ya estaba aceptada
        Solicitud::where('id_emisor', $id)
                 ->where('id_receptor', $me->id_usuario)
                 ->delete();

        return back()->with('success', 'Seguidor eliminado correctamente.');
    }

    /**
     * Deja de seguir al usuario $id.
     */
    public function unfollow($id)
    {
        $me = Auth::user();

        // Eliminamos la solicitud que yo le envié
        Solicitud::where('id_emisor', $me->id_usuario)
                 ->where('id_receptor', $id)
                 ->delete();

        return back()->with('success', 'Has dejado de seguir al usuario.');
    }
}
