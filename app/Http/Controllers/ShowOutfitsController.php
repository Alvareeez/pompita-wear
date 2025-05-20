<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;

class ShowOutfitsController extends Controller
{
    protected $perPage = 15;

    public function index(Request $request)
    {
        // Base query con relaciones
        $query = Outfit::with(['prendas', 'usuario']);

        // Aplica filtros si vienen por GET
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%'.$request->nombre.'%');
        }
        if ($request->filled('creador')) {
            $query->whereHas('usuario', fn($q) => 
                $q->where('nombre', 'like', '%'.$request->creador.'%')
            );
        }

        // Pagina
        $outfits = $query
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage)
            ->appends($request->only(['nombre','creador']));

        // Calcula precio_total y ordena prendas
        $outfits->getCollection()->transform(function($outfit) {
            $outfit->prendas = $outfit->prendas
                ->sortBy('id_tipoPrenda')
                ->values();
            $outfit->precio_total = $outfit->prendas->sum('precio');
            return $outfit;
        });

        // Si es AJAX, devolvemos solo el partial renderizado
        if ($request->ajax()) {
            return view('outfit.partials.outfits_list', compact('outfits'))->render();
        }

        // Si no, la vista completa
        return view('outfit.outfits', compact('outfits'));
    }
}
