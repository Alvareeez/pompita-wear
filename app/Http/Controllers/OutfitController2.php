<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutfitController2 extends Controller
{
    /**
     * Muestra el calendario con los outfits.
     */
    public function calendario(Request $request)
    {
        $userId = Auth::id();

        // Obtener los outfits del usuario autenticado
        $outfits = Outfit::where('id_usuario', $userId)->get();

        // Formatear los datos para FullCalendar
        $events = $outfits->map(function ($outfit) {
            return [
                'title' => $outfit->nombre,
                'start' => $outfit->fecha,
                'outfitId' => $outfit->id_outfit,
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

        // Verificar si ya existe un outfit en la fecha seleccionada
        $existingOutfit = Outfit::where('fecha', $request->fecha)
            ->where('id_usuario', Auth::id())
            ->first();

        if ($existingOutfit) {
            // Eliminar la fecha del outfit existente
            $existingOutfit->fecha = null;
            $existingOutfit->save();
        }

        // Asignar la fecha al nuevo outfit
        $outfit->fecha = $request->fecha;
        $outfit->save();

        return redirect()->route('calendario')->with('success', 'Outfit añadido al calendario exitosamente.');
    }

    public function deleteOutfit(Request $request)
    {
        // Validar la fecha
        $request->validate([
            'fecha' => 'required|date',
        ]);

        // Buscar el outfit asignado a la fecha
        $outfit = Outfit::where('fecha', $request->fecha)
            ->where('id_usuario', Auth::id())
            ->first();

        if (!$outfit) {
            return redirect()->route('calendario')->withErrors(['error' => 'No hay ningún outfit asignado para esta fecha.']);
        }

        // Eliminar la fecha del outfit (sin eliminar el outfit en sí)
        $outfit->fecha = null;
        $outfit->save();

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