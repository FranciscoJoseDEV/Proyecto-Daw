@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h3 class="fw-bold mb-0">Detalle del Deudor</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-left mb-4">
                        <img src="{{ $defaulter->debtor->img ? asset('storage/' . $defaulter->debtor->img) : asset('imgs/9187604.png') }}"
                             alt="{{ $defaulter->debtor->name }}"
                             class="rounded-circle me-4" style="width: 220px; height: 220px; object-fit: cover;">
                        <div class="text-start">
                            <h4 class="mb-1">{{ $defaulter->debtor->name }}</h4>
                            <p class="text-muted mb-0">{{ $defaulter->debtor->email }}</p>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Descripción:</strong> {{ $defaulter->description ?? 'Sin descripción' }}</li>
                        <li class="list-group-item"><strong>Monto:</strong> {{ number_format($defaulter->amount, 2) }}€</li>
                        <li class="list-group-item"><strong>Desde:</strong> {{ \Carbon\Carbon::parse($defaulter->inicial_date)->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>Hasta:</strong> {{ \Carbon\Carbon::parse($defaulter->due_date)->format('d/m/Y') }}</li>
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="{{ route('defaulter.index', ['id' => auth()->id()]) }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection