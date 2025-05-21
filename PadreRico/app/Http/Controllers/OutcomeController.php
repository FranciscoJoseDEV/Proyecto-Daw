<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outcome;

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

        Outcome::create([
            'category' => $request->input('category'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'user_id' => $id,
            'recurrent' => $request->input('recurrent'),
        ]);

        return redirect()->route('outcome.index', ['id' => $id])->with('success', 'Outcome created successfully.');
    }
}
