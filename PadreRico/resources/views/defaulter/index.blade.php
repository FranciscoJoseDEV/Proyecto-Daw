@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="row justify-content-center w-100">
        @foreach ($defaulters as $defaulter)
            <div class="col-md-4 col-sm-6 mb-4 d-flex justify-content-center"> <!-- Ajuste dinámico del tamaño -->
                <div class="card text-center" style="width: 18rem;"> <!-- Tamaño fijo para las tarjetas -->
                    <img src="{{ asset('imgs/9187604.png') }}" class="card-img-top mx-auto mt-4" 
                         style="width: 250px; height: 250px; object-fit: cover;" 
                         alt="{{ $defaulter->name }}">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;">{{ $defaulter->name }}</h5>
                        <p class="card-text" style="font-size: 1.25rem;">Amount: ${{ number_format($defaulter->amount, 2) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $defaulters->links() }}
    </div>
</div>
@endsection
