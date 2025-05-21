<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

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

        Income::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => $id,
            'recurrent' => $request->recurrent,
        ]);

        return redirect()->route('income.index', ['id' => $id])->with('success', 'Income created successfully.');
    }
}
