<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Exception;

class ChatIAController extends Controller
{
    public function index()
    {
        return view('ia.chat');
    }

    public function message(Request $request)
    {
        // Validamos que venga un arreglo de mensajes
        $request->validate([
            'history'       => 'required|array',
            'history.*.role'=> 'required|in:system,user,assistant',
            'history.*.content'=>'required|string',
        ]);

        try {
            // Enviamos todo el historial a OpenAI
            $response = OpenAI::chat()->create([
                'model'    => config('services.openai.model'),
                'messages' => $request->history,
            ]);

            $reply = $response->choices[0]->message->content;

            return response()->json(['reply' => $reply]);

        } catch (Exception $e) {
            Log::error("OpenAI error: " . $e->getMessage());
            return response()->json([
                'reply' => null,
                'error' => 'Hubo un problema al procesar tu petición',
            ], 500);
        }
    }
}
