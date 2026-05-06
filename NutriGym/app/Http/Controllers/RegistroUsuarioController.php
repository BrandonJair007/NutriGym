<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegistroUsuarioController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Reglas de validación
            'nombre' => ['required', 'string', 'max:255', 'unique:usuarios,nombre'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'fecha_nacimiento' => ['required', 'date', 'before:-18 years'],
            'contrasena' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            // Mensajes de campos obligatorios
            'nombre.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'contrasena.required' => 'El campo contraseña es obligatorio.',

            // Mensajes de unicidad
            'nombre.unique' => 'Este nombre de usuario ya está en uso.',
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',

            // Mensajes de lógica y formato
            'fecha_nacimiento.before' => 'Debes tener al menos 18 años para poder registrarte.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
            'contrasena.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);
        
        try {
            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'fecha_registro' => now(),
                'contrasena' => Hash::make($request->contrasena),
                'id_rol' => 4, // Rol por defecto (Cliente/Paciente)
            ]);

            Auth::login($usuario);

            // Redirección al panel del usuario
            return redirect('/usuario')->with('success', '¡Bienvenido a tu panel nutricional!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo crear el usuario. ' . $e->getMessage());
        }
    }
}