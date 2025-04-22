<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(Request $request)
{
    $query = Usuario::with('rol');

    if ($request->ajax()) {
        if ($request->filled('nombre')) {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        if ($request->filled('correo')) {
            $query->where('email', 'LIKE', '%' . $request->correo . '%');
        }

        if ($request->filled('rol')) {
            $query->whereHas('rol', function ($q) use ($request) {
                $q->where('nombre', $request->rol);
            });
        }

        $usuarios = $query->get();

        return view('admin.partials.tabla-usuarios', compact('usuarios'))->render();
    }

    $usuarios = $query->get();
    $roles = Rol::all();

    return view('admin.usuarios', compact('usuarios', 'roles'));
}


    public function create()
    {
        $roles = Rol::all(); // Carga los roles
        return view('Admin.crearusuarios', compact('roles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

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

            DB::commit();
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
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

            // Validar los datos enviados
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id . ',id_usuario', // Corregir la validación de unique
                'id_rol' => 'required|exists:roles,id_rol',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Obtener los datos enviados
            $data = $request->only(['nombre', 'email', 'id_rol']);

            // Si se proporciona una nueva contraseña, encriptarla y agregarla a los datos
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            // Actualizar el usuario
            $usuario->update($data);

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
