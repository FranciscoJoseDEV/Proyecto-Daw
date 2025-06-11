@extends('layouts.app')

@section('content')
    <div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="w-100" style="max-width: 1100px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2">Personas a las que les debes dinero</h2>
                <p class="text-muted mb-0" style="max-width: 600px; margin: 0 auto;">
                    Si tienes deudas pendientes de aceptar y la aceptas te saldrá hasta que el otro usuario reciba el dinero. Si
                    la rechazas, a él le saldrá que la has rechazado.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                @forelse ($debts as $debt)
                    <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
                        <div class="card shadow-sm border-0 w-150 h-100 transition-all" style="border-radius: 1rem;">
                            <img src="{{ $debt->beneficiary->img ? asset('storage/' . $debt->beneficiary->img) : asset('imgs/9187604.png') }}"
                                class="card-img-top rounded-circle mx-auto mt-3"
                                style="height: 120px; width: 120px; object-fit: cover; border-radius: 50%;"
                                alt="{{ $debt->beneficiary->name }}">
                            <div class="card-body d-flex flex-column text-center p-4">
                                <h5 class="card-title fw-semibold mb-1">{{ $debt->beneficiary->name }}</h5>
                                <p class="card-text text-muted mb-1 small">{{ $debt->beneficiary->email }}</p>
                                <p class="card-text fs-5 mb-3"
                                    style="color: #842029; background: #f8d7da; border-radius: .5rem; font-weight: bold;">
                                    {{ number_format($debt->amount, 2) }}€
                                </p>
                                @if ($debt->accepted == 0)
                                    <div class="mb-2">
                                        <span class="badge bg-warning text-dark mb-2">Pendiente de aceptar</span>
                                    </div>
                                    <form action="{{ route('defaultors.accept', ['id' => Auth::id(), 'debt' => $debt->id]) }}"
                                        method="POST" class="d-flex justify-content-center gap-2 mb-2">
                                        @csrf
                                        <button type="submit" name="action" value="accept"
                                            class="btn btn-success btn-sm">Aceptar</button>
                                        <button type="submit" name="action" value="reject"
                                            class="btn btn-danger btn-sm">Rechazar</button>
                                    </form>
                                @elseif($debt->accepted == 2)
                                    <span class="badge bg-danger mb-2">Rechazada</span>
                                @endif
                                <p class="card-text text-secondary mb-2" style="min-height: 2.5em;">
                                    {{ $debt->description ?? 'Sin descripción' }}
                                </p>
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Desde:
                                        {{ \Carbon\Carbon::parse($debt->inicial_date)->format('d/m/Y') }}</small>
                                    <small class="text-muted">Hasta:
                                        {{ \Carbon\Carbon::parse($debt->due_date)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info mt-4" role="alert">
                            <i class="bi bi-emoji-smile"></i> No tienes deudas registradas actualmente.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center my-5">
                {{ $debts->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card.transition-all:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
            transform: translateY(-4px) scale(1.02);
            transition: all 0.2s;
        }
    </style>
@endpush
