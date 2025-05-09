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
        $incomes = Income::where('user_id', $id)->paginate(5); 

        return view('income.index', compact('incomes'));
    }
    public function destroy($idInc, $id)
    {
        $income = Income::findOrFail($idInc);
        $income->delete();

        return redirect()->route('income.index', ['id' => $id])->with('success', 'Income deleted successfully.');
    }
   
       
}
