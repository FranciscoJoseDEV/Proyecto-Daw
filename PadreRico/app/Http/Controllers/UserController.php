<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Income;
use App\Models\Outcome;

class UserController extends Controller
{


    public function index()
    {
        $userId = Auth::user()->id;

        // Obtener los 3 ingresos más recientes del usuario
        $incomes = Income::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(3)
            ->get();

        // Obtener los 3 gastos más recientes del usuario
        $outcomes = Outcome::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(3)
            ->get();

        // Enviar los ingresos y gastos por separado a la vista
        return view('user.dashboard', compact('incomes', 'outcomes'));
    }
}
