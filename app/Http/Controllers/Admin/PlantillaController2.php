<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plantilla;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;   


class PlantillaController2 extends Controller
{
    /**
     * Mostrar la lista de plantillas.
     */
    public function index(Request $request)
    {
        $query = Plantilla::with(['empresa', 'programador']);

        // Filtros dinámicos
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('empresa')) {
            $query->whereHas('empresa', function ($q) use ($request) {
                $q->where('razon_social', 'like', '%' . $request->empresa . '%');
            });
        }

        $plantillas = $query->get();

        // Si es una solicitud AJAX, devolver solo la tabla
        if ($request->ajax()) {
            return view('admin.plantillas.partials.tabla-plantillas', compact('plantillas'))->render();
        }

        return view('admin.plantillas.index', compact('plantillas'));
    }

    /**
     * Mostrar el formulario para crear una nueva plantilla.
     */
    public function create()
    {
        $empresas = Empresa::all();
        $programadores = Usuario::where('id_rol', 5)->get(); // Rol 5 = Programador
        return view('admin.plantillas.create', compact('empresas', 'programadores'));
    }

    /**
     * Guardar una nueva plantilla en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'programador_id' => 'nullable|exists:usuarios,id_usuario',
            'slug' => 'required|unique:plantillas,slug',
            'nombre' => 'required|string|max:191',
            'foto' => 'nullable|image|max:2048',
            'color_primario' => 'nullable|string|max:191',
            'color_secundario' => 'nullable|string|max:191',
            'color_terciario' => 'nullable|string|max:191',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('plantillas', 'public');
        }

        Plantilla::create($data);

        return redirect()->route('admin.plantillas.index')->with('success', 'Plantilla creada con éxito.');
    }

    /**
     * Mostrar el formulario para editar una plantilla existente.
     */
    public function edit($id)
    {
        $plantilla = Plantilla::findOrFail($id);
        $empresas = Empresa::all();
        $programadores = Usuario::where('id_rol', 5)->get(); // Rol 5 = Programador
        return view('admin.plantillas.edit', compact('plantilla', 'empresas', 'programadores'));
    }

    /**
     * Actualizar una plantilla existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $plantilla = Plantilla::findOrFail($id);

        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'programador_id' => 'nullable|exists:usuarios,id_usuario',
            'slug' => 'required|unique:plantillas,slug,' . $plantilla->id,
            'nombre' => 'required|string|max:191',
            'foto' => 'nullable|image|max:2048',
            'color_primario' => 'nullable|string|max:191',
            'color_secundario' => 'nullable|string|max:191',
            'color_terciario' => 'nullable|string|max:191',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('plantillas', 'public');
        }

        DB::transaction(function () use ($plantilla, $data) {
            $plantilla->update($data);
        });

        return redirect()->route('admin.plantillas.index')->with('success', 'Plantilla actualizada con éxito.');
    }

    /**
     * Eliminar una plantilla de la base de datos.
     */
    public function destroy($id)
    {
        $plantilla = Plantilla::findOrFail($id);

        DB::transaction(function () use ($plantilla) {
            $plantilla->delete();
        });

        return redirect()->route('admin.plantillas.index')->with('success', 'Plantilla eliminada con éxito.');
    }
}