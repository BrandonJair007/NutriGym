<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Traemos a los usuarios con su rol actual (tu código original intacto)
        $usuarios = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('usuarios.id_rol', '!=', 1) // Excluimos al administrador principal (asumo que es el ID 1)
            ->select(
                'usuarios.*',
                'roles.nombre_rol as nombre_rol'
            )
            ->get();

        // 2. NUEVO: Traemos todos los roles disponibles para armar el menú desplegable en la vista
        $roles_disponibles = DB::table('roles')->get();

        // Enviamos ambas variables a tu vista actual
        return view('ui_dashboard.admin', compact('usuarios', 'roles_disponibles'));
    }

    // 3. NUEVO: La función que recibe el formulario para guardar el nuevo rol
    public function actualizarRol(Request $request, $id)
    {
        // Validamos que el rol enviado sea válido y exista en la tabla roles
        $request->validate([
            'id_rol' => 'required|integer|exists:roles,id'
        ]);

        // Actualizamos el registro en la base de datos
        DB::table('usuarios')
            ->where('id', $id)
            ->update(['id_rol' => $request->id_rol]);

        // Recargamos la página con un mensaje de éxito
        return back()->with('success', 'El rol del usuario ha sido actualizado correctamente.');
    }

    /**
     * Crea un nuevo usuario en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
            'id_rol' => 'required|integer|exists:roles,id'
        ]);

        DB::table('usuarios')->insert([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptamos la contraseña
            'id_rol' => $request->id_rol,
            'fecha_registro' => now(), // Asumiendo que tienes esta columna
            'fecha_nacimiento' => $request->fecha_nacimiento ?? '2000-01-01', // Valor por defecto si no lo envían
        ]);

        return back()->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Actualiza la información general de un usuario
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email', // Aquí se podría añadir validación para ignorar el email actual, pero lo mantendremos simple
            'id_rol' => 'required|integer|exists:roles,id'
        ]);

        $datosUpdate = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'id_rol' => $request->id_rol,
        ];

        // Si el admin escribió una nueva contraseña, la actualizamos
        if ($request->filled('password')) {
            $datosUpdate['password'] = Hash::make($request->password);
        }

        DB::table('usuarios')
            ->where('id', $id)
            ->update($datosUpdate);

        return back()->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario del sistema
     */
    public function destroy($id)
    {
        // Validación de seguridad para que el admin no se borre a sí mismo
        if ($id == 1) { // Asumiendo que el ID 1 es el Super Admin
            return back()->with('error', 'No puedes eliminar al administrador principal.');
        }

        DB::table('usuarios')->where('id', $id)->delete();

        return back()->with('success', 'Usuario eliminado permanentemente.');
    }


}