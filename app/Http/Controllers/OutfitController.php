<?php
 namespace App\Http\Controllers;
 
 use App\Models\Prenda;  // Asegúrate de importar el modelo Prenda
 use Illuminate\Http\Request;
 
 class OutfitController extends Controller
 {
     public function index()
     {
         // Recupera las prendas de cada tipo
         $prendasCabeza = Prenda::where('id_tipoPrenda', 1)->get();  // Asumiendo que '1' es el tipo para cabeza
         $prendasTorso = Prenda::where('id_tipoPrenda', 2)->get();   // Asumiendo que '2' es el tipo para torso
         $prendasPiernas = Prenda::where('id_tipoPrenda', 3)->get(); // Asumiendo que '3' es el tipo para piernas
         $prendasPies = Prenda::where('id_tipoPrenda', 4)->get();    // Asumiendo que '4' es el tipo para pies
 
         // Pasar las variables a la vista
         return view('outfit.index', compact('prendasCabeza', 'prendasTorso', 'prendasPiernas', 'prendasPies'));
     }
 }