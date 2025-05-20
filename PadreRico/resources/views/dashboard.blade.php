@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <main class="flex-1 p-6">
            {{-- Alertas --}}
            @if (session('warning'))
                <div class="mb-4 bg-cssecondary border-l-4 p-4 rounded">
                    <span class="block">{{ session('warning') }}</span>
                </div>
            @endif

            {{-- Balance y Racha en dos columnas estilo estadísticas --}}
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Columna Balance -->
                            <div
                                class="col-md-6 mb-4 d-flex flex-column align-items-center justify-content-center">
                                <span
                                    class="material-icons text-green-400 text-5xl mb-2 animate-bounce">account_balance_wallet</span>
                                <h2 class="text-xl font-semibold text-gray-700 mb-1">Balance Actual</h2>
                                <p id="balance" class="text-4xl font-bold text-green-600 mt-2">
                                    {{ number_format($user->savings, 2, ',', '.') }} €
                                </p>
                            </div>
                            <!-- Columna Racha -->
                            <div
                                class="col-md-6 mb-4 d-flex flex-column align-items-center justify-content-center">
                                <span id="streak-icon"
                                    class="material-icons text-yellow-400 text-5xl mb-2 animate-pulse">local_fire_department</span>
                                <h2 class="text-xl font-semibold text-gray-700 mb-1">Racha de Días</h2>
                                <p id="streak" class="text-4xl font-bold text-yellow-600 mt-2">
                                    {{ Auth::user()->streak_count ?? 0 }} <span
                                        class="text-base font-normal text-gray-400">días</span>
                                </p>
                                @if (Auth::user()->streak_count > 0)
                                    <p class="mt-2 text-sm text-yellow-700">¡Sigue así para mantener tu racha!</p>
                                @else
                                    <p class="mt-2 text-sm text-gray-400">¡Comienza tu racha hoy!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MOVIMIENTOS RECIENTES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ingresos -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-md font-semibold mb-2 text-blue-500 flex items-center gap-2">
                        <span class="material-icons text-blue-400">trending_up</span> Ingresos
                    </h3>
                    @if ($incomes->isNotEmpty())
                        <div class="mb-2 text-sm text-blue-700">
                            Total: +{{ number_format($incomes->sum('amount'), 2) }} €
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="bg-blue-50">
                                        <th class="px-4 py-2">Categoría</th>
                                        <th class="px-4 py-2">Fecha</th>
                                        <th class="px-4 py-2">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomes as $income)
                                        <tr class="even:bg-blue-50">
                                            <td class="px-4 py-2">{{ $income->category }}</td>
                                            <td class="px-4 py-2">
                                                {{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 text-green-600 font-semibold">
                                                +{{ number_format($income->amount, 2) }} €
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded" role="alert">
                            <strong class="font-bold">¡Sin ingresos!</strong>
                            <span class="block sm:inline">Añade ingresos para verlos aquí.</span>
                        </div>
                    @endif
                </div>
                <!-- Gastos -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-md font-semibold mb-2 text-red-500 flex items-center gap-2">
                        <span class="material-icons text-red-400">trending_down</span> Gastos
                    </h3>
                    @if ($outcomes->isNotEmpty())
                        <div class="mb-2 text-sm text-red-700">
                            Total: -{{ number_format($outcomes->sum('amount'), 2) }} €
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="bg-red-50">
                                        <th class="px-4 py-2">Categoría</th>
                                        <th class="px-4 py-2">Fecha</th>
                                        <th class="px-4 py-2">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($outcomes as $outcome)
                                        <tr class="even:bg-red-50">
                                            <td class="px-4 py-2">{{ $outcome->category }}</td>
                                            <td class="px-4 py-2">
                                                {{ \Carbon\Carbon::parse($outcome->date)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 text-red-600 font-semibold">
                                                -{{ number_format($outcome->amount, 2) }} €
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-red-50 text-red-700 px-4 py-3 rounded" role="alert">
                            <strong class="font-bold">¡Sin gastos!</strong>
                            <span class="block sm:inline">Añade gastos para verlos aquí.</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SCRIPTS Y ANIMACIONES --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Animación balance y racha
                document.addEventListener('DOMContentLoaded', function() {
                    // Balance
                    const balanceElement = document.getElementById('balance');
                    const targetBalance = {{ $user->savings }};
                    let currentBalance = 0;
                    const increment = Math.ceil(targetBalance / 100);

                    const interval = setInterval(() => {
                        currentBalance += increment;
                        if (currentBalance >= targetBalance) {
                            currentBalance = targetBalance;
                            clearInterval(interval);
                        }
                        balanceElement.textContent = `${currentBalance.toLocaleString()} €`;
                    }, 20);

                    // Racha de días con icono dinámico
                    const streakElement = document.getElementById('streak');
                    const streakIcon = document.getElementById('streak-icon');
                    const targetStreak = {{ Auth::user()->streak_count ?? 0 }};
                    let currentStreak = 0;
                    const streakIncrement = targetStreak > 0 ? Math.ceil(targetStreak / 50) : 1;

                    // Tamaño base y máximo del icono
                    const baseSize = 40; // px
                    const maxSize = 100; // px

                    // Factor de crecimiento más lento por día de racha
                    // Puedes ajustar el divisor (por ejemplo, 2, 3, 4...) para que el crecimiento sea más lento
                    const growthDivisor = 3;

                    let currentIconSize = baseSize;

                    const streakInterval = setInterval(() => {
                        currentStreak += streakIncrement;
                        if (currentStreak >= targetStreak) {
                            currentStreak = targetStreak;
                        }
                        streakElement.innerHTML =
                            `${currentStreak} <span class="text-base font-normal text-gray-400">días</span>`;

                        // Cambia el color del icono a dorado si la racha es 100 o más
                        if (currentStreak >= 100) {
                            streakIcon.classList.remove('text-yellow-400');
                            streakIcon.classList.add('text-yellow-600');
                            streakIcon.style.color = '#FFD700'; // dorado
                        } else {
                            streakIcon.classList.remove('text-yellow-600');
                            streakIcon.classList.add('text-yellow-400');
                            streakIcon.style.color = '';
                        }

                        // El tamaño crece más lento por cada día de racha
                        let targetIconSize = baseSize;
                        if (targetStreak > 0) {
                            // El crecimiento es proporcional pero más lento
                            targetIconSize = baseSize + Math.min(((currentStreak / (targetStreak * growthDivisor)) *
                                (maxSize - baseSize)), maxSize - baseSize);
                        }

                        currentIconSize += (targetIconSize - currentIconSize) * 0.1;
                        streakIcon.style.fontSize = currentIconSize + 'px';

                        if (currentStreak >= targetStreak && Math.abs(currentIconSize - targetIconSize) < 1) {
                            streakIcon.style.fontSize = targetIconSize + 'px';
                            clearInterval(streakInterval);
                        }
                    }, 20);
                });
            </script>
        </main>
    </div>
@endsection
