<?php

namespace App\Http\Controllers;

use App\Models\Defaulter;
use App\Models\User;
use Illuminate\Http\Request;

class DefaulterController extends Controller
{
    public function index($id)
    {   
        //personas que me deben dinero
        $defaulters = Defaulter::with('debtor')
        ->where('beneficiary_user_id', $id)
        ->paginate(3);
        return view('defaulter.index', compact('defaulters'));
    }



    public function create($id)
    {
        return view('defaulter.create', compact('id'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'description' => 'max:255',
            'amount' => 'required|numeric',
            'inicial_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:inicial_date',
        ]);

        $defaulter = User::where('email', $request->email)->first();

        // Si no se encuentra el usuario, redirige hacia atrás con un error
        if (!$defaulter) {
            return redirect()->back()->withErrors(['email' => 'No se encontró un usuario con ese correo electrónico.'])->withInput();
        }

        Defaulter::create([
            'debtor_user_id' => $defaulter->id,
            'beneficiary_user_id' => $id,
            'description' => $request->description,
            'amount' => $request->amount,
            'inicial_date' => $request->inicial_date,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('defaulter.index', ['id' => $id])->with('success', 'Deudor creado correctamente.');
    }

    public function show($id, $defaulterId)
    {
        $defaulter = Defaulter::with('debtor')->findOrFail($defaulterId);
        return view('defaulter.show', compact('id', 'defaulter'));
    }

    public function destroy($id, $defaulterId)
    {
        $defaulter = Defaulter::findOrFail($defaulterId);
        $defaulter->delete();

        return redirect()->route('defaulter.index', ['id' => $id])->with('success', 'Deudor eliminado correctamente.');
    }
}
