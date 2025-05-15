@extends('layouts.app')

@section('content')
    <div x-data="{ open: false }" class="flex h-screen">
        <main class="flex-1 bg-gray-100 p-6">
            @if (session('warning'))
                <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <span class="block">{{ session('warning') }}</span>
                </div>
            @endif

            <!-- Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-r from-green-100 to-green-50 shadow-md rounded-lg p-6 flex flex-col items-center">
                    <div class="mb-2">
                        <span class="material-icons text-green-500 text-4xl">account_balance_wallet</span>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-700">Balance Actual</h2>
                    <p id="balance" class="text-3xl font-bold text-green-600 mt-2">0 €</p>
                </div>
            </div>

            <!-- Movimientos recientes -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Movimientos Recientes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tabla de Ingresos -->
                    <div>
                        <h3 class="text-md font-semibold mb-2 text-blue-500 flex items-center gap-2">
                            <span class="material-icons text-blue-400">trending_up</span> Ingresos
                        </h3>
                        @if ($incomes->isNotEmpty())
                            <div class="mb-2 text-sm text-blue-700">
                                Total: +${{ number_format($incomes->sum('amount'), 2) }}
                            </div>
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full rounded-lg overflow-hidden">
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
                                                <td class="border px-4 py-2">{{ $income->category }}</td>
                                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}</td>
                                                <td class="border px-4 py-2 text-green-600 font-semibold">
                                                    +${{ number_format($income->amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">¡Sin ingresos!</strong>
                                <span class="block sm:inline">Comienza a añadir ingresos y aparecerán aquí los más recientes.</span>
                            </div>
                        @endif
                    </div>

                    <!-- Tabla de Gastos -->
                    <div>
                        <h3 class="text-md font-semibold mb-2 text-red-500 flex items-center gap-2">
                            <span class="material-icons text-red-400">trending_down</span> Gastos
                        </h3>
                        @if ($outcomes->isNotEmpty())
                            <div class="mb-2 text-sm text-red-700">
                                Total: -${{ number_format($outcomes->sum('amount'), 2) }}
                            </div>
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full rounded-lg overflow-hidden">
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
                                                <td class="border px-4 py-2">{{ $outcome->category }}</td>
                                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($outcome->date)->format('d/m/Y') }}</td>
                                                <td class="border px-4 py-2 text-red-600 font-semibold">
                                                    -${{ number_format($outcome->amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">¡Sin gastos!</strong>
                                <span class="block sm:inline">Comienza a añadir gastos y aparecerán aquí los más recientes.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
@endsection
