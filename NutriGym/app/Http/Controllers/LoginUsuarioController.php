<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LoginUsuarioController extends Controller
{
    // Manejo de login para los usuarios 
    public function validacion(Request $request) : RedirectResponse {
        
        // 1. Validamos las credenciales de ingreso 
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'contrasena' => ['required'],
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        // 2. Capturamos si el usuario marcó "Recuérdame"
        $remember = $request->has('remember');

        // 3. Búsqueda del usuario por email 
        $usuario = Usuario::where('email', $credenciales['email'])->first();

        // 4. Verificar contraseña y email 
        if ($usuario && Hash::check($credenciales['contrasena'], $usuario->contrasena))
        {
            // Iniciamos sesión pasando el parámetro de persistencia ($remember)
            Auth::login($usuario, $remember);
            
            // Regenerar la sesión por seguridad
            $request->session()->regenerate();

            // 5. Redirigir según el rol del usuario
            $mensaje = '¡Bienvenido de nuevo, ' . $usuario->nombre . '!';

            if($usuario->id_rol == 1) {
                return redirect()->intended('admin')->with('success', $mensaje);
            }
            
            if($usuario->id_rol == 2) {
                return redirect()->intended('nutriologo')->with('success', $mensaje);
            }
            
            if($usuario->id_rol == 3) {
                return redirect()->intended('entrenador')->with('success', $mensaje);
            }
            
            if($usuario->id_rol == 4) {
                return redirect()->intended('usuario')->with('success', $mensaje);   
            }
        }

        // 6. Si la autenticación falla
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('email');
    }

    public function cerrar(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}