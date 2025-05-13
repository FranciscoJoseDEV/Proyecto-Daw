@extends('layouts.app')
@section('content')
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Main content -->
        <main class="flex-1 bg-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-center">Lista de Ingresos</h1>
                <a href="{{ route('income.create', ['id' => Auth::user()->id]) }}" class="btn btn-success flex items-center">
                    <span class="material-icons">add</span>
                </a>
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

                                <!-- Botón para eliminar -->
                                <form
                                    action="{{ route('income.destroy', ['id' => Auth::user()->id, 'idInc' => $income->id]) }}"
                                    method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="  flex items-center">
                                        <span class="material-icons">delete</span>
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
