@extends('layouts.app')
@section('content')
    <div x-data="{ open: false }" class="flex min-h-screen bg-gray-100">
        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lista de Ingresos</h1>
                <a href="{{ route('income.create', ['id' => Auth::user()->id]) }}"
                    class="btn btn-success flex items-center gap-2">
                    <span class="material-icons">add</span>
                    <span>Agregar ingreso</span>
                </a>
            </div>

            <div>
                @if ($incomes->isEmpty())
                    <div class="alert alert-warning text-center">
                        No hay ingresos registrados.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($incomes as $income)
                            <div
                                class="bg-white border border-green-200 hover:shadow-lg transition-all p-5 rounded-xl flex flex-col gap-2 card-income">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-lg font-semibold text-green-700">{{ $income->category }}</h2>
                                    <span
                                        class="badge bg-success text-white px-2 py-1 rounded">{{ $income->date->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-2xl font-bold text-green-600 mb-2">${{ number_format($income->amount, 2) }}
                                </p>
                                <form
                                    action="{{ route('income.destroy', ['id' => Auth::user()->id, 'idInc' => $income->id]) }}"
                                    method="POST" class="mt-auto flex justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger flex items-center gap-1">
                                        <span class="material-icons">delete</span>
                                        <span>Eliminar</span>
                                    </button>
                                </form>
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

<style>
    .card-income:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(16, 185, 129, 0.15);
        transform: translateY(-4px) scale(1.02);
        transition: all 0.2s;
    }
</style>
