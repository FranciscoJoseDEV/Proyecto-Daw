<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class VerificationCodeController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = User::find(Auth::id());

        if ($user->verification_code === $request->code && now()->lessThan($user->verification_code_expires_at)) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->verification_code_expires_at = null;
            $user->save();

            return redirect()->route('dashboard')->with('success', '¡Correo verificado correctamente!');
        }

        return back()->withErrors(['code' => 'El código es incorrecto o ha expirado.']);
    }

    public function resend(Request $request)
    {
        $user = User::find(Auth::id());
        $code = rand(100000, 999999);

        $user->verification_code = $code;
        $user->verification_code_expires_at = now()->addMinutes(10);
        $user->save();

        // Envía el código por email
        Mail::raw("Tu código de verificación es: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Código de verificación');
        });

        return back()->with('success', 'Se ha reenviado el código a tu correo.');
    }
}