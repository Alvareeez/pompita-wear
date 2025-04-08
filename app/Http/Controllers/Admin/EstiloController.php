<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estilo;
use Illuminate\Http\Request;

class EstiloController extends Controller
{
    public function index()
    {
        $estilos = Estilo::all();
        return view('Admin.estilos', compact('estilos'));
    }

    public function create()
    {
        return view('Admin.crearestilo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estilos',
        ]);

        Estilo::create($request->all());
        return redirect()->route('admin.estilos.index')->with('success', 'Estilo creado correctamente.');
    }

    public function edit($id)
    {
        $estilo = Estilo::findOrFail($id);
        return view('Admin.editarestilo', compact('estilo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estilos,nombre,' . $id . ',id_estilo',
        ]);

        $estilo = Estilo::findOrFail($id);
        $estilo->update($request->all());
        return redirect()->route('admin.estilos.index')->with('success', 'Estilo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $estilo = Estilo::findOrFail($id);
        $estilo->delete();
        return redirect()->route('admin.estilos.index')->with('success', 'Estilo eliminado correctamente.');
    }
}