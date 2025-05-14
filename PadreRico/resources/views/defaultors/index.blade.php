@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Personas a las que les debo dinero</h2>
        </div>

        <div class="row justify-content-center">
            @forelse ($debts as $debt)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 d-flex">
                    <div class="card shadow-sm w-100 border-0">
                        <img src="{{ $debt->beneficiary->img ? asset('storage/' . $debt->beneficiary->img) : asset('imgs/9187604.png') }}"
                            class="card-img-top p-3" style="height: 250px; object-fit: contain; border-radius: 1rem;"
                            alt="{{ $debt->beneficiary->name }}">

                        <div class="card-body text-center">
                            <h5 class="card-title fw-semibold">{{ $debt->beneficiary->name }}</h5>
                            <p class="card-text text-muted mb-1">{{ $debt->beneficiary->email }}</p>
                            <p class="card-text fs-5 text-danger mb-1">{{ number_format($debt->amount, 2) }}€</p>
                            <small class="text-muted d-block">Desde: {{ \Carbon\Carbon::parse($debt->inicial_date)->format('d/m/Y') }}</small>
                            <small class="text-muted d-block">Hasta: {{ \Carbon\Carbon::parse($debt->due_date)->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No tienes deudas registradas actualmente.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $debts->links() }}
        </div>
    </div>
@endsection
