@extends('layouts.app')
@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table th {
            background-color: #343a40;
            color: #ffffff;
        }
    </style>

    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Aside layout -->
        @include('layouts.aside')

        <!-- Main content -->
        <main class="flex-1 bg-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-center">Lista de Ingresos</h1>
                <a href="{{ route('income.create', ['id' => Auth::user()->id]) }}" class="btn btn-success">Agregar Nuevo Ingreso</a>
            </div>

            <div class="table-container">
                @if ($incomes->isEmpty())
                    <div class="alert alert-warning text-center">
                        No hay ingresos registrados.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($incomes as $income)
                            <div class="bg-green mb-4 p-4 rounded shadow">
                                <h2 class="text-black font-bold">{{ $income->category }}</h2>
                                <p class="text-black">Monto: ${{ number_format($income->amount, 2) }}</p>
                                <p class="text-black">Fecha: {{ $income->date->format('d/m/Y') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Agregar enlaces de paginación -->
                    <div class="mt-4">
                        {{ $incomes->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
