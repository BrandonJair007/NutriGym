<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Obtenemos el ID del usuario que tiene la sesión iniciada
        $id = Auth::id();

        // 2. Validamos los datos enviados desde tu modal
        $request->validate([
            'nombre' => 'required|string|max:255|unique:usuarios,nombre,' . $id,
            'email' => 'required|email|max:255|unique:usuarios,email,' . $id,
            'fecha_nacimiento' => 'required|date|before:-18 years',
        ], [
            'nombre.unique' => 'Este nombre de usuario ya está en uso por otra persona.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años.',
        ]);

        // 3. Actualizamos en la base de datos
        DB::table('usuarios')
            ->where('id', $id)
            ->update([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);

        // 4. Redirigimos de vuelta a tu panel con un mensaje de éxito
        return back()->with('success', 'Tus datos personales han sido actualizados correctamente.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}