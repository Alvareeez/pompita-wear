<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seguimiento;
use Illuminate\Support\Facades\Auth;

class SeguimientoController extends Controller
{
    // Enviar solicitud de seguimiento
    public function enviarSolicitud($idSeguido)
    {
        $user = Auth::user();

        // Verifica si ya existe una solicitud
        $existe = Seguimiento::where('id_seguidor', $user->id_usuario)
            ->where('id_seguido', $idSeguido)
            ->first();

        if ($existe) {
            return response()->json(['message' => 'Ya existe una solicitud o relación.'], 400);
        }

        Seguimiento::create([
            'id_seguidor' => $user->id_usuario,
            'id_seguido' => $idSeguido,
            'estado' => 'pendiente',
        ]);

        return response()->json(['message' => 'Solicitud enviada.']);
    }

    // Aceptar solicitud de seguimiento
    public function aceptarSolicitud($idSeguimiento)
    {
        $seguimiento = Seguimiento::findOrFail($idSeguimiento);

        if ($seguimiento->id_seguido != Auth::id()) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $seguimiento->estado = 'aceptado';
        $seguimiento->save();

        return response()->json(['message' => 'Solicitud aceptada.']);
    }

    // Rechazar solicitud de seguimiento
    public function rechazarSolicitud($idSeguimiento)
    {
        $seguimiento = Seguimiento::findOrFail($idSeguimiento);

        if ($seguimiento->id_seguido != Auth::id()) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $seguimiento->estado = 'rechazado';
        $seguimiento->save();

        return response()->json(['message' => 'Solicitud rechazada.']);
    }

    // Listar seguidores
    public function listarSeguidores()
    {
        $user = Auth::user();
        // Seguidores aceptados
        $seguidores = $user->seguidores()->wherePivot('estado', 'aceptado')->get();

        return view('seguidores', compact('seguidores'));
    }

    public function listarSeguidos()
    {
        $user = Auth::user();
        // Usuarios que sigo (aceptados)
        $seguidos = $user->seguidos()->wherePivot('estado', 'aceptado')->get();

        return view('seguidos', compact('seguidos'));
    }
    // SeguimientoController.php
    public function solicitudesPendientes()
    {
        $user = Auth::user();
        $solicitudes = Seguimiento::where('id_seguido', $user->id_usuario)
            ->where('estado', 'pendiente')
            ->with('seguidor')
            ->get();

        return view('solicitudes', compact('solicitudes'));
    }

    // Añade este nuevo método al controlador
    public function toggleFollow(Request $request, $idSeguido)
    {
        $user = Auth::user();
        
        // Verificar si ya existe una relación
        $seguimiento = Seguimiento::where('id_seguidor', $user->id_usuario)
                                 ->where('id_seguido', $idSeguido)
                                 ->first();
    
        if ($seguimiento) {
            if ($seguimiento->estado == 'aceptado') {
                // Dejar de seguir (eliminar relación)
                $seguimiento->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'unfollow',
                    'buttonText' => 'Seguir',
                    'buttonState' => '',
                    'message' => 'Has dejado de seguir a este usuario'
                ]);
            } else {
                // Si está pendiente o rechazado, actualizar a aceptado
                $seguimiento->estado = 'aceptado';
                $seguimiento->save();
                return response()->json([
                    'success' => true,
                    'action' => 'accept',
                    'buttonText' => 'Siguiendo',
                    'buttonState' => 'following',
                    'message' => 'Ahora estás siguiendo a este usuario'
                ]);
            }
        } else {
            // Crear nueva solicitud
            Seguimiento::create([
                'id_seguidor' => $user->id_usuario,
                'id_seguido' => $idSeguido,
                'estado' => 'pendiente'
            ]);
    
            return response()->json([
                'success' => true,
                'action' => 'request',
                'buttonText' => 'Pendiente',
                'buttonState' => 'pending',
                'message' => 'Solicitud de seguimiento enviada'
            ]);
        }
    }}
