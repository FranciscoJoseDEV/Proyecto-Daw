@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-5">
        <h1 class="text-3xl font-bold mb-5 text-center">Objetivo de Ahorro</h1>

        {{-- Mensajes de error y felicitación --}}
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        @if (isset($felicitacion))
            <div
                class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center justify-between">
                <span>{{ $felicitacion }}</span>
                <button type="button"
                    class="ml-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#crearObjetivoModal">
                    Crear nuevo objetivo
                </button>
            </div>
        @endif

        {{-- Tarjeta de objetivo o mensaje de bienvenida --}}
        @if ($objective)
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-lg-10">
                    <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-100">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2 mb-md-0">{{ $objective->objective_name }}</h2>
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#editarObjetivoModal">
                                <span class="material-icons me-1">edit</span> Editar objetivo
                            </button>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded p-3 text-center h-100">
                                    <div class="text-xs text-gray-500 mb-1">
                                        <span class="material-icons text-green-500">flag</span> Meta
                                    </div>
                                    <div class="fw-bold text-success fs-4">
                                        {{ number_format($objective->goal_amount, 2) }}€
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded p-3 text-center h-100">
                                    <div class="text-xs text-gray-500 mb-1">
                                        <span class="material-icons text-blue-500">savings</span> Ahorrado
                                    </div>
                                    <div class="fw-bold text-primary fs-4">
                                        {{ number_format($objective->user->savings ?? 0, 2) }}€
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded p-3 text-center h-100">
                                    <div class="text-xs text-gray-500 mb-1">
                                        <span class="material-icons text-danger">hourglass_bottom</span> Restante
                                    </div>
                                    <div class="fw-bold text-danger fs-4">
                                        {{ number_format($restante, 2) }}€
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded p-3 text-center h-100">
                                    <div class="text-xs text-gray-500 mb-1">
                                        <span class="material-icons text-purple-500">event</span> Días restantes
                                    </div>
                                    <div class="fw-bold text-purple-600 fs-4">
                                        {{ $diasRestantes >= 0 ? $diasRestantes : 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Progreso</span>
                                <span class="fw-bold">{{ $progreso }}%</span>
                            </div>
                            <div class="progress" style="height: 22px;">
                                <div class="progress-bar bg-{{ $progressColor }}"
                                    role="progressbar"
                                    style="width: {{ $progreso }}%;"
                                    aria-valuenow="{{ $progreso }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $progreso }}%
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 mb-0">
                            <span class="fw-semibold">Fecha límite:</span>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($objective->date_limit)->format('d/m/Y') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center text-gray-500">
                No tienes ningún objetivo de ahorro aún.
                <button type="button"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#crearObjetivoModal">
                    Crear objetivo
                </button>
            </div>
        @endif

        <!-- Modal Crear Objetivo -->
        <div class="modal fade" id="crearObjetivoModal" tabindex="-1" aria-labelledby="crearObjetivoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content shadow-lg rounded-4 border-0">
                    <div class="modal-header bg-cssecondary bg-opacity-10 border-0 rounded-top">
                        <span class="material-icons text-primary me-2" style="font-size: 2rem;">add_circle</span>
                        <h5 class="modal-title text-primary fw-bold" id="crearObjetivoModalLabel">Crear nuevo objetivo de
                            ahorro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="{{ route('savingsobj.store', auth()->id()) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nombre del objetivo</label>
                                <input type="text" name="objective_name" required
                                    class="form-control form-control-lg rounded-pill">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cantidad meta (€)</label>
                                <input type="number" name="goal_amount" min="1" step="0.01" required
                                    class="form-control form-control-lg rounded-pill">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha límite</label>
                                <input type="date" name="date_limit" required
                                    class="form-control form-control-lg rounded-pill">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Objetivo -->
        @if ($objective)
            <div class="modal fade" id="editarObjetivoModal" tabindex="-1" aria-labelledby="editarObjetivoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content shadow-lg rounded-4 border-0">
                        <div class="modal-header bg-cssecondary bg-opacity-10 border-0 rounded-top">
                            <span class="material-icons text-black me-2" style="font-size: 2rem;">edit</span>
                            <h5 class="modal-title text-black fw-bold" id="editarObjetivoModalLabel">Editar objetivo de
                                ahorro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <form action="{{ route('savingsobj.update', $objective->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nombre del objetivo</label>
                                    <input type="text" name="objective_name" value="{{ $objective->objective_name }}"
                                        required class="form-control form-control-lg rounded-pill">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cantidad meta (€)</label>
                                    <input type="number" name="goal_amount" min="1" step="0.01"
                                        value="{{ $objective->goal_amount }}" required
                                        class="form-control form-control-lg rounded-pill">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fecha límite</label>
                                    <input type="date" name="date_limit"
                                        value="{{ \Carbon\Carbon::parse($objective->date_limit)->format('Y-m-d') }}"
                                        required class="form-control form-control-lg rounded-pill">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn bg-cssecondary px-4">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
