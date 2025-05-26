<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchivementsController extends Controller
{
    // Mostrar todos los logros disponibles
    public function index()
    {
        $achievements = Achievement::all();
        $userAchievements = Auth::user()->achievements->pluck('id')->toArray();

        return view('achievements.index', compact('achievements', 'userAchievements'));
    }

    // Comprobar y asignar logros
    public function checkAndAssign()
    {
        $user = User::find(Auth::id()); 
        $achievements = Achievement::all();

        foreach ($achievements as $achievement) {
            if ($user->achievements->contains($achievement->id)) {
                continue; // ya tiene este logro
            }

            // Aquí puedes usar lógica personalizada por condición
            if ($this->meetsCondition($user, $achievement->condition)) {
                $user->achievements()->attach($achievement->id);
            }
        }
    }

    // Lógica básica para cumplir condiciones
    private function meetsCondition($user, $condition)
    {
        if (!$condition) return false;

        [$type, $value] = explode(':', $condition);

        switch ($type) {
            case 'streak':
                return $user->streak_count >= (int)$value;
            case 'savings':
                return $user->savings >= (int)$value;
            default:
                return false;
        }
    }
}
