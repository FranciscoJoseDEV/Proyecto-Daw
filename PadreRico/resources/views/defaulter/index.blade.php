@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex flex-column align-items-center mb-5">
            <h2 class="fw-bold mb-3">Personas que te deben dinero</h2>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#createDefaulterModal">
                <i class="bi bi-plus-circle me-1"></i> Agregar Deudor
            </button>
        </div>

        <div class="row justify-content-center g-4">
            @forelse ($defaulters as $defaulter)
                <div class="col-xl-3 col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="card shadow-sm w-100 border-0 h-100">
                        <img src="{{ $defaulter->debtor->img ? asset('storage/' . $defaulter->debtor->img) : asset('imgs/9187604.png') }}"
                            class="card-img-top rounded-circle mx-auto mt-3"
                            style="height: 120px; width: 120px; object-fit: cover; border-radius: 50%;"
                            alt="{{ $defaulter->debtor->name }}">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">{{ $defaulter->debtor->name }}</h5>
                            <p class="card-text fs-5 text-muted">{{ number_format($defaulter->amount, 2) }}€</p>
                            {{-- Estado de la deuda --}}
                            @if ($defaulter->accepted == 0)
                                <span class="badge bg-warning text-dark mb-3 px-3 py-2">Pendiente de aceptar</span>
                            @elseif ($defaulter->accepted == 1)
                                <span class="badge bg-success mb-3 px-3 py-2">Aceptada</span>
                            @elseif ($defaulter->accepted == 2)
                                <span class="badge bg-danger mb-3 px-3 py-2">Cancelada</span>
                            @endif
                            <div class="d-flex justify-content-center gap-2 mt-2">
                                <a href="{{ route('defaulter.show', ['id' => Auth::user()->id, 'idDef' => $defaulter->id]) }}"
                                    class="btn btn-primary">
                                    Ver detalles
                                </a>
                                <form action="{{ route('defaulter.destroy', ['id' => Auth::user()->id, 'idDef' => $defaulter->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este deudor?')">
                                        <span class="material-icons align-middle">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No hay deudores registrados aún.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center my-5">
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
