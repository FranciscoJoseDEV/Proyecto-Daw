{{-- resources/views/deudas/create.blade.php --}}
@extends('layouts.app')

@section('content')

    <section class="max-w-4xl mx-auto p-6 bg-csprimary rounded-md shadow-md">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">Por favor, corrige los errores a continuación.</span>
            </div>
            <ul class="mt-2 text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Crear Nueva Deuda</h2>

        <form action="{{ route('defaulter.store', ['id' => Auth::user()->id]) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <input type="hidden" name="beneficiary_user_id" id="beneficiary_user_id"
                        value="{{ Auth::user()->id }}">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico </label>
                    <input type="email" name="email" id="email"
                        placeholder="(Debe coincir con el de su cuenta de padre rico)"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="6"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="inicial_date" class="block text-sm font-medium text-gray-700">Fecha Inicial</label>
                    <input type="date" name="inicial_date" id="inicial_date" value="{{ date('Y-m-d') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
                    <input type="date" name="due_date" id="due_date"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-cssecondary text-black rounded-md hover:bg-teal-700 transition">Guardar</button>
            </div>
        </form>
    </section>
@endsection
