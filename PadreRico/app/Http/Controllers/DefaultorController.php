<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defaulter;

class DefaultorController extends Controller
{
    public function index($id)
    {   
        //personas a las que les debo dinero 
        $debts = Defaulter::with(['beneficiary'])
            ->where('debtor_user_id', $id)
            ->paginate(3);
        return view('defaultors.index', compact('debts'));
    }




    public function show($id, $defaultorId)
    {
        return view('defaultors.show', compact('id', 'defaultorId'));
    }
}
