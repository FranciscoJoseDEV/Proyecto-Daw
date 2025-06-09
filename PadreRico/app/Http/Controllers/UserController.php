<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Income;
use App\Models\Outcome;

class UserController extends Controller
{



    public function index()
    {
        $user = User::find(Auth::id());
        $startDate = Carbon::now()->subDays(30)->startOfDay();

        $incomes = Income::where('user_id', $user->id)
            ->whereDate('date', '>=', $startDate)
            ->orderBy('date', 'asc')
            ->get();

        $outcomes = Outcome::where('user_id', $user->id)
            ->whereDate('date', '>=', $startDate)
            ->orderBy('date', 'asc')
            ->get();

        // Fechas únicas combinadas
        $dates = $incomes->pluck('date')->merge($outcomes->pluck('date'))->unique()->sort();

        $labels = [];
        $balanceData = [];
        $recurrentIncomesData = [];
        $nonRecurrentIncomesData = [];
        $recurrentOutcomesData = [];
        $nonRecurrentOutcomesData = [];

        $incomeSum = 0;
        $outcomeSum = 0;

        foreach ($dates as $date) {
            $formattedDate = Carbon::parse($date)->format('d/m/Y');
            $labels[] = $formattedDate;

            $incomeRecurrent = $incomes->where('date', $date)->where('recurrent', 1)->sum('amount');
            $incomeNonRecurrent = $incomes->where('date', $date)->where('recurrent', 0)->sum('amount');
            $outcomeRecurrent = $outcomes->where('date', $date)->where('recurrent', 1)->sum('amount');
            $outcomeNonRecurrent = $outcomes->where('date', $date)->where('recurrent', 0)->sum('amount');

            $recurrentIncomesData[] = $incomeRecurrent;
            $nonRecurrentIncomesData[] = $incomeNonRecurrent;
            $recurrentOutcomesData[] = $outcomeRecurrent;
            $nonRecurrentOutcomesData[] = $outcomeNonRecurrent;

            $incomeSum += $incomeRecurrent + $incomeNonRecurrent;
            $outcomeSum += $outcomeRecurrent + $outcomeNonRecurrent;
            $balanceData[] = $incomeSum - $outcomeSum;
        }

        if (count($balanceData) > 0) {
            $balanceData[count($balanceData) - 1] = $user->savings;
        }

        // Lógica para logros de ahorro
        $ahorroLogros = [
            100 => 'Ahorro inicial',
            500 => 'Ahorrador constante',
            1000 => 'Meta de 1000 €',
            2500 => 'Ahorrador experto',
            5000 => 'Ahorro épico',
        ];

        foreach ($ahorroLogros as $cantidad => $nombreLogro) {
            $logro = \App\Models\Achievement::where('name', $nombreLogro)->first();
            if ($logro && $user->savings >= $cantidad && !$user->achievements->contains($logro->id)) {
                $user->achievements()->attach($logro->id, [
                    'achieve_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $apiKey = config('services.exchangerate.key');

        return view('dashboard', compact(
            'user',
            'labels',
            'balanceData',
            'recurrentIncomesData',
            'nonRecurrentIncomesData',
            'recurrentOutcomesData',
            'nonRecurrentOutcomesData'
        ))->with('exchangeRateApiKey', $apiKey);
    }
}
