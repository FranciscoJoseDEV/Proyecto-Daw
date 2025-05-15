@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-1">Personas a las que les debes dinero</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse ($debts as $debt)
                <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
                    <div class="card shadow-sm border-0 w-100 h-100 transition-all" style="border-radius: 1rem;">
                        <img src="{{ $debt->beneficiary->img ? asset('storage/' . $debt->beneficiary->img) : asset('imgs/9187604.png') }}"
                            class="card-img-top" style="height: 220px; object-fit: contain; border-radius: 1rem 1rem 0 0;"
                            alt="{{ $debt->beneficiary->name }}">
                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title fw-semibold mb-1">{{ $debt->beneficiary->name }}</h5>
                            <p class="card-text text-muted mb-1">{{ $debt->beneficiary->email }}</p>
                            <p class="card-text fs-5 mb-3"
                                style="color: #dc3545; background: #f8d7da; border-radius: .5rem;">
                                {{ number_format($debt->amount, 2) }}€
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
                    <p class="text-muted">No tienes deudas registradas actualmente.</p>
                </div>
            @endforelse
        </div>

        <style>
            .card.transition-all:hover {
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
                transform: translateY(-4px) scale(1.02);
                transition: all 0.2s;
            }
        </style>

        <div class="d-flex justify-content-center mt-4">
            {{ $debts->links() }}
        </div>
    </div>
@endsection
