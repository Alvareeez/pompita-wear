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
        $numeroSeguidores = $user->seguidores()->where('estado','aceptado')->count();
        $numeroSeguidos   = $user->seguidos()->where('estado','aceptado')->count();
        $outfitsPublicados= $user->outfits;
        $favorites        = $user->favoritosPrendas;
        return view('perfil',compact('user','numeroSeguidores','numeroSeguidos','outfitsPublicados','favorites'));
    }

    public function update(Request $request)
    {
        $user = Usuario::findOrFail(Auth::user()->id_usuario);
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'password'     => 'nullable|confirmed|min:8',
            'foto_perfil'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
}
