<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\User;
use App\Models\Achievement;

class IncomeController extends Controller
{
    /**
     * Display a listing of the incomes.
     */
    public function index(Request $request, $id)
    {
        $filtro = $request->input('filtro');

        $query = Income::where('user_id', $id);

        if ($filtro === 'recurrentes') {
            $query->where('recurrent', 1);
        } elseif ($filtro === 'no_recurrentes') {
            $query->where('recurrent', 0);
        }

        $incomes = $query->orderBy('date', 'desc')->paginate(9);

        return view('income.index', compact('incomes'));
    }

    public function destroy($id, $idInc)
    {
        $income = Income::findOrFail($idInc);

        $income->delete();

        return redirect()->route('income.index', ['id' => $id])->with('success', 'Income deleted successfully.');
    }


    public function create($id)
    {
        return view('income.create', compact('id'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'recurrent' => 'nullable|int|digits_between:0,1',
        ]);

        $income = Income::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => $id,
            'recurrent' => $request->recurrent,
        ]);

        // Lógica de logros de ingresos
        $user = User::find($id);

        // 1. Primer ingreso
        $primerIngreso = Achievement::where('name', 'Primer ingreso')->first();
        if ($primerIngreso && $user->income()->count() == 1 && !$user->achievements->contains($primerIngreso->id)) {
            $user->achievements()->attach($primerIngreso->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Ingresos constantes (7 días distintos con ingresos)
        $ingresos7dias = Achievement::where('name', 'Ingresos constantes')->first();
        $diasConIngresos = $user->income()->select('date')->distinct()->count();
        if ($ingresos7dias && $diasConIngresos >= 7 && !$user->achievements->contains($ingresos7dias->id)) {
            $user->achievements()->attach($ingresos7dias->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Productividad creciente (1000 € acumulados)
        $productividad = Achievement::where('name', 'Productividad creciente')->first();
        $totalIngresos = $user->income()->sum('amount');
        if ($productividad && $totalIngresos >= 1000 && !$user->achievements->contains($productividad->id)) {
            $user->achievements()->attach($productividad->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Gran ingreso (un ingreso >= 500 €)
        $granIngreso = Achievement::where('name', 'Gran ingreso')->first();
        $tieneIngresoGrande = $user->income()->where('amount', '>=', 500)->exists();
        if ($granIngreso && $tieneIngresoGrande && !$user->achievements->contains($granIngreso->id)) {
            $user->achievements()->attach($granIngreso->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Flujo de ingresos (5000 € acumulados)
        $flujoIngresos = Achievement::where('name', 'Flujo de ingresos')->first();
        if ($flujoIngresos && $totalIngresos >= 5000 && !$user->achievements->contains($flujoIngresos->id)) {
            $user->achievements()->attach($flujoIngresos->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('income.index', ['id' => $id])->with('success', 'Income created successfully.');
    }
}
