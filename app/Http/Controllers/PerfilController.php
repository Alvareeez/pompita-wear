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
        $user = $id_usuario
            ? Usuario::findOrFail($id_usuario)
            : Auth::user();
        $numeroSeguidores  = $user->seguidores()->where('estado','aceptado')->count();
        $numeroSeguidos    = $user->seguidos()->where('estado','aceptado')->count();
        $outfitsPublicados = $user->outfits;
        $favorites         = $user->favoritosPrendas;
        return view('perfil',compact('user','numeroSeguidores','numeroSeguidos','outfitsPublicados','favorites'));
    }

    public function showPublicProfile($id)
    {
        $user = Usuario::with('outfits')->findOrFail($id);
        return view('cliente.perfil_publico',compact('user'));
    }

    public function update(Request $request)
    {
        $user = Usuario::findOrFail(Auth::user()->id_usuario);
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'password'    => 'nullable|confirmed|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user->nombre = $request->nombre;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        if($request->hasFile('foto_perfil')){
            if($user->foto_perfil){
                Storage::disk('public')->delete(str_replace('storage/','',$user->foto_perfil));
            }
            $path = $request->file('foto_perfil')->store('profile_pictures','public');
            $user->foto_perfil = 'storage/'.$path;
        }
        $user->save();
        return redirect()->back()->with('success','Perfil actualizado correctamente.');
    }

    public function deleteProfilePicture()
    {
        $user = Usuario::findOrFail(Auth::user()->id_usuario);
        if($user->foto_perfil){
            Storage::disk('public')->delete(str_replace('storage/','',$user->foto_perfil));
            $user->foto_perfil = null;
            $user->save();
        }
        return response()->json([
            'success'       => true,
            'default_image' => asset('img/default-profile.png')
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->get('query','');
        $users = Usuario::where('nombre','LIKE',"%{$q}%")
                        ->take(5)
                        ->get(['id_usuario','nombre','foto_perfil']);
        $users->transform(function($u){
            if($u->foto_perfil && preg_match('/^https?:\\/\\//',$u->foto_perfil)){
                $u->avatar = $u->foto_perfil;
            } elseif($u->foto_perfil){
                $u->avatar = asset($u->foto_perfil);
            } else {
                $u->avatar = asset('img/default-profile.png');
            }
            return $u;
        });
        return response()->json($users);
    }

    public function follow(Request $request)
    {
        $followerId = Auth::id();
        $followedId = $request->id_seguido;
        if($followerId==$followedId){
            return response()->json(['error'=>'No puedes seguirte a ti mismo'],400);
        }
        $existing = DB::table('seguidores')
            ->where('id_seguidor',$followerId)
            ->where('id_seguido',$followedId)
            ->exists();
        if($existing){
            return response()->json(['error'=>'Ya has enviado una solicitud'],400);
        }
        DB::table('seguidores')->insert([
            'id_seguidor'=>$followerId,
            'id_seguido'=>$followedId,
            'estado'=>'pendiente',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        return response()->json(['success'=>true,'message'=>'Solicitud enviada']);
    }

    public function acceptFollow(Request $request)
    {
        $followedId = Auth::id();
        $followerId = $request->id_seguidor;
        $updated = DB::table('seguidores')
            ->where('id_seguidor',$followerId)
            ->where('id_seguido',$followedId)
            ->update(['estado'=>'aceptado']);
        if($updated){
            return response()->json(['success'=>true]);
        }
        return response()->json(['error'=>'Solicitud no encontrada'],404);
    }

    public function rejectFollow(Request $request)
    {
        $followedId = Auth::id();
        $followerId = $request->id_seguidor;
        $deleted = DB::table('seguidores')
            ->where('id_seguidor',$followerId)
            ->where('id_seguido',$followedId)
            ->delete();
        if($deleted){
            return response()->json(['success'=>true]);
        }
        return response()->json(['error'=>'Solicitud no encontrada'],404);
    }

    public function solicitudesPendientes()
    {
        $solicitudes = DB::table('seguidores')
            ->join('usuarios','seguidores.id_seguidor','=','usuarios.id_usuario')
            ->where('seguidores.id_seguido',Auth::id())
            ->where('seguidores.estado','pendiente')
            ->select('usuarios.*','seguidores.id_seguimiento')
            ->get();
        return view('solicitudes',compact('solicitudes'));
    }

    public function aceptarSolicitud($idSeguimiento)
    {
        DB::table('seguidores')
            ->where('id_seguimiento',$idSeguimiento)
            ->where('id_seguido',Auth::id())
            ->update(['estado'=>'aceptado']);
        return back()->with('success','Solicitud aceptada correctamente');
    }

    public function rechazarSolicitud($idSeguimiento)
    {
        DB::table('seguidores')
            ->where('id_seguimiento',$idSeguimiento)
            ->where('id_seguido',Auth::id())
            ->delete();
        return back()->with('success','Solicitud rechazada');
    }
}
