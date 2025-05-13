<?php

namespace App\Http\Controllers;
use App\Models\Defaulter;
use App\Models\User;
use Illuminate\Http\Request;

class DefaulterController extends Controller
{
    public function index ($id)
    {
        $defaulters = Defaulter::where('user_id', $id)->paginate(3);
        return view('defaulter.index', compact('defaulters'));
    }
}
