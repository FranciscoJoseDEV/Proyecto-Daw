<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 1,
        ]);

        // Generar y guardar código
        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->verification_code_expires_at = now()->addMinutes(10);
        $user->save();

        // Enviar código por email
        Mail::raw("Tu código de verificación es: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Código de verificación');
        });

        event(new Registered($user));

        Auth::login($user);

        // Redirige a la vista que pide verificar el email
        return redirect()->route('verification.notice');
    }
}
