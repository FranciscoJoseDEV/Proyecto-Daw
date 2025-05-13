<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    /**
     * Display a listing of the incomes.
     */
    public function index($id)
    {
        $incomes = Income::where('user_id', $id)
            ->orderBy('date', 'desc') // Ordenar por fecha descendente
            ->paginate(5);

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
            'type' => 'required|string|max:255',
        ]);

        Income::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'type' => $request->type,
            'user_id' => $id,
        ]);

        return redirect()->route('income.index', ['id' => $id])->with('success', 'Income created successfully.');
    }
}
