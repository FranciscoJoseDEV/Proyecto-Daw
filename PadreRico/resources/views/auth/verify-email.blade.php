@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Verifica tu correo electrónico</h1>
    <p class="mb-4">Introduce el código de 6 dígitos que te hemos enviado por email.</p>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf
        <input type="text" name="code" maxlength="6" class="border rounded px-3 py-2 mb-2" required autofocus>
        @error('code')
            <div class="text-red-600 mb-2">{{ $message }}</div>
        @enderror
        <button type="submit" class="bg-csprimary text-white px-4 py-2 rounded">Verificar</button>
    </form>
    <form method="POST" action="{{ route('verification.resend') }}" class="mt-4">
        @csrf
        <button type="submit" class="underline text-csprimary">Reenviar código</button>
    </form>
</div>
@endsection
