<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use App\Models\OutfitFecha; // Importar el modelo OutfitFecha
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OutfitNotification; // Importar la notificación

class OutfitController2 extends Controller
{
    /**
     * Muestra el calendario con los outfits.
     */
    public function calendario(Request $request)
    {
        $userId = Auth::id();

        // Obtener los outfits del usuario autenticado con sus fechas
        $outfits = OutfitFecha::whereHas('outfit', function ($query) use ($userId) {
            $query->where('id_usuario', $userId);
        })->get();

        // Formatear los datos para FullCalendar
        $events = $outfits->map(function ($outfitFecha) {
            return [
                'title' => $outfitFecha->outfit->nombre,
                'start' => $outfitFecha->fecha,
                'outfitId' => $outfitFecha->outfit_id,
            ];
        });

        return view('calendario', compact('events'));
    }

    /**
     * Muestra el formulario para añadir un outfit desde el calendario.
     */
    public function createFromCalendar(Request $request)
    {
        $fecha = $request->query('date'); // Obtener la fecha seleccionada
        $userId = Auth::id();

        // Obtener outfits creados por el usuario
        $misOutfits = Outfit::where('id_usuario', $userId)->get();

        // Obtener todos los outfits (si es necesario mostrar todos los outfits disponibles)
        $todosOutfits = Outfit::all();

        return view('outfit.create_from_calendar', compact('fecha', 'misOutfits', 'todosOutfits'));
    }

    /**
     * Guarda un outfit seleccionado en el calendario.
     */
    public function storeFromCalendar(Request $request)
    {
        // Validar los datos
        $request->validate([
            'fecha' => 'required|date',
            'outfit_usuario' => 'nullable|exists:outfits,id_outfit',
        ]);

        // Determinar qué outfit se seleccionó
        $outfitId = $request->outfit_usuario;

        if (!$outfitId) {
            return redirect()->back()->withErrors(['error' => 'Debes seleccionar un outfit.']);
        }

        // Verificar que el outfit pertenece al usuario autenticado
        $outfit = Outfit::where('id_outfit', $outfitId)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        // Verificar si ya existe un outfit asignado a la fecha
        $existingOutfit = OutfitFecha::where('fecha', $request->fecha)
            ->where('outfit_id', $outfitId)
            ->first();

        if ($existingOutfit) {
            return redirect()->back()->withErrors(['error' => 'Este outfit ya está asignado a esta fecha.']);
        }

        // Asignar el outfit a la fecha
        OutfitFecha::create([
            'outfit_id' => $outfitId,
            'fecha' => $request->fecha,
        ]);

        // Enviar notificación al usuario autenticado
        $user = Auth::user();
        $user->notify(new OutfitNotification("El outfit '{$outfit->nombre}' ha sido añadido al calendario para la fecha {$request->fecha}."));

        return redirect()->route('calendario')->with('success', 'Outfit añadido exitosamente.');
    }

    public function deleteOutfit(Request $request)
    {
        // Validar la fecha
        $request->validate([
            'fecha' => 'required|date',
        ]);

        // Buscar el outfit asignado a la fecha
        $outfitFecha = OutfitFecha::where('fecha', $request->fecha)
            ->whereHas('outfit', function ($query) {
                $query->where('id_usuario', Auth::id());
            })
            ->first();

        if (!$outfitFecha) {
            return redirect()->route('calendario')->withErrors(['error' => 'No hay ningún outfit asignado para esta fecha.']);
        }

        // Obtener el nombre del outfit antes de eliminarlo
        $outfitNombre = $outfitFecha->outfit->nombre;

        // Eliminar el registro de la tabla intermedia
        $outfitFecha->delete();

        // Enviar notificación al usuario autenticado
        $user = Auth::user();
        $user->notify(new OutfitNotification("El outfit '{$outfitNombre}' ha sido eliminado del calendario para la fecha {$request->fecha}."));

        return redirect()->route('calendario')->with('success', 'Outfit eliminado del calendario exitosamente.');
    }

    /**
     * Sustituye un outfit en el calendario.
     */
    public function replaceOutfit(Request $request)
    {
        $fecha = $request->query('date'); // Obtener la fecha seleccionada
        $userId = Auth::id();

        // Obtener outfits creados por el usuario
        $misOutfits = Outfit::where('id_usuario', $userId)->get();

        // Obtener todos los outfits (si es necesario mostrar todos los outfits disponibles)
        $todosOutfits = Outfit::all();

        // Buscar el outfit existente en la fecha seleccionada
        $existingOutfit = Outfit::where('fecha', $fecha)
            ->where('id_usuario', $userId)
            ->first();

        return view('outfit.replace_outfit', compact('fecha', 'misOutfits', 'todosOutfits', 'existingOutfit'));
    }
}
