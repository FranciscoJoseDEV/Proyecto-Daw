@extends('layouts.app')
@section('content')
    <div x-data="{ open: false, showOtherCategory: false }" class="flex h-screen">
        <main class="flex-1 bg-gray-100 p-6">
            <h1 class="text-center mb-4">Agregar Nuevo Ingreso</h1>
            <form action="{{ route('income.store', ['id' => Auth::user()->id]) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="category" class="block text-gray-700">Categoría</label>
                    <select name="category" id="category" required class="border border-gray-300 rounded p-2 w-full"
                        x-on:change="showOtherCategory = ($event.target.value === 'other')">
                        <option value="" disabled selected>Seleccione una categoría</option>
                        <option value="Salario">Salario</option>
                        <option value="Inversión">Inversión</option>
                        <option value="Regalo">Regalo</option>
                        <option value="Venta">Venta</option>
                        <option value="other">Otra</option>
                    </select>
                    <input type="text" name="other_category" id="other_category" placeholder="Especifique la categoría"
                        x-show="showOtherCategory" x-bind:required="showOtherCategory"
                        class="border border-gray-300 rounded p-2 w-full mt-2">
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700">Monto</label>
                    <input type="number" name="amount" id="amount" required step="0.01"
                        class="border border-gray-300 rounded p-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700">Fecha</label>
                    <input type="date" name="date" id="date" required
                        class="border border-gray-300 rounded p-2 w-full" value="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700">Tipo</label>
                    <input type="text" name="type" id="type" required
                        class="border border-gray-300 rounded p-2 w-full">
                </div>
                <button type="submit" class="bg-cssecondary text-black px-4 py-2 rounded ">Agregar
                    Ingreso</button>
            </form>
            <div class="text-center mt-4">
                <a href="{{ route('income.index', ['id' => Auth::user()->id]) }}" class="btn bg-cssecondary text-black px-4 py-2 rounded">Volver</a>
            </div>
        </main>
    </div>
@endsection
