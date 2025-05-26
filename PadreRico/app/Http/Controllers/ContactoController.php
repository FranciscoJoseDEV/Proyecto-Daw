<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:2000',
        ]);

        // Enviar el correo usando la configuración de Laravel
        Mail::raw(
            "Nombre: {$validated['nombre']}\nEmail: {$validated['email']}\nMensaje: {$validated['mensaje']}",
            function ($message) use ($validated) {
                $message->to('franciscojosesanchezlloret@gmail.com')
                        ->subject('Nuevo mensaje de contacto')
                        ->replyTo($validated['email'], $validated['nombre']);
            }
        );

        return back()->with('success', '¡Mensaje enviado correctamente!');
    }
}
