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
    public function index()
    {
        $prendas = Prenda::with('tipo')->get(); // Carga las prendas con su tipo
        return view('Admin.ropa', compact('prendas'));
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
                'descripcion' => 'required|string|min:10|max:255',
                'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
                'precio' => 'required|numeric|min:0',
                'img_frontal' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'img_trasera' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'estilos' => 'array|exists:estilos,id_estilo',
                'etiquetas' => 'array|exists:etiquetas,id_etiqueta',
                'colores' => 'array|exists:colores,id_color',
            ]);

            // Subir imágenes
            $imgFrontalPath = $request->file('img_frontal')->store('img/prendas', 'public');
            $imgTraseraPath = $request->file('img_trasera')->store('img/prendas', 'public');

            $prenda = Prenda::create([
                'descripcion' => $request->descripcion,
                'id_tipoPrenda' => $request->id_tipoPrenda,
                'precio' => $request->precio,
                'img_frontal' => $imgFrontalPath,
                'img_trasera' => $imgTraseraPath,
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
                'descripcion' => 'required|string|max:255',
                'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
                'precio' => 'required|numeric|min:0',
                'estilos' => 'array|exists:estilos,id_estilo',
                'etiquetas' => 'array|exists:etiquetas,id_etiqueta',
                'colores' => 'array|exists:colores,id_color',
            ]);

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
        DB::beginTransaction();

        try {
            $prenda = Prenda::findOrFail($id);
            $prenda->delete();

            DB::commit();
            return redirect()->route('admin.ropa.index')->with('success', 'Prenda eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al eliminar la prenda.']);
        }
    }

    // Función para generar el PDF
    public function descargarPDF(Request $request)
    {
        DB::beginTransaction();

        try {
            // Obtener las prendas seleccionadas
            $prendas = Prenda::whereIn('id_prenda', $request->prendas)->get();

            // Generar el PDF
            $pdf = Pdf::loadView('Admin.pdf_ropa', compact('prendas'));

            DB::commit();
            // Descargar el PDF
            return $pdf->download('ropa_seleccionada.pdf');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al generar el PDF.']);
        }
    }
}