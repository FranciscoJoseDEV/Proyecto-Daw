<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outcome;
use App\Models\User;
use App\Models\Achievement;

class OutcomeController extends Controller
{
    public function index(Request $request, $id)
    {
        $filtro = $request->input('filtro');

        $query = Outcome::where('user_id', $id);

        if ($filtro === 'recurrentes') {
            $query->where('recurrent', 1);
        } elseif ($filtro === 'no_recurrentes') {
            $query->where('recurrent', 0);
        }

        $outcomes = $query->orderBy('date', 'desc')->paginate(9);

        return view('outcome.index', compact('outcomes'));
    }

    public function destroy($id, $idOut)
    {
        $outcomes = Outcome::findOrFail($idOut);
        $outcomes->delete();

        return redirect()->route('outcome.index', ['id' => $id])->with('success', 'Income deleted successfully.');
    }
    public function create($id)
    {
        return view('outcome.create', compact('id'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'recurrent' => 'nullable|int|digits_between:0,1',
        ]);

        $outcome = Outcome::create([
            'category' => $request->input('category'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'user_id' => $id,
            'recurrent' => $request->input('recurrent'),
        ]);

        // Lógica de logros de gastos
        $user = User::find($id);

        // 1. Primer gasto
        $primerGasto = Achievement::where('name', 'Primer gasto')->first();
        if ($primerGasto && $user->outcome()->count() == 1 && !$user->achievements->contains($primerGasto->id)) {
            $user->achievements()->attach($primerGasto->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Gasto responsable (7 días distintos con gastos)
        $gastoResponsable = Achievement::where('name', 'Gasto responsable')->first();
        $diasConGastos = $user->outcome()->select('date')->distinct()->count();
        if ($gastoResponsable && $diasConGastos >= 7 && !$user->achievements->contains($gastoResponsable->id)) {
            $user->achievements()->attach($gastoResponsable->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Control de gastos (1000 € acumulados)
        $controlGastos = Achievement::where('name', 'Control de gastos')->first();
        $totalGastos = $user->outcome()->sum('amount');
        if ($controlGastos && $totalGastos >= 1000 && !$user->achievements->contains($controlGastos->id)) {
            $user->achievements()->attach($controlGastos->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Gasto grande (un gasto >= 300 €)
        $gastoGrande = Achievement::where('name', 'Gasto grande')->first();
        $tieneGastoGrande = $user->outcome()->where('amount', '>=', 300)->exists();
        if ($gastoGrande && $tieneGastoGrande && !$user->achievements->contains($gastoGrande->id)) {
            $user->achievements()->attach($gastoGrande->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Registro impecable (5000 € acumulados)
        $registroImpecable = Achievement::where('name', 'Registro impecable')->first();
        if ($registroImpecable && $totalGastos >= 5000 && !$user->achievements->contains($registroImpecable->id)) {
            $user->achievements()->attach($registroImpecable->id, [
                'achieve_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('outcome.index', ['id' => $id])->with('success', 'Outcome created successfully.');
    }
}
