<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('usuarios.id_rol', '!=', 1) 
            ->select(
                'usuarios.*',
                'roles.nombre_rol as nombre_rol'
            )
            ->get();

        $roles_disponibles = DB::table('roles')->get();

        return view('ui_dashboard.admin', compact('usuarios', 'roles_disponibles'));
    }

    public function actualizarRol(Request $request, $id)
    {
        $request->validate([
            'id_rol' => 'required|integer|exists:roles,id'
        ]);

        DB::table('usuarios')
            ->where('id', $id)
            ->update(['id_rol' => $request->id_rol]);

        return back()->with('success', 'El rol del usuario ha sido actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:usuarios,nombre',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed', 
            'fecha_nacimiento' => 'required|date|before:-18 years', 
            'id_rol' => 'required|integer|exists:roles,id'
        ], [
            'nombre.unique' => 'Este nombre de usuario ya está en uso.',
            'fecha_nacimiento.before' => 'El usuario debe ser mayor de 18 años.',
        ]);

        DB::table('usuarios')->insert([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password), 
            'id_rol' => $request->id_rol,
            'fecha_registro' => now(), 
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        return back()->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:usuarios,nombre,' . $id,
            'email' => 'required|email|unique:usuarios,email,' . $id, 
            'id_rol' => 'required|integer|exists:roles,id'
        ], [
            'nombre.unique' => 'Este nombre de usuario ya está en uso.',
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.'
        ]);

        $datosUpdate = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'id_rol' => $request->id_rol,
        ];

        if ($request->filled('password')) {
            $datosUpdate['contrasena'] = Hash::make($request->password);
        }

        DB::table('usuarios')
            ->where('id', $id)
            ->update($datosUpdate);

        return back()->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        if ($id == 1) { 
            return back()->with('error', 'No puedes eliminar al administrador principal.');
        }

        DB::table('usuarios')->where('id', $id)->delete();

        return back()->with('success', 'Usuario eliminado permanentemente.');
    }
}