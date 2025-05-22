<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etiqueta;
use App\Models\Prenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtiquetaController extends Controller
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
        $query = Etiqueta::query();

        if ($request->ajax()) {
            if ($request->filled('nombre')) {
                $query->where('nombre', 'like', '%' . $request->nombre . '%');
            }

            $etiquetas = $query->get();
            return view('admin.partials.tabla-etiquetas', compact('etiquetas'));
        }

        $etiquetas = $query->get();
        return view('admin.etiquetas', compact('etiquetas'));
    }
    
    

    public function create()
    {
        return view('Admin.crearetiqueta');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre' => 'required|string|max:50|unique:etiquetas',
            ]);

            Etiqueta::create($request->all());

            DB::commit();
            return redirect()->route('admin.etiquetas.index')->with('success', 'Etiqueta creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear la etiqueta.']);
        }
    }

    public function edit($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        return view('Admin.editaretiqueta', compact('etiqueta'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre' => 'required|string|max:50|unique:etiquetas,nombre,' . $id . ',id_etiqueta',
            ]);

            $etiqueta = Etiqueta::findOrFail($id);
            $etiqueta->update($request->all());

            DB::commit();
            return redirect()->route('admin.etiquetas.index')->with('success', 'Etiqueta actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar la etiqueta.']);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            // 1) Cargar la etiqueta
            $etiqueta = Etiqueta::findOrFail($id);

            // 1.1) Limpiar solicitudes de ropa vinculadas a esta etiqueta
            $solicitudesRopaIds = DB::table('solicitud_etiqueta')
                ->where('id_etiqueta', $id)
                ->pluck('id_solicitud');
            DB::table('solicitud_etiqueta')->where('id_etiqueta', $id)->delete();
            if ($solicitudesRopaIds->isNotEmpty()) {
                DB::table('solicitudes_ropa')->whereIn('id', $solicitudesRopaIds)->delete();
            }

            // 2) Obtener todas las prendas vinculadas a esta etiqueta
            $prendaIds = DB::table('prenda_etiquetas')
                           ->where('id_etiqueta', $id)
                           ->pluck('id_prenda');

            foreach ($prendaIds as $prendaId) {
                $prenda      = \App\Models\Prenda::findOrFail($prendaId);
                $tagsCount   = $prenda->etiquetas()->count();

                if ($tagsCount > 1) {
                    // 2.1) Si tiene otras etiquetas, sólo quitamos el pivote
                    DB::table('prenda_etiquetas')
                      ->where('id_prenda', $prendaId)
                      ->where('id_etiqueta', $id)
                      ->delete();

                } else {
                    // 2.2) Si era su única etiqueta, eliminamos TODO lo asociado a la prenda

                    // --- Outfits que la contienen ---
                    $outfitIds = DB::table('outfit_prendas')
                                   ->where('id_prenda', $prendaId)
                                   ->pluck('id_outfit');
                    foreach ($outfitIds as $outfitId) {
                        // Comentarios de outfit + likes de comentarios
                        $comentOutIds = DB::table('comentarios_outfits')
                                          ->where('id_outfit', $outfitId)
                                          ->pluck('id_comentario');
                        DB::table('likes_comentarios_outfits')->whereIn('id_comentario', $comentOutIds)->delete();
                        DB::table('comentarios_outfits')->where('id_outfit', $outfitId)->delete();

                        // Valoraciones, likes y favoritos de outfit
                        DB::table('valoraciones_outfits')->where('id_outfit', $outfitId)->delete();
                        DB::table('likes_outfits')->where('id_outfit', $outfitId)->delete();
                        DB::table('favoritos_outfits')->where('id_outfit', $outfitId)->delete();

                        // Desvincular prenda–outfit y eliminar outfit
                        DB::table('outfit_prendas')->where('id_outfit', $outfitId)->delete();
                        DB::table('outfits')->where('id_outfit', $outfitId)->delete();
                    }

                    // --- Comentarios de prenda + likes ---
                    $comentPrIds = DB::table('comentarios_prendas')
                                     ->where('id_prenda', $prendaId)
                                     ->pluck('id_comentario');
                    DB::table('likes_comentarios_prendas')->whereIn('id_comentario', $comentPrIds)->delete();
                    DB::table('comentarios_prendas')->where('id_prenda', $prendaId)->delete();

                    // --- Valoraciones, likes y favoritos de prenda ---
                    DB::table('valoraciones_prendas')->where('id_prenda', $prendaId)->delete();
                    DB::table('likes_prendas')->where('id_prenda', $prendaId)->delete();
                    DB::table('favoritos_prendas')->where('id_prenda', $prendaId)->delete();

                    // --- Desvincular colores, estilos y etiquetas ---
                    DB::table('prenda_colores')->where('id_prenda', $prendaId)->delete();
                    DB::table('prenda_estilos')->where('id_prenda', $prendaId)->delete();
                    DB::table('prenda_etiquetas')->where('id_prenda', $prendaId)->delete();

                    // --- Finalmente eliminar la prenda ---
                    DB::table('prendas')->where('id_prenda', $prendaId)->delete();
                }
            }

            // 3) Eliminar la propia etiqueta
            $etiqueta->delete();
        });

        return redirect()
            ->route('admin.etiquetas.index')
            ->with('success', 'Etiqueta eliminada correctamente. Prendas únicas y sus outfits asociados también borrados.');
    }
    
}