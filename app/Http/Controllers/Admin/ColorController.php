<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ColorController extends Controller
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
        $query = Color::query();

        if ($request->ajax()) {
            if ($request->filled('nombre')) {
                $query->where('nombre', 'like', '%' . $request->nombre . '%');
            }
            $colores = $query->get();
            return view('admin.partials.tabla-colores', compact('colores'));
        }

        $colores = $query->get();
        return view('admin.colores', compact('colores'));
    }

    public function create()
    {
        return view('admin.crearcolor');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:colores',
            ]);

            Color::create($request->all());

            DB::commit();
            return redirect()->route('admin.colores.index')->with('success', 'Color creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear el color.']);
        }
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.editarcolor', compact('color'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:colores,nombre,' . $id . ',id_color',
            ]);

            $color = Color::findOrFail($id);
            $color->update($request->all());

            DB::commit();
            return redirect()->route('admin.colores.index')->with('success', 'Color actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar el color.']);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            $color = Color::findOrFail($id);

            // 1) Limpiar solicitudes de ropa vinculadas a este color
            $solicitudesRopaIds = DB::table('solicitud_color')
                ->where('id_color', $id)
                ->pluck('id_solicitud');
            DB::table('solicitud_color')->where('id_color', $id)->delete();
            if ($solicitudesRopaIds->isNotEmpty()) {
                DB::table('solicitudes_ropa')->whereIn('id', $solicitudesRopaIds)->delete();
            }

            // 2) Obtener todas las prendas vinculadas a este color
            $prendaIds = DB::table('prenda_colores')
                           ->where('id_color', $id)
                           ->pluck('id_prenda');

            foreach ($prendaIds as $prendaId) {
                // Contar cuántos colores tiene la prenda
                $coloresCount = DB::table('prenda_colores')
                                  ->where('id_prenda', $prendaId)
                                  ->count();

                if ($coloresCount > 1) {
                    // Si tiene más de un color, solo desvinculamos el color
                    DB::table('prenda_colores')
                      ->where('id_prenda', $prendaId)
                      ->where('id_color', $id)
                      ->delete();
                } else {
                    // Si era su único color, eliminamos TODO lo asociado a la prenda

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

            // 3) Eliminar el propio color
            $color->delete();
        });

        return redirect()
            ->route('admin.colores.index')
            ->with('success', 'Color eliminado correctamente. Prendas únicas y sus outfits asociados también borrados.');
    }
}