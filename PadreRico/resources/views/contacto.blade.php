{{-- filepath: c:\Users\frand\Documents\Proyecto Daw\PadreRico\resources\views\contacto.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-2 text-csprimary">Contáctanos</h1>
        <p class="text-gray-600 mb-8 text-lg">¿Tienes alguna pregunta o sugerencia? Rellena el formulario o utiliza los datos
            de contacto para comunicarte.</p>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">Formulario de contacto</h2>
            <form method="POST" action="{{ route('contacto.enviar') }}">
                @csrf
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                        value="{{ old('nombre', Auth::user()->name ?? '') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-csprimary"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Correo electrónico</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', Auth::user()->email ?? '') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-csprimary"
                        required>
                </div>
                <div class="mb-4">
                    <label for="mensaje" class="block text-gray-700 font-semibold mb-2">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-csprimary" required></textarea>
                </div>
                <button type="submit"
                    class="bg-cssecondary text-white px-6 py-2 rounded hover:bg-csprimary-dark transition">Enviar</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">Información de contacto</h2>
            <ul class="mb-4 text-gray-700">
                <li><strong>Email:</strong> franciscojosesanchezlloret@gmail.com</li>
                <li><strong>Teléfono:</strong> +34 680 970 259</li>
                <li><strong>Centro:</strong> IES Mar de Cádiz, Av. de la Constitución, 11540 El Puerto de Santa María, Cádiz
                </li>
            </ul>

        </div>
    </div>
@endsection
