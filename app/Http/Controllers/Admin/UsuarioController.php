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
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
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
        $roles = Rol::all();

        return view('admin.usuarios', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Rol::all(); // Carga los roles
        return view('Admin.crearusuarios', compact('roles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios',
                'password' => 'required|string|min:8',
                'id_rol' => 'required|exists:roles,id_rol',
            ]);

            Usuario::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'id_rol' => $request->id_rol,
            ]);

            DB::commit();
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear el usuario.']);
        }
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        return view('Admin.editarusuarios', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $usuario = Usuario::findOrFail($id);

            // Validar los datos enviados
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id . ',id_usuario', // Corregir la validación de unique
                'id_rol' => 'required|exists:roles,id_rol',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Obtener los datos enviados
            $data = $request->only(['nombre', 'email', 'id_rol']);

            // Si se proporciona una nueva contraseña, encriptarla y agregarla a los datos
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            // Actualizar el usuario
            $usuario->update($data);

            DB::commit();
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar el usuario.']);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            // 1) Seguimientos (pivot 'solicitudes')
            Solicitud::where('id_emisor', $id)
                     ->orWhere('id_receptor', $id)
                     ->delete();
    
            // 2) Chats: Mensajes y Conversaciones
            Mensaje::where('emisor_id', $id)->delete();
            Conversacion::where('user1_id', $id)
                        ->orWhere('user2_id', $id)
                        ->delete();
    
            // 3) Notificaciones
            DB::table('notifications')
                ->where('notifiable_type', Usuario::class)
                ->where('notifiable_id', $id)
                ->delete();
    
            // 4) Solicitudes de Ropa y pivotes asociados
            // 4.1 Identificar las solicitudes de ropa propias
            $solRopaIds = DB::table('solicitudes_ropa')
                            ->where('id_usuario', $id)
                            ->pluck('id');
            // 4.2 Pivote etiquetas
            DB::table('solicitud_etiqueta')
                ->whereIn('id_solicitud', $solRopaIds)
                ->delete();
            // 4.3 Pivote colores
            DB::table('solicitud_color')
                ->whereIn('id_solicitud', $solRopaIds)
                ->delete();
            // 4.4 Pivote estilos
            DB::table('solicitud_estilo')
                ->whereIn('id_solicitud', $solRopaIds)
                ->delete();
            // 4.5 Finalmente eliminar la solicitud de ropa
            DB::table('solicitudes_ropa')
                ->where('id_usuario', $id)
                ->delete();
    
            // 5) Prendas: comentarios, likes de comentarios, valoraciones, likes y favoritos
            // 5.1 Comentarios de prenda + likes
            $comentPrendaIds = DB::table('comentarios_prendas')
                                 ->where('id_usuario', $id)
                                 ->pluck('id_comentario');
            DB::table('likes_comentarios_prendas')
              ->whereIn('id_comentario', $comentPrendaIds)
              ->delete();
            ComentarioPrenda::where('id_usuario', $id)->delete();
    
            // 5.2 Valoraciones de prenda
            DB::table('valoraciones_prendas')
              ->where('id_usuario', $id)
              ->delete();
    
            // 5.3 Likes de prenda
            DB::table('likes_prendas')
              ->where('id_usuario', $id)
              ->delete();
    
            // 5.4 Favoritos de prenda
            DB::table('favoritos_prendas')
              ->where('id_usuario', $id)
              ->delete();
    
            // 6) Outfits: para cada outfit propio, eliminar todo lo suyo
            $misOutfits = Outfit::where('id_usuario', $id)
                                ->pluck('id_outfit');
            foreach ($misOutfits as $outfitId) {
                // 6.1 Comentarios de outfit + sus likes
                $comentOutIds = DB::table('comentarios_outfits')
                                  ->where('id_outfit', $outfitId)
                                  ->pluck('id_comentario');
                DB::table('likes_comentarios_outfits')
                  ->whereIn('id_comentario', $comentOutIds)
                  ->delete();
                DB::table('comentarios_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 6.2 Valoraciones de outfit
                DB::table('valoraciones_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 6.3 Likes de outfit
                DB::table('likes_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 6.4 Favoritos de outfit
                DB::table('favoritos_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 6.5 Relación prenda–outfit
                DB::table('outfit_prendas')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 6.6 Eliminar el outfit
                Outfit::where('id_outfit', $outfitId)->delete();
            }
    
            // 7) Por último, eliminar al propio usuario
            Usuario::where('id_usuario', $id)->delete();
        });
    
        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario y todos sus datos asociados eliminados correctamente.');
    }
    

    public function updateEstado(Request $request)
    {
        try {
            $usuario = Usuario::findOrFail($request->id_usuario); // Busca el usuario por ID
            $usuario->estado = $request->estado; // Actualiza el estado
            $usuario->save(); // Guarda los cambios en la base de datos

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }
}
