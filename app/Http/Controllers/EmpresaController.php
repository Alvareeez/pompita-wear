<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class EmpresaController extends Controller
{
    public function index()
    {
        // Traemos los planes para ofrecer
        $planes = Plan::all();

        return view('empresas.index', compact('planes'));
    }
}
