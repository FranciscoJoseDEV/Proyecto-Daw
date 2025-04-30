<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        $user = $request->user();

        // Validar los datos
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'img' => ['nullable', 'image', 'max:2048'], // Validar que sea una imagen
        ]);

        // Si se sube una nueva imagen
        if ($request->hasFile('img')) {
            // Crear la carpeta con el nombre del usuario dentro de 'profilePictures'
            $folder = 'profilePictures/' . $user->name;

            // Verificar si la carpeta no existe y crearla
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder);
            }

            // Eliminar la imagen anterior si existe
            if ($user->img && Storage::disk('public')->exists($user->img)) {
                Storage::disk('public')->delete($user->img);
            }

            // Guardar la nueva imagen en la carpeta específica
            $path = $request->file('img')->store($folder, 'public');

            // Actualizar la ruta de la imagen en la base de datos
            $validated['img'] = $path;
        }

        // Actualizar el usuario
        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
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
