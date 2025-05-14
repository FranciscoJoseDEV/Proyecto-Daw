@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Personas que me deben dinero</h2>
            <a href="{{ route('defaulter.create', ['id' => Auth::user()->id]) }}" class="btn btn-outline-primary mt-3">
                <i class="bi bi-plus-circle me-1"></i> Agregar Deudor
            </a>
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
                            <a href="{{ route('defaulter.show', ['id' => Auth::user()->id,'idDef' => $defaulter->id,]) }}" class="btn btn-primary mt-2">
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
@endsection
