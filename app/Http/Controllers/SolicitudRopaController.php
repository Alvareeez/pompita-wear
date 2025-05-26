<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudRopa;
use Illuminate\Support\Facades\DB;

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
        // Validar los datos enviados con mensajes personalizados
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10|max:255',
            'id_tipoPrenda' => 'required|exists:tipo_prendas,id_tipoPrenda',
            'img_frontal' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_trasera' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'etiquetas' => 'required|array|min:1',
            'etiquetas.*' => 'exists:etiquetas,id_etiqueta',
            'colores' => 'required|array|min:1',
            'colores.*' => 'exists:colores,id_color',
            'estilos' => 'required|array|min:1',
            'estilos.*' => 'exists:estilos,id_estilo',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'id_tipoPrenda.required' => 'El campo tipo de prenda es obligatorio.',
            'id_tipoPrenda.exists' => 'El tipo de prenda seleccionado no es válido.',
            'img_frontal.required' => 'El campo imagen frontal es obligatorio.',
            'img_frontal.image' => 'El campo imagen frontal debe ser una imagen.',
            'img_frontal.mimes' => 'El campo imagen frontal debe ser un archivo de tipo: jpeg, png, jpg, gif.',
            'img_frontal.max' => 'El campo imagen frontal no debe superar los 2 MB.',
            'img_trasera.image' => 'El campo imagen trasera debe ser una imagen.',
            'img_trasera.mimes' => 'El campo imagen trasera debe ser un archivo de tipo: jpeg, png, jpg, gif.',
            'img_trasera.max' => 'El campo imagen trasera no debe superar los 2 MB.',
            'etiquetas.required' => 'Debes seleccionar al menos una etiqueta.',
            'etiquetas.array' => 'El campo etiquetas debe ser un arreglo.',
            'etiquetas.min' => 'Debes seleccionar al menos una etiqueta.',
            'etiquetas.*.exists' => 'Una de las etiquetas seleccionadas no es válida.',
            'colores.required' => 'Debes seleccionar al menos un color.',
            'colores.array' => 'El campo colores debe ser un arreglo.',
            'colores.min' => 'Debes seleccionar al menos un color.',
            'colores.*.exists' => 'Uno de los colores seleccionados no es válido.',
            'estilos.required' => 'Debes seleccionar al menos un estilo.',
            'estilos.array' => 'El campo estilos debe ser un arreglo.',
            'estilos.min' => 'Debes seleccionar al menos un estilo.',
            'estilos.*.exists' => 'Uno de los estilos seleccionados no es válido.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
        ]);

        // Iniciar una transacción
        DB::beginTransaction();

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

            // Sincronizar relaciones
            $solicitud->etiquetas()->sync($request->etiquetas);
            $solicitud->colores()->sync($request->colores);
            $solicitud->estilos()->sync($request->estilos);

            // Confirmar la transacción
            DB::commit();

            // Notificar al usuario que su solicitud fue enviada
            auth()->user()->notify(new \App\Notifications\SolicitudRopaNotification(
                "Tu solicitud de ropa '{$solicitud->nombre}' ha sido enviada y está pendiente de revisión."
            ));

            return redirect()->route('home')->with('success', 'Solicitud enviada correctamente.');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

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

            // Notificar al usuario que fue aceptada
            $solicitud->usuario->notify(new \App\Notifications\SolicitudRopaNotification(
                "¡Tu solicitud de ropa '{$solicitud->nombre}' ha sido aceptada y la prenda ha sido creada!"
            ));
        } elseif ($request->action === 'rechazar') {
            $solicitud->update(['estado' => 'rechazada']);

            // Notificar al usuario que fue rechazada
            $solicitud->usuario->notify(new \App\Notifications\SolicitudRopaNotification(
                "Tu solicitud de ropa '{$solicitud->nombre}' ha sido rechazada."
            ));
        }

        return redirect()->route('admin.solicitudes.index')->with('success', 'Solicitud actualizada correctamente.');
    }
    public function show(SolicitudRopa $solicitud)
    {
    return view('solicitudes_ropa.show', compact('solicitud'));
    }

}