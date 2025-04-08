<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etiqueta;
use Illuminate\Http\Request;

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
        $request->validate([
            'nombre' => 'required|string|max:50|unique:etiquetas',
        ]);

        Etiqueta::create($request->all());
        return redirect()->route('admin.etiquetas.index')->with('success', 'Etiqueta creada correctamente.');
    }

    public function edit($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        return view('Admin.editaretiqueta', compact('etiqueta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:etiquetas,nombre,' . $id . ',id_etiqueta',
        ]);

        $etiqueta = Etiqueta::findOrFail($id);
        $etiqueta->update($request->all());
        return redirect()->route('admin.etiquetas.index')->with('success', 'Etiqueta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        $etiqueta->delete();
        return redirect()->route('admin.etiquetas.index')->with('success', 'Etiqueta eliminada correctamente.');
    }
}