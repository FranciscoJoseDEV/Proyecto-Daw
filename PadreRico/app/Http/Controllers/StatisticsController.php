<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\Outcome;
use Carbon\Carbon;
use App\Models\User;    
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index_monthly($id)
    {
        $user = User::find($id);
        $lastStatistic = Statistic::where('user_id', $id)
            ->where('M_or_W', 'M')
            ->orderByDesc('date')
            ->first();

        $shouldCreate = false;
        if (!$lastStatistic) {
            // Si no hay estadísticas, comprobar registro
            if ($user && $user->created_at) {
                $created = Carbon::parse($user->created_at)->startOfDay();
                $now = now()->startOfDay();
                if ($created->addDays(30)->lte($now)) {
                    $shouldCreate = true;
                } else {
                    $faltan = $created->addDays(30)->diffInDays($now, false);
                    return redirect()->route('user.dashboard')->with('warning', 'Vuelve a intentarlo en un mes para ver tus estadísticas mensuales.');
                }
            } else {
                return redirect()->route('user.dashboard')->with('warning', 'No se puede calcular la estadística mensual. Falta fecha de registro.');
            }
        } else {
            $days = now()->diffInDays(Carbon::parse($lastStatistic->date));
            if ($days >= 30) {
                $shouldCreate = true;
            }
        }

        // Calcular mes y año del resumen (siempre del mes anterior)
        $mes = now()->subMonth()->month;
        $anio = now()->subMonth()->year;

        if ($shouldCreate) {
            $mostSpending = $this->mostExpendingDay($id, 'M');
            $totals = $this->income_vs_outcome($id, 'M');
            $categoryPercentages = $this->outcomeCategoryPercentages($id, 'M');
            $statistics = Statistic::create([
                'general_balance'      => $user->savings,
                'income_total'        => $totals['income'],
                'outcome_total'       => $totals['outcome'],
                'outcome_category'    => json_encode($categoryPercentages),
                'most_spending_day'   => $mostSpending['day'] ?? 'Sin datos',
                'most_spending_day_total' => $mostSpending['total'] ?? 'Sin datos',
                'M_or_W'              => 'M',
                'date'                => now()->format('Y-m-d'),
                'user_id'             => $id,
            ]);

            // Mantener solo los 3 más recientes
            $toDelete = Statistic::where('user_id', $id)
                ->where('M_or_W', 'M')
                ->orderByDesc('date')
                ->skip(3)
                ->take(PHP_INT_MAX)
                ->get();

            foreach ($toDelete as $stat) {
                $stat->delete();
            }
        } else {
            $statistics = $lastStatistic;
        }
        return view('statistics.indexMontly', compact('statistics', 'mes', 'anio'));
    }

    public function index_weekly($id)
    {
        $user = User::find($id);
        $lastStatistic = Statistic::where('user_id', $id)
            ->where('M_or_W', 'W')
            ->orderByDesc('date')
            ->first();

        $shouldCreate = false;
        if (!$lastStatistic) {
            // Si no hay estadísticas, comprobar registro
            if ($user && $user->created_at) {
                $created = Carbon::parse($user->created_at)->startOfDay();
                $now = now()->startOfDay();
                if ($created->addDays(7)->lte($now)) {
                    $shouldCreate = true;
                } else {
                    return redirect()->route('user.dashboard')->with('warning', 'Vuelve a intentarlo en una semana para ver tus estadísticas semanales.');
                }
            } else {
                return redirect()->route('user.dashboard')->with('warning', 'No se puede calcular la estadística semanal. Falta fecha de registro.');
            }
        } else {
            $days = now()->diffInDays(Carbon::parse($lastStatistic->date));
            if ($days >= 7) {
                $shouldCreate = true;
            }
        }

        if ($shouldCreate) {
            $mostSpending = $this->mostExpendingDay($id, 'W');
            $totals = $this->income_vs_outcome($id, 'W');
            $categoryPercentages = $this->outcomeCategoryPercentages($id, 'W');
            $statistics = Statistic::create([
                'general_balance'      => $user->savings,
                'income_total'        => $totals['income'],
                'outcome_total'       => $totals['outcome'],
                'outcome_category'    => json_encode($categoryPercentages),
                'most_spending_day'   => $mostSpending['day'] ?? 'Sin datos',
                'most_spending_day_total' => $mostSpending['total'] ?? 'Sin datos',
                'M_or_W'              => 'W',
                'serial'              => uniqid(),
                'date'                => now()->format('Y-m-d'),
                'user_id'             => $id,
            ]);

            // Mantener solo los 3 más recientes
            $toDelete = Statistic::where('user_id', $id)
                ->where('M_or_W', 'W')
                ->orderByDesc('date')
                ->skip(3)
                ->take(PHP_INT_MAX)
                ->get();

            foreach ($toDelete as $stat) {
                $stat->delete();
            }
        } else {
            $statistics = $lastStatistic;
        }

        return view('statistics.indexWeekly', compact('statistics'));
    }

    public function mostExpendingDay($id, $m_or_w)
    {
        list($startDate, $endDate) = $this->getDateRange($m_or_w);

        // Obtener el día con mayor gasto
        $mostSpendingDay = Outcome::where('user_id', $id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('DATE(date) as day, SUM(amount) as total')
            ->groupBy('day')
            ->orderByDesc('total')
            ->first();

        // Retornar el día y el total gastado, o null si no hay datos
        return $mostSpendingDay ? [
            'day' => $mostSpendingDay->day,
            'total' => $mostSpendingDay->total
        ] : null;
    }

    public function income_vs_outcome($id, $m_or_w)
    {
        list($startDate, $endDate) = $this->getDateRange($m_or_w);

        // Aquí deberías usar tu modelo de ingresos si existe, este es solo un ejemplo usando Outcome
        $incomeTotal = 0; // Cambia esto por el modelo correcto si tienes ingresos
        $outcomeTotal = Outcome::where('user_id', $id)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        return [
            'income' => $incomeTotal,
            'outcome' => $outcomeTotal,
        ];
    }

    public function outcomeCategoryPercentages($id, $m_or_w)
    {
        list($startDate, $endDate) = $this->getDateRange($m_or_w);

        // Obtener todos los gastos del usuario en el rango
        $outcomes = Outcome::where('user_id', $id)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $total = $outcomes->sum('amount');

        // Agrupar por categoría y calcular porcentaje
        $percentages = [];
        if ($total > 0) {
            $byCategory = $outcomes->groupBy('category');
            foreach ($byCategory as $category => $items) {
                $sum = $items->sum('amount');
                $percentages[$category] = round(($sum / $total) * 100, 2);
            }
        }

        return $percentages; 
    }

    private function getDateRange($m_or_w)
    {
        if ($m_or_w === 'M') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } else { // 'W'
            // Lunes anterior (hace 1 semana) hasta domingo anterior
            $startDate = now()->subWeek()->startOfWeek();
            $endDate = now()->subWeek()->endOfWeek();
        }
        return [$startDate, $endDate];
    }
}
