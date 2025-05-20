<?php

namespace App\Http\Controllers;

use App\Models\SavingsObjective;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SavingsObjectiveController extends Controller
{
    public function index($id)
    {
        $objective = SavingsObjective::where('user_id', $id)
            ->orderBy('date_limit', 'asc')
            ->first();

        $felicitacion = null;
        $restante = null;
        $diasRestantes = null;
        $progressColor = '';
        $progreso = 0;

        if ($objective) {
            $userSavings = $objective->user->savings ?? 0;
            $goal = $objective->goal_amount > 0 ? $objective->goal_amount : 1;

            // Progreso en porcentaje
            $progreso = min(100, round(($userSavings / $goal) * 100));

            // Restante para la meta
            $restante = max(0, $objective->goal_amount - $userSavings);

            // Días restantes hasta la fecha límite
            $hoy = Carbon::today();
            $fechaLimite = Carbon::parse($objective->date_limit);
            $diasRestantes = $hoy->diffInDays($fechaLimite, false);

            // Color de la barra de progreso
            if ($progreso >= 100) {
                $progressColor = 'bg-success';
                $felicitacion = "¡Felicidades! Has alcanzado tu objetivo de ahorro. ¿Quieres crear uno nuevo?";
            } elseif ($progreso >= 75) {
                $progressColor = 'bg-info';
            } elseif ($progreso >= 50) {
                $progressColor = 'bg-warning';
            } else {
                $progressColor = 'bg-danger';
            }
        }

        return view('savings_objective.index', compact(
            'objective',
            'felicitacion',
            'restante',
            'diasRestantes',
            'progressColor',
            'progreso'
        ));
    }

    public function create($id)
    {
        $existing = SavingsObjective::where('user_id', $id)->first();

        // Permitir solo si NO tiene objetivo o si viene de la felicitación
        if ($existing && !session('allow_create')) {
            return redirect()->route('savings_objective.index', $id)
                ->with('error', 'Solo puedes tener un objetivo de ahorro a la vez.');
        }

        // Limpiar la bandera para evitar acceso directo posterior
        session()->forget('allow_create');
        return view('savingsobj.create');
    }

    public function store(Request $request, $id)
    {
        // Elimina el objetivo anterior si existe
        $existing = SavingsObjective::where('user_id', $id)->first();
        if ($existing) {
            // Buscar usuario y sumar 1 a num_obj_completed
            $user = $existing->user;
            if ($user) {
                $user->num_obj_completed = ($user->num_obj_completed ?? 0) + 1;
                $user->save();
            }
            $existing->delete();
        }

        // Crea el nuevo objetivo
        $objective = new SavingsObjective();
        $objective->user_id = $id;
        $objective->objective_name = $request->objective_name;
        $objective->goal_amount = $request->goal_amount;
        $objective->date_limit = $request->date_limit;
        $objective->status = 'en progreso';
        $objective->save();

        return redirect()->route('savingsobj.index', $id)
            ->with('success', '¡Nuevo objetivo de ahorro creado correctamente!');
    }

    public function update(Request $request, $id)
    {
        $objective = SavingsObjective::findOrFail($id);
        $objective->objective_name = $request->objective_name;
        $objective->goal_amount = $request->goal_amount;
        $objective->date_limit = $request->date_limit;
        $objective->save();

        return redirect()->route('savingsobj.index', $objective->user_id)
            ->with('success', '¡Objetivo actualizado correctamente!');
    }
}
