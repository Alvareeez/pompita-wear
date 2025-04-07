<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get(); // Carga los usuarios con sus roles
        return view('Admin.usuarios', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all(); // Carga los roles
        return view('Admin.crearusuarios', compact('roles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción

        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios',
                'password' => 'required|string|min:8',
                'id_rol' => 'required|exists:roles,id_rol',
            ]);

            Usuario::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'id_rol' => $request->id_rol,
            ]);

            DB::commit(); // Confirma la transacción
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return back()->withErrors(['error' => 'Ocurrió un error al crear el usuario.']);
        }
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        return view('Admin.editarusuarios', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $usuario = Usuario::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id_usuario,
                'id_rol' => 'required|exists:roles,id',
            ]);

            $usuario->update([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'id_rol' => $request->id_rol,
            ]);

            DB::commit();
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar el usuario.']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();

            DB::commit();
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al eliminar el usuario.']);
        }
    }
}
