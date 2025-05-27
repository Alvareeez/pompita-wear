<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Solicitud;        
use App\Models\Conversacion;     
use App\Models\Mensaje;          
use App\Models\ComentarioPrenda;
use App\Models\ComentarioOutfit;
use App\Models\Outfit;
use App\Models\LikeComentarioPrenda;
use App\Models\LikeComentarioOutfit;
use App\Models\ValoracionPrenda;
use App\Models\ValoracionOutfit;
use App\Models\LikePrenda;
use App\Models\LikeOutfit;
use App\Models\FavoritoPrenda;
use App\Models\FavoritoOutfit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Sólo admin (id_rol === 1) puede acceder; si no, aborta con 403
        abort_unless(
            Auth::check() && Auth::user()->id_rol === 1,
            403,
            'Acceso denegado'
        );
    }

    public function index(Request $request)
    {
        $query = Usuario::with('rol');

        if ($request->ajax()) {
            if ($request->filled('nombre')) {
                $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
            }

            if ($request->filled('correo')) {
                $query->where('email', 'LIKE', '%' . $request->correo . '%');
            }

            if ($request->filled('rol')) {
                $query->whereHas('rol', function ($q) use ($request) {
                    $q->where('nombre', $request->rol);
                });
            }

            $usuarios = $query->get();

            return view('admin.partials.tabla-usuarios', compact('usuarios'))->render();
        }

        $usuarios = $query->get();
        $roles    = Rol::all();

        return view('admin.usuarios', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('Admin.crearusuarios', compact('roles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre'   => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:usuarios',
                'password' => 'required|string|min:8',
                'id_rol'   => 'required|exists:roles,id_rol',
            ]);

            Usuario::create([
                'nombre'   => $request->nombre,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'id_rol'   => $request->id_rol,
            ]);

            DB::commit();
            return redirect()
                ->route('admin.usuarios.index')
                ->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear el usuario.']);
        }
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles   = Rol::all();
        return view('Admin.editarusuarios', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $usuario = Usuario::findOrFail($id);

            $request->validate([
                'nombre'                => 'required|string|max:255',
                'email'                 => 'required|string|email|max:255|unique:usuarios,email,' . $id . ',id_usuario',
                'id_rol'                => 'required|exists:roles,id_rol',
                'password'              => 'nullable|string|min:8|confirmed',
            ]);

            $data = $request->only(['nombre', 'email', 'id_rol']);

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $usuario->update($data);

            DB::commit();
            return redirect()
                ->route('admin.usuarios.index')
                ->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar el usuario.']);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            // 1) Verificar si el usuario es una empresa
            $usuario = Usuario::findOrFail($id);

            if ($usuario->id_rol === 3) { // 3 = Empresa
                // Eliminar datos relacionados con empresas
                DB::table('facturas')->where('empresa_id', $id)->delete();
                DB::table('plantillas')->where('empresa_id', $id)->delete();
                DB::table('solicitudes_destacado')->where('empresa_id', $id)->delete();
                DB::table('solicitudes_plantilla')->where('empresa_id', $id)->delete();
            }

            // 2) Solicitudes
            Solicitud::where('id_emisor', $id)
                     ->orWhere('id_receptor', $id)
                     ->delete();

            // 3) Chats
            Mensaje::where('emisor_id', $id)->delete();
            Conversacion::where('user1_id', $id)
                        ->orWhere('user2_id', $id)
                        ->delete();

            // 4) Notificaciones
            DB::table('notifications')
                ->where('notifiable_type', Usuario::class)
                ->where('notifiable_id', $id)
                ->delete();

            // 5) Solicitudes de ropa y pivotes
            $solRopaIds = DB::table('solicitudes_ropa')
                            ->where('id_usuario', $id)
                            ->pluck('id');
            DB::table('solicitud_etiqueta')->whereIn('id_solicitud', $solRopaIds)->delete();
            DB::table('solicitud_color')->whereIn('id_solicitud', $solRopaIds)->delete();
            DB::table('solicitud_estilo')->whereIn('id_solicitud', $solRopaIds)->delete();
            DB::table('solicitudes_ropa')->where('id_usuario', $id)->delete();

            // 6) Prendas: comentarios, likes, valoraciones, favoritos
            $comentPrendaIds = DB::table('comentarios_prendas')
                                 ->where('id_usuario', $id)
                                 ->pluck('id_comentario');
            DB::table('likes_comentarios_prendas')
              ->whereIn('id_comentario', $comentPrendaIds)
              ->delete();
            ComentarioPrenda::where('id_usuario', $id)->delete();
            DB::table('valoraciones_prendas')->where('id_usuario', $id)->delete();
            DB::table('likes_prendas')->where('id_usuario', $id)->delete();
            DB::table('favoritos_prendas')->where('id_usuario', $id)->delete();

            // 7) Outfits completos
            $misOutfits = Outfit::where('id_usuario', $id)->pluck('id_outfit');
            foreach ($misOutfits as $outfitId) {
                $comentOutIds = DB::table('comentarios_outfits')
                                  ->where('id_outfit', $outfitId)
                                  ->pluck('id_comentario');
                DB::table('likes_comentarios_outfits')
                  ->whereIn('id_comentario', $comentOutIds)
                  ->delete();
                DB::table('comentarios_outfits')->where('id_outfit', $outfitId)->delete();
                DB::table('valoraciones_outfits')->where('id_outfit', $outfitId)->delete();
                DB::table('likes_outfits')->where('id_outfit', $outfitId)->delete();
                DB::table('favoritos_outfits')->where('id_outfit', $outfitId)->delete();
                DB::table('outfit_prendas')->where('id_outfit', $outfitId)->delete();
                Outfit::where('id_outfit', $outfitId)->delete();
            }

            // 8) Borrar usuario
            Usuario::where('id_usuario', $id)->delete();
        });

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario y todos sus datos asociados eliminados correctamente.');
    }

    public function updateEstado(Request $request)
    {
        try {
            $usuario = Usuario::findOrFail($request->id_usuario);
            $usuario->estado = $request->estado;
            $usuario->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado.'
            ]);
        }
    }
}
