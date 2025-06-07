<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defaulter;

class DefaultorController extends Controller
{
    public function index($id)
    {   
        $debts = Defaulter::with(['beneficiary'])
            ->where('debtor_user_id', $id)
            ->where('accepted', '!=', 2)
            ->paginate(3);
        return view('defaultors.index', compact('debts'));
    }

    public function show($id, $defaultorId)
    {
        return view('defaultors.show', compact('id', 'defaultorId'));
    }

  

    public function accept(Request $request, $id, $debtId)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
        ]);

        $debt = Defaulter::findOrFail($debtId);

        // Cambia el valor de accepted según la acción
        $debt->accepted = $request->action === 'accept' ? 1 : 2;
        $debt->save();

        return redirect()->route('defaultors.index', ['id' => $id])
            ->with('status', 'La deuda ha sido actualizada correctamente.');
    }
}
