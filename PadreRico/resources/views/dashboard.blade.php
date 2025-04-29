<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen">
        <!-- Botón para mostrar/ocultar el menú -->
        <button @click="open = !open"
            class="absolute top-4 left-4 z-10 bg-gray-800 text-white p-2 rounded-md focus:outline-none md:hidden">
            <span x-show="!open" class="material-icons">menu</span>
            <span x-show="open" class="material-icons">close</span>
        </button>

        <!-- Barra lateral -->
        @include('layouts.aside')

        <!-- Contenido principal -->
        <main class="flex-1 bg-gray-100 p-6">
            <h1 class="text-2xl font-bold mb-6">Dashboard de Finanzas</h1>

            <!-- Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Balance Actual</h2>
                    <p class="text-2xl font-bold text-green-500">$12,345.67</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Ingresos</h2>
                    <p class="text-2xl font-bold text-blue-500">$5,000.00</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Gastos</h2>
                    <p class="text-2xl font-bold text-red-500">$3,200.00</p>
                </div>
            </div>

            <!-- Transacciones recientes -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Transacciones Recientes</h2>
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Fecha</th>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Categoría</th>
                            <th class="px-4 py-2">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">2025-04-28</td>
                            <td class="border px-4 py-2">Pago de alquiler</td>
                            <td class="border px-4 py-2">Gastos</td>
                            <td class="border px-4 py-2 text-red-500">-$1,200.00</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">2025-04-27</td>
                            <td class="border px-4 py-2">Salario</td>
                            <td class="border px-4 py-2">Ingresos</td>
                            <td class="border px-4 py-2 text-green-500">+$3,000.00</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">2025-04-26</td>
                            <td class="border px-4 py-2">Compra de supermercado</td>
                            <td class="border px-4 py-2">Gastos</td>
                            <td class="border px-4 py-2 text-red-500">-$150.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    @include('layouts.footer')
</x-app-layout>
