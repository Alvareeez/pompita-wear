<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estilo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {
            $estilo = Estilo::findOrFail($id);
            $estilo->delete();

            DB::commit();
            return redirect()->route('admin.estilos.index')->with('success', 'Estilo eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al eliminar el estilo.']);
        }
    }
}