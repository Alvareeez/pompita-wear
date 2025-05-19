<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prenda;
use App\Models\TipoPrenda;
use App\Models\Estilo;
use App\Models\Etiqueta;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RopaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener estilos, colores y etiquetas para los filtros
        $estilos = Estilo::all();
        $colores = Color::all();
        $etiquetas = Etiqueta::all();

        // Query base
        $query = Prenda::with('tipo', 'estilos', 'etiquetas', 'colores');

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        // Filtro por descripción
        if ($request->filled('descripcion')) {
            $query->where('descripcion', 'LIKE', '%' . $request->descripcion . '%');
        }

        // Filtro por estilos
        if ($request->filled('estilos')) {
            $query->whereHas('estilos', function ($q) use ($request) {
                $q->where('estilos.id_estilo', $request->estilos); // Especificar la tabla
            });
        }

        // Filtro por etiquetas
        if ($request->filled('etiquetas')) {
            $query->whereHas('etiquetas', function ($q) use ($request) {
                $q->where('etiquetas.id_etiqueta', $request->etiquetas); // Especificar la tabla
            });
        }

        // Filtro por colores
        if ($request->filled('colores')) {
            $query->whereHas('colores', function ($q) use ($request) {
                $q->where('colores.id_color', $request->colores); // Especificar la tabla
            });
        }

        // Paginación
        $prendas = $query->paginate(5);

        // Si es una solicitud AJAX, devolver solo la tabla parcial
        if ($request->ajax()) {
            return view('admin.partials.partial_ropa', compact('prendas'));
        }

        // Retornar la vista completa
        return view('Admin.ropa', compact('prendas', 'estilos', 'colores', 'etiquetas'));
    }
    
    public function create()
    {
        $tipos = TipoPrenda::all();
        $estilos = Estilo::all();
        $etiquetas = Etiqueta::all();
        $colores = Color::all();
        return view('Admin.crearropa', compact('tipos', 'estilos', 'etiquetas', 'colores'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|min:10|max:255',
                'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
                'img_frontal' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img_trasera' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'estilos' => 'array|exists:estilos,id_estilo',
                'etiquetas' => 'array|exists:etiquetas,id_etiqueta',
                'colores' => 'array|exists:colores,id_color',
            ]);

            // Subir imágenes directamente a public/img/prendas
            $imgFrontalName = time() . '_frontal.' . $request->file('img_frontal')->getClientOriginalExtension();
            $request->file('img_frontal')->move(public_path('img/prendas'), $imgFrontalName);

            $imgTraseraName = time() . '_trasera.' . $request->file('img_trasera')->getClientOriginalExtension();
            $request->file('img_trasera')->move(public_path('img/prendas'), $imgTraseraName);

            // Crear la prenda
            $prenda = Prenda::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_tipoPrenda' => $request->id_tipoPrenda,
                'img_frontal' => $imgFrontalName, // Guardar solo el nombre del archivo
                'img_trasera' => $imgTraseraName, // Guardar solo el nombre del archivo
            ]);

            // Sincronizar relaciones
            $prenda->estilos()->sync($request->estilos);
            $prenda->etiquetas()->sync($request->etiquetas);
            $prenda->colores()->sync($request->colores);

            DB::commit();
            return redirect()->route('admin.ropa.index')->with('success', 'Prenda creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al crear la prenda.']);
        }
    }

    public function edit($id)
    {
        $prenda = Prenda::with(['estilos', 'etiquetas', 'colores'])->findOrFail($id);
        $tipos = TipoPrenda::all();
        $estilos = Estilo::all();
        $etiquetas = Etiqueta::all();
        $colores = Color::all();
        return view('Admin.editarropa', compact('prenda', 'tipos', 'estilos', 'etiquetas', 'colores'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $prenda = Prenda::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255', // Validar el campo nombre
                'descripcion' => 'required|string|max:255',
                'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
                'estilos' => 'array|exists:estilos,id_estilo',
                'etiquetas' => 'array|exists:etiquetas,id_etiqueta',
                'colores' => 'array|exists:colores,id_color',
            ]);

            // Actualizar la prenda
            $prenda->update($request->except(['estilos', 'etiquetas', 'colores']));

            // Sincronizar relaciones
            $prenda->estilos()->sync($request->estilos);
            $prenda->etiquetas()->sync($request->etiquetas);
            $prenda->colores()->sync($request->colores);

            DB::commit();
            return redirect()->route('admin.ropa.index')->with('success', 'Prenda actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar la prenda.']);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            // 1) Buscar la prenda
            $prenda = Prenda::findOrFail($id);
    
            // 2) Primero, para cada outfit que incluya esta prenda, eliminarlo por completo
            $outfitIds = DB::table('outfit_prendas')
                           ->where('id_prenda', $id)
                           ->pluck('id_outfit');
    
            foreach ($outfitIds as $outfitId) {
                // 2.1) Comentarios de outfit + sus likes
                $comentOutIds = DB::table('comentarios_outfits')
                                  ->where('id_outfit', $outfitId)
                                  ->pluck('id_comentario');
                DB::table('likes_comentarios_outfits')
                  ->whereIn('id_comentario', $comentOutIds)
                  ->delete();
                DB::table('comentarios_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 2.2) Valoraciones de outfit
                DB::table('valoraciones_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 2.3) Likes de outfit
                DB::table('likes_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 2.4) Favoritos de outfit
                DB::table('favoritos_outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 2.5) Desvincular todas las prendas de este outfit
                DB::table('outfit_prendas')
                  ->where('id_outfit', $outfitId)
                  ->delete();
    
                // 2.6) Eliminar el outfit
                DB::table('outfits')
                  ->where('id_outfit', $outfitId)
                  ->delete();
            }
    
            // 3) Ahora eliminar todo lo relacionado con la propia prenda:
    
            // 3.1) Comentarios de prenda + sus likes
            $comentPrendaIds = DB::table('comentarios_prendas')
                                 ->where('id_prenda', $id)
                                 ->pluck('id_comentario');
            DB::table('likes_comentarios_prendas')
              ->whereIn('id_comentario', $comentPrendaIds)
              ->delete();
            DB::table('comentarios_prendas')
              ->where('id_prenda', $id)
              ->delete();
    
            // 3.2) Valoraciones de prenda
            DB::table('valoraciones_prendas')
              ->where('id_prenda', $id)
              ->delete();
    
            // 3.3) Likes de prenda
            DB::table('likes_prendas')
              ->where('id_prenda', $id)
              ->delete();
    
            // 3.4) Favoritos de prenda
            DB::table('favoritos_prendas')
              ->where('id_prenda', $id)
              ->delete();
    
            // 3.5) Desvincular estilos, colores y etiquetas
            DB::table('prenda_estilos')
              ->where('id_prenda', $id)
              ->delete();
            DB::table('prenda_colores')
              ->where('id_prenda', $id)
              ->delete();
            DB::table('prenda_etiquetas')
              ->where('id_prenda', $id)
              ->delete();
    
            // 4) Finalmente, eliminar la propia prenda
            $prenda->delete();
        });
    
        return redirect()
            ->route('admin.ropa.index')
            ->with('success', 'Prenda (y todos los datos asociados) eliminados correctamente.');
    }
    

    public function descargarPDF(Request $request)
    {
        DB::beginTransaction();

        try {
            // Asegurarse de que 'prenda' sea un array
            $prendasSeleccionadas = $request->input('prenda', []);
            if (!is_array($prendasSeleccionadas)) {
                $prendasSeleccionadas = [$prendasSeleccionadas];
            }

            // Obtener las prendas seleccionadas
            $prendas = Prenda::with(['tipo', 'estilos', 'etiquetas', 'colores'])
                ->whereIn('id_prenda', $prendasSeleccionadas)
                ->get();

            if ($prendas->isEmpty()) {
                return back()->withErrors(['error' => 'No se seleccionaron prendas para generar el PDF.']);
            }

            // Generar el PDF
            $pdf = Pdf::loadView('Admin.pdf_ropa', compact('prendas'));

            DB::commit();
            return $pdf->download('ropa_seleccionada.pdf');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al generar el PDF: ' . $e->getMessage()]);
        }
    }
}