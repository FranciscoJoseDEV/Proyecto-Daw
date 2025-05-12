@extends('layouts.app')

@section('content')
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Botón para mostrar/ocultar el menú -->
        <button @click="open = !open"
            class="absolute top-4 left-4 z-10 bg-gray-800 text-white p-2 rounded-md focus:outline-none md:hidden">
            <span x-show="!open" class="material-icons">menu</span>
            <span x-show="open" class="material-icons">close</span>
        </button>

        <!-- Barra lateral -->
        @include('layouts.aside')

        <!-- Contenido principal -->
        <main class="flex-1 bg-gray-100 p-6">
            <h1 class="text-2xl font-bold mb-6">Dashboard de Finanzas</h1>

            <!-- Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Balance Actual</h2>
                    <p id="balance" class="text-2xl font-bold text-green-500">0</p>
                </div>
            </div>

            <!-- Movimientos recientes -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Movimientos Recientes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tabla de Ingresos -->
                    <div>
                        <h3 class="text-md font-semibold mb-2 text-blue-500">Ingresos</h3>
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Categoria</th>
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incomes as $income)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $income->category }}</td>
                                        <td class="border px-4 py-2">{{ $income->date }}</td>
                                        <td class="border px-4 py-2 text-green-500">
                                            +${{ number_format($income->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabla de Gastos -->
                    <div>
                        <h3 class="text-md font-semibold mb-2 text-red-500">Gastos</h3>
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Categoria</th>
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outcomes as $outcome)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $outcome->category }}</td>
                                        <td class="border px-4 py-2">{{ $outcome->date }}</td>
                                        <td class="border px-4 py-2 text-red-500">-${{ number_format($outcome->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const balanceElement = document.getElementById('balance');
            const targetBalance = {{ $user->savings }};
            let currentBalance = 0;
            const increment = Math.ceil(targetBalance / 100); // Ajusta la velocidad de incremento

            const interval = setInterval(() => {
                currentBalance += increment;
                if (currentBalance >= targetBalance) {
                    currentBalance = targetBalance;
                    clearInterval(interval);
                }
                balanceElement.textContent = `${currentBalance.toLocaleString()} €`;
            }, 20); // Ajusta la velocidad de la animación
        });
    </script>
@endsection
