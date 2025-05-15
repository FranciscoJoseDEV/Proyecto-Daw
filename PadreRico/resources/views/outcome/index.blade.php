@extends('layouts.app')
@section('content')
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Main content -->
        <main class="flex-1 bg-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lista de Gastos</h1>
                <a href="{{ route('outcome.create', ['id' => Auth::user()->id]) }}" class="btn btn-danger flex items-center gap-2">
                    <span class="material-icons">add</span>
                    <span>Agregar gasto</span>
                </a>
            </div>

            <div>
                @if ($outcomes->isEmpty())
                    <div class="alert alert-warning text-center">
                        No hay gastos registrados.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($outcomes as $outcome)
                            <div class="bg-white border border-red-200 hover:shadow-lg transition-all p-5 rounded-xl flex flex-col gap-2 card-outcome">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-lg font-semibold text-red-700">{{ $outcome->category }}</h2>
                                    <span class="badge bg-danger text-white px-2 py-1 rounded">{{ $outcome->date->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-2xl font-bold text-red-600 mb-2">${{ number_format($outcome->amount, 2) }}</p>
                                <form
                                    action="{{ route('outcome.destroy', ['id' => Auth::user()->id, 'idOut' => $outcome->id]) }}"
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

                    <div class="mt-4">
                        {{ $outcomes->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection

<style>
.card-outcome:hover {
    box-shadow: 0 0.5rem 1.5rem rgba(220, 53, 69, 0.15);
    transform: translateY(-4px) scale(1.02);
    transition: all 0.2s;
}
</style>
