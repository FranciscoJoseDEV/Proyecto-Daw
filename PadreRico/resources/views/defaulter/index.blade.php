@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Personas que me deben dinero</h2>
            <!-- Botón para abrir el modal -->
            <button type="button" class="btn btn-outline-primary mt-3" data-bs-toggle="modal"
                data-bs-target="#createDefaulterModal">
                <i class="bi bi-plus-circle me-1"></i> Agregar Deudor
            </button>
        </div>

        <div class="row justify-content-center">
            @forelse ($defaulters as $defaulter)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 d-flex">
                    <div class="card shadow-sm w-100 border-0">
                        <img src="{{ $defaulter->debtor->img ? asset('storage/' . $defaulter->debtor->img) : asset('imgs/9187604.png') }}"
                            class="card-img-top p-3" style="height: 250px; object-fit: contain; border-radius: 1rem;"
                            alt="{{ $defaulter->debtor->name }}">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">{{ $defaulter->debtor->name }}</h5>
                            <p class="card-text fs-5 text-muted">{{ number_format($defaulter->amount, 2) }}€</p>
                            <a href="{{ route('defaulter.show', ['id' => Auth::user()->id, 'idDef' => $defaulter->id]) }}"
                                class="btn btn-primary mt-2">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No hay deudores registrados aún.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $defaulters->links() }}
        </div>
    </div>

    <!-- Modal Mejorado -->
    <div class="modal fade" id="createDefaulterModal" tabindex="-1" aria-labelledby="createDefaulterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-cssecondary text-black rounded-top-4">
                    <h2 class="modal-title fs-5" id="createDefaulterModalLabel">
                        <i class="bi bi-person-plus me-2"></i>Crear Nueva Deuda
                    </h2>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <strong>¡Error!</strong> Por favor, corrige los errores a continuación.
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('defaulter.store', ['id' => Auth::user()->id]) }}" method="POST"
                        id="createDefaulterForm">
                        @csrf
                        <input type="hidden" name="beneficiary_user_id" value="{{ Auth::user()->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" name="email" id="email"
                                    placeholder="(Usa el de su cuenta de padre rico)" class="form-control  shadow-sm"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Monto</label>
                                <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00"
                                    class="form-control  shadow-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inicial_date" class="form-label">Fecha Inicial</label>
                                <input type="date" name="inicial_date" id="inicial_date" value="{{ date('Y-m-d') }}"
                                    class="form-control  shadow-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                                <input type="date" name="due_date" id="due_date" class="form-control  shadow-sm"
                                    required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea name="description" id="description" rows="3" class="form-control  shadow-sm"></textarea>
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2 rounded-pill"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn bg-cssecondary rounded-pill px-4">
                                <i class="bi bi-save me-1"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
