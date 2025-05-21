@extends('layouts.app')
@section('content')
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Main content -->
        <main class="flex-1 bg-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lista de Gastos</h1>
                <div class="flex gap-2 mt-4 mb-6">
                    <a href="{{ route('outcome.index', ['id' => Auth::user()->id]) }}"
                        class="btn btn-outline-danger {{ request('filtro') === null ? 'active' : '' }}">
                        Todos
                    </a>
                    <a href="{{ route('outcome.index', ['id' => Auth::user()->id, 'filtro' => 'recurrentes']) }}"
                        class="btn btn-outline-danger {{ request('filtro') === 'recurrentes' ? 'active' : '' }}">
                        Recurrentes
                    </a>
                    <a href="{{ route('outcome.index', ['id' => Auth::user()->id, 'filtro' => 'no_recurrentes']) }}"
                        class="btn btn-outline-danger {{ request('filtro') === 'no_recurrentes' ? 'active' : '' }}">
                        No recurrentes
                    </a>
                </div>

                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-danger flex items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#createOutcomeModal">
                    <span class="material-icons">add</span>

                </button>
            </div>

            <div>
                @if ($outcomes->isEmpty())
                    <div class="alert alert-warning text-center">
                        No hay gastos registrados.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($outcomes as $outcome)
                            <div
                                class="bg-white  hover:shadow-lg transition-all p-3 rounded-xl flex flex-col gap-2 card-outcome">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-lg font-semibold text-red-700">{{ $outcome->category }}</h2>
                                    <span
                                        class="badge bg-danger text-white px-2 py-1 rounded">{{ $outcome->date->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-2xl font-bold text-red-600 mb-2">${{ number_format($outcome->amount, 2) }}
                                </p>
                                <form
                                    action="{{ route('outcome.destroy', ['id' => Auth::user()->id, 'idOut' => $outcome->id]) }}"
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

                    <div class="mt-4">
                        {{ $outcomes->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Modal de crear gasto -->
    <div class="modal fade" id="createOutcomeModal" tabindex="-1" aria-labelledby="createOutcomeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <div class="modal-header bg-danger bg-opacity-10 border-0 rounded-top">
                    <span class="material-icons text-danger me-2" style="font-size: 2rem;">add_circle</span>
                    <h5 class="modal-title text-danger fw-bold" id="createOutcomeModalLabel">Agregar Nuevo Gasto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form action="{{ route('outcome.store', ['id' => Auth::user()->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select name="category" id="category" required class="form-select form-select-lg"
                                onchange="document.getElementById('otherCategoryInput').style.display = this.value === 'Other' ? 'block' : 'none'">
                                <option value="" disabled selected>Seleccione una categoría</option>
                                <option value="Alimentación">Alimentación</option>
                                <option value="Vivienda">Vivienda</option>
                                <option value="Transporte">Transporte</option>
                                <option value="Entretenimiento">Entretenimiento</option>
                                <option value="Educación">Educación</option>
                                <option value="Salud">Salud</option>
                                <option value="Ropa">Ropa</option>
                                <option value="Other">Otra</option>
                            </select>
                            <input type="text" name="other_category" id="otherCategoryInput"
                                placeholder="Especifique la categoría" class="form-control form-control-lg mt-2"
                                style="display:none;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">¿Es un gasto recurrente?</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recurrent" id="recurrentYes"
                                    value="1" required>
                                <label class="form-check-label" for="recurrentYes">Sí</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recurrent" id="recurrentNo"
                                    value="0" required>
                                <label class="form-check-label" for="recurrentNo">No</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Monto</label>
                            <input type="number" name="amount" min="0" id="amount" required step="0.01"
                                class="form-control form-control-lg">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" name="date" id="date" required
                                class="form-control form-control-lg" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" name="description" id="description" required
                                class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger px-4">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .card-outcome:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(220, 53, 69, 0.15);
        transform: translateY(-4px) scale(1.02);
        transition: all 0.2s;
    }


    .card-outcome {
        border: 2px solid #dc3545 !important;
        border-radius: 5px;
    }
</style>
