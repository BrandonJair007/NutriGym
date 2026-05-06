<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUsuarioController extends Controller
{
    public function validacion(Request $request) : RedirectResponse {
        
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'contrasena' => ['required'],
        ]);

        $usuario = Usuario::where('email', $credenciales['email'])->first();

        if ($usuario && Hash::check($credenciales['contrasena'], $usuario->contrasena))
        {
            // Se elimina el parámetro $remember para evitar cookies persistentes
            Auth::login($usuario); 
            
            $request->session()->regenerate();

            $mensaje = '¡Bienvenido, ' . $usuario->nombre . '!';

            // Redirección por roles
            return match($usuario->id_rol) {
                1 => redirect()->intended('admin')->with('success', $mensaje),
                2 => redirect()->intended('nutriologo')->with('success', $mensaje),
                3 => redirect()->intended('entrenador')->with('success', $mensaje),
                4 => redirect()->intended('usuario')->with('success', $mensaje),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('email');
    }

    public function cerrar(Request $request): RedirectResponse
    {
        Auth::logout(); // Invalida la autenticación en el servidor

        $request->session()->invalidate(); // Destruye los datos de la sesión
        $request->session()->regenerateToken(); // Regenera el token CSRF por seguridad

        return redirect('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}