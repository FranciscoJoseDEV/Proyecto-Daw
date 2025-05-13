@extends('layouts.app')
@section('content')
    <div x-data="{ open: false }" class="flex h-screen">


        <!-- Main content -->
        <main class="flex-1 bg-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-center">Lista de Gastos</h1>
                <a href="{{ route('outcome.create', ['id' => Auth::user()->id]) }}" class="btn btn-success flex items-center">
                    <span class="material-icons">add</span>
                </a>
            </div>

            <div class="table-container">
                @if ($outcomes->isEmpty())
                    <div class="alert alert-warning text-center">
                        No hay gastos registrados.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($outcomes as $outcome)
                            <div class="bg-red mb-4 p-4 rounded shadow">
                                <h2 class="text-black font-bold">{{ $outcome->category }}</h2>
                                <p class="text-black">Monto: ${{ number_format($outcome->amount, 2) }}</p>
                                <p class="text-black">Fecha: {{ $outcome->date->format('d/m/Y') }}</p>

                                <form
                                    action="{{ route('outcome.destroy', ['id' => Auth::user()->id, 'idOut' => $outcome->id]) }}"
                                    method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center">
                                        <span class="material-icons">delete</span>
                                    </button>
                                </form>
                            </div>
                            <!-- Botón para eliminar -->
                        @endforeach
                    </div>

                    <!-- Agregar enlaces de paginación -->
                    <div class="mt-4">
                        {{ $outcomes->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
