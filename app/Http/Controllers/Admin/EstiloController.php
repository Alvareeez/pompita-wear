<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estilo;
use App\Models\Prenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class EstiloController extends Controller
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
        $query = Estilo::query();
    
        if ($request->ajax()) {
            if ($request->filled('nombre')) {
                $query->where('nombre', 'like', '%' . $request->nombre . '%');
            }
    
            $estilos = $query->get();
            return view('admin.partials.tabla-estilos', compact('estilos'));
        }
    
        $estilos = $query->get();
        return view('admin.estilos', compact('estilos'));
    }
    

    public function create()
    {
        return view('Admin.crearestilo');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:estilos',
            ]);

            Estilo::create($request->all());

            DB::commit();
            return redirect()->route('admin.estilos.index')->with('success', 'Estilo creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear el estilo.']);
        }
    }

    public function edit($id)
    {
        $estilo = Estilo::findOrFail($id);
        return view('Admin.editarestilo', compact('estilo'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:estilos,nombre,' . $id . ',id_estilo',
            ]);

            $estilo = Estilo::findOrFail($id);
            $estilo->update($request->all());

            DB::commit();
            return redirect()->route('admin.estilos.index')->with('success', 'Estilo actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar el estilo.']);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            // 1) Cargar el estilo a eliminar
            $estilo = Estilo::findOrFail($id);
    
            // 2) Limpiar solicitudes de ropa vinculadas a este estilo
            $solicitudesRopaIds = DB::table('solicitud_estilo')
                ->where('id_estilo', $id)
                ->pluck('id_solicitud');
            DB::table('solicitud_estilo')->where('id_estilo', $id)->delete();
            if ($solicitudesRopaIds->isNotEmpty()) {
                DB::table('solicitudes_ropa')->whereIn('id', $solicitudesRopaIds)->delete();
            }
    
            // 3) Para cada prenda que usaba este estilo:
            $prendaIds = DB::table('prenda_estilos')
                           ->where('id_estilo', $id)
                           ->pluck('id_prenda');
    
            foreach ($prendaIds as $prendaId) {
                $prenda     = Prenda::findOrFail($prendaId);
                $stylesCount = $prenda->estilos()->count();
    
                if ($stylesCount > 1) {
                    // 3.1) Si tiene otros estilos, sólo quitamos el pivote
                    DB::table('prenda_estilos')
                      ->where('id_prenda', $prendaId)
                      ->where('id_estilo', $id)
                      ->delete();
    
                } else {
                    // 3.2) Si era su único estilo, eliminamos la prenda y TODO lo asociado…
    
                    // 3.2.1) Borrar outfits que la contienen:
                    $outfitIds = DB::table('outfit_prendas')
                                   ->where('id_prenda', $prendaId)
                                   ->pluck('id_outfit');
                    foreach ($outfitIds as $outfitId) {
                        // a) Comentarios de outfit + likes de comentarios
                        $comentOutIds = DB::table('comentarios_outfits')
                                          ->where('id_outfit', $outfitId)
                                          ->pluck('id_comentario');
                        DB::table('likes_comentarios_outfits')->whereIn('id_comentario', $comentOutIds)->delete();
                        DB::table('comentarios_outfits')->where('id_outfit', $outfitId)->delete();
    
                        // b) Valoraciones de outfit
                        DB::table('valoraciones_outfits')->where('id_outfit', $outfitId)->delete();
    
                        // c) Likes de outfit
                        DB::table('likes_outfits')->where('id_outfit', $outfitId)->delete();
    
                        // d) Favoritos de outfit
                        DB::table('favoritos_outfits')->where('id_outfit', $outfitId)->delete();
    
                        // e) Pivots outfit_prendas (por si queda algo)
                        DB::table('outfit_prendas')->where('id_outfit', $outfitId)->delete();
    
                        // f) Eliminar el outfit
                        DB::table('outfits')->where('id_outfit', $outfitId)->delete();
                    }
    
                    // 3.2.2) Comentarios de prenda + likes
                    $comentPrIds = DB::table('comentarios_prendas')
                                     ->where('id_prenda', $prendaId)
                                     ->pluck('id_comentario');
                    DB::table('likes_comentarios_prendas')->whereIn('id_comentario', $comentPrIds)->delete();
                    DB::table('comentarios_prendas')->where('id_prenda', $prendaId)->delete();
    
                    // 3.2.3) Valoraciones de prenda
                    DB::table('valoraciones_prendas')->where('id_prenda', $prendaId)->delete();
    
                    // 3.2.4) Likes de prenda
                    DB::table('likes_prendas')->where('id_prenda', $prendaId)->delete();
    
                    // 3.2.5) Favoritos de prenda
                    DB::table('favoritos_prendas')->where('id_prenda', $prendaId)->delete();
    
                    // 3.2.6) Colores y etiquetas
                    DB::table('prenda_colores')->where('id_prenda', $prendaId)->delete();
                    DB::table('prenda_etiquetas')->where('id_prenda', $prendaId)->delete();
    
                    // 3.2.7) Pivote prenda_estilos
                    DB::table('prenda_estilos')->where('id_prenda', $prendaId)->delete();
    
                    // 3.2.8) Finalmente, eliminar la prenda
                    DB::table('prendas')->where('id_prenda', $prendaId)->delete();
                }
            }
    
            // 4) Eliminar el propio estilo
            $estilo->delete();
        });
    
        return redirect()
            ->route('admin.estilos.index')
            ->with('success', 'Estilo eliminado correctamente. Prendas únicas y sus outfits asociados también borrados.');
    }
                
}