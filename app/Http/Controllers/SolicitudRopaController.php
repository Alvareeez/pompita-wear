<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudRopa;

class SolicitudRopaController extends Controller
{
    // Mostrar formulario para crear una solicitud
    public function create()
    {
        $tipos = \App\Models\TipoPrenda::all();
        $etiquetas = \App\Models\Etiqueta::all();
        $colores = \App\Models\Color::all();
        $estilos = \App\Models\Estilo::all();

        return view('cliente.solicitarropa', compact('tipos', 'etiquetas', 'colores', 'estilos'));
    }

    // Guardar una nueva solicitud
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10|max:255',
            'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
            'img_frontal' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_trasera' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id_etiqueta',
            'colores' => 'nullable|array',
            'colores.*' => 'exists:colores,id_color',
            'estilos' => 'nullable|array',
            'estilos.*' => 'exists:estilos,id_estilo',
        ]);

        try {
            // Subir imágenes
            $imgFrontalName = time() . '_frontal.' . $request->file('img_frontal')->getClientOriginalExtension();
            $request->file('img_frontal')->move(public_path('img/prendas'), $imgFrontalName);

            $imgTraseraName = null;
            if ($request->hasFile('img_trasera')) {
                $imgTraseraName = time() . '_trasera.' . $request->file('img_trasera')->getClientOriginalExtension();
                $request->file('img_trasera')->move(public_path('img/prendas'), $imgTraseraName);
            }

            // Crear la solicitud
            $solicitud = SolicitudRopa::create([
                'id_usuario' => auth()->id(),
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_tipoPrenda' => $request->id_tipoPrenda,
                'img_frontal' => $imgFrontalName,
                'img_trasera' => $imgTraseraName,
                'estado' => 'pendiente',
            ]);

            // Sincronizar relaciones (si existen)
            if ($request->has('etiquetas')) {
                $solicitud->etiquetas()->sync($request->etiquetas);
            }
            if ($request->has('colores')) {
                $solicitud->colores()->sync($request->colores);
            }
            if ($request->has('estilos')) {
                $solicitud->estilos()->sync($request->estilos);
            }

            return redirect()->route('home')->with('success', 'Solicitud enviada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al crear la solicitud: ' . $e->getMessage()]);
        }
    }

    // Mostrar solicitudes pendientes para el administrador
    public function index()
    {
        $solicitudes = SolicitudRopa::where('estado', 'pendiente')->with('tipoPrenda')->get();
        return view('admin.solicitudes', compact('solicitudes'));
    }

    // Actualizar el estado de una solicitud (aceptar o rechazar)
    public function update(Request $request, SolicitudRopa $solicitud)
    {
        // Verifica que el valor de "action" esté presente
        if ($request->has('action')) {
            if ($request->action === 'aceptar') {
                // Crear la prenda en la tabla de ropa
                $prenda = \App\Models\Prenda::create([
                    'id_tipoPrenda' => $solicitud->id_tipoPrenda,
                    'nombre' => $solicitud->nombre,
                    'descripcion' => $solicitud->descripcion,
                    'img_frontal' => $solicitud->img_frontal,
                    'img_trasera' => $solicitud->img_trasera,
                ]);

                // Sincronizar etiquetas, colores y estilos
                if ($solicitud->etiquetas) {
                    $prenda->etiquetas()->sync($solicitud->etiquetas->pluck('id_etiqueta')->toArray());
                }
                if ($solicitud->colores) {
                    $prenda->colores()->sync($solicitud->colores->pluck('id_color')->toArray());
                }
                if ($solicitud->estilos) {
                    $prenda->estilos()->sync($solicitud->estilos->pluck('id_estilo')->toArray());
                }

                // Actualizar el estado de la solicitud
                $solicitud->update(['estado' => 'aceptada']);
            } elseif ($request->action === 'rechazar') {
                $solicitud->update(['estado' => 'rechazada']);
            } else {
                return redirect()->back()->withErrors(['error' => 'Acción no válida.']);
            }

            // Redirigir con mensaje de éxito
            return redirect()->route('admin.solicitudes.index')->with('success', 'Solicitud actualizada correctamente.');
        }

        return redirect()->back()->withErrors(['error' => 'No se recibió ninguna acción.']);
    }
}