<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prenda;
use App\Models\TipoPrenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('Admin.crearropa', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
            'precio' => 'required|numeric|min:0',
        ]);

        Prenda::create($request->all());
        return redirect()->route('admin.ropa.index')->with('success', 'Prenda creada correctamente.');
    }

    public function edit($id)
    {
        $prenda = Prenda::findOrFail($id);
        $tipos = TipoPrenda::all();
        return view('Admin.editarropa', compact('prenda', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $prenda = Prenda::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
            'precio' => 'required|numeric|min:0',
        ]);

        $prenda->update($request->all());
        return redirect()->route('admin.ropa.index')->with('success', 'Prenda actualizada correctamente.');
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
}
