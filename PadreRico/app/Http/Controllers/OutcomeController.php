<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outcome;

class OutcomeController extends Controller
{
     public function index($id)
    {
        $outcomes = Outcome::where('user_id', $id)->paginate(5); 

        return view('outcome.index', compact('outcomes'));
    }
    public function destroy($idInc, $id)
    {
        $outcomes = Outcome::findOrFail($idInc);
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
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Outcome::create([
            'category' => $request->input('category'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'type' => $request->input('type'),
            'user_id' => $id,
        ]);

        return redirect()->route('outcome.index', ['id' => $id])->with('success', 'Outcome created successfully.');
    }
}
