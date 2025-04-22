<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::all();
        return view('Admin.etiquetas', compact('etiquetas'));
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
        DB::beginTransaction();

        try {
            $etiqueta = Etiqueta::findOrFail($id);
            $etiqueta->delete();

            DB::commit();
            return redirect()->route('admin.etiquetas.index')->with('success', 'Etiqueta eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al eliminar la etiqueta.']);
        }
    }
}