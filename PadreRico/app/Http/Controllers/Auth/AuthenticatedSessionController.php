<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Achievement;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $authUserRol = User::where('email', $request->email)->value('role');

        $user = User::find(Auth::id());
        

        $today = Carbon::today();
        $lastLogin = $user->last_login_date ? Carbon::parse($user->last_login_date) : null;

        if ($lastLogin) {
            $diff = $lastLogin->diffInDays($today);
            if ($diff === 1) {
                $user->streak_count += 1;
            } elseif ($diff > 1) {
                $user->streak_count = 1;
            }
            // Si diff === 0, no cambies nada
        } else {
            $user->streak_count = 1; // Primer inicio de sesión
        }

        $user->last_login_date = $today->toDateString();
        $user->save();

        $logrosRacha = [
            1 => '¡Primer día!',
            7 => 'Racha de 7 días',
            14 => 'Racha de 14 días',
            30 => 'Racha de 30 días',
            100 => 'Racha legendaria',
        ];

        foreach ($logrosRacha as $dias => $nombreLogro) {
            $logro = Achievement::where('name', $nombreLogro)->first();
            if ($logro && $user->streak_count >= $dias && !$user->achievements->contains($logro->id)) {
                $user->achievements()->attach($logro->id, [
                    'achieve_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Redirección según rol
        switch ($authUserRol) {
            case 0:
                return redirect()->intended(route('admin.dashboard', absolute: false));
            case 1:
                return redirect()->intended(route('user.dashboard', absolute: false));
            default:
                return redirect('/');
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
