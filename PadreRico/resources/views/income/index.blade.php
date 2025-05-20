@extends('layouts.app')
@section('content')
    <div class="flex min-h-screen bg-gray-100">
        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lista de Ingresos</h1>
                <!-- Botón para abrir la modal -->
                <button type="button" class="btn btn-success flex items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#createIncomeModal">
                    <span class="material-icons">add</span>
                </button>
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
                                class="bg-white hover:shadow-lg transition-all p-5 rounded-xl flex flex-col gap-2 card-income">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-lg font-semibold text-green-700">{{ $income->category }}</h2>
                                    <span
                                        class="badge bg-success text-black px-2 py-1 rounded">{{ $income->date->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-2xl font-bold text-green-600 mb-2">{{ number_format($income->amount, 2) }} €
                                </p>
                                {{-- Descripción --}}
                                <p class="text-gray-600 mb-2">
                                    {{ $income->description ?? 'Sin descripción' }}
                                </p>
                                <form
                                    action="{{ route('income.destroy', ['id' => Auth::user()->id, 'idInc' => $income->id]) }}"
                                    method="POST" class="mt-auto flex justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger flex items-center gap-1">
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

    <!-- Modal de crear ingreso -->
    <div class="modal fade" id="createIncomeModal" tabindex="-1" aria-labelledby="createIncomeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header bg-cssecondary bg-opacity-10 border-0 rounded-top">
                    <span class="material-icons text-success me-2" style="font-size: 2rem;">add_circle</span>
                    <h5 class="modal-title text-success fw-bold" id="createIncomeModalLabel">Agregar Nuevo Ingreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form action="{{ route('income.store', ['id' => Auth::user()->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select name="category" id="incomeCategory" required class="form-select form-select-lg"
                                onchange="document.getElementById('otherIncomeCategoryInput').style.display = this.value === 'other' ? 'block' : 'none'">
                                <option value="" disabled selected>Seleccione una categoría</option>
                                <option value="Salario">Salario</option>
                                <option value="Inversión">Inversión</option>
                                <option value="Regalo">Regalo</option>
                                <option value="Venta">Venta</option>
                                <option value="other">Otra</option>
                            </select>
                            <input type="text" name="other_category" id="otherIncomeCategoryInput"
                                placeholder="Especifique la categoría" class="form-control form-control-lg mt-2"
                                style="display:none;">
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Monto</label>
                            <input type="number" name="amount" min="0" id="incomeAmount" required step="0.01"
                                min="0" class="form-control form-control-lg">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" name="date" id="incomeDate" required
                                class="form-control form-control-lg" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <input type="text" name="type" id="incomeType" required
                                class="form-control form-control-lg">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" name="description" id="incomeDescription" required
                                class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<style>
    .card-income:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(16, 185, 129, 0.15);
        transform: translateY(-4px) scale(1.02);
        transition: all 0.2s;
    }

    .card-income {
        border: 2px solid #157347 !important;
        border-radius: 5px;
    }

    .modal-content {
        border-radius: 1.5rem;
    }

    .modal-header {
        border-bottom: none;
        align-items: center;
    }

    .modal-title {
        flex: 1;
    }

    .modal-footer {
        border-top: none;
    }
</style>
