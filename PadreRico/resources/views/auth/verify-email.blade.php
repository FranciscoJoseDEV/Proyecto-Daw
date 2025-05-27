<x-guest-layout>
    <main class="container mx-auto py-8 max-w-md">
        <header>
            <h1 class="text-2xl font-bold mb-4">Verifica tu correo electrónico</h1>
            <p class="mb-4">Introduce el código de 6 dígitos que te hemos enviado por email.(es posible que este en Spam)</p>
        </header>



        <section class="bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('verification.code') }}">
                @csrf
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium mb-1">Código de verificación </label>
                    <input type="text" id="code" name="code" maxlength="6"
                        class="border rounded px-3 py-2 w-full" required autofocus>
                    @error('code')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success text-black px-4 py-2 rounded w-full">Verificar</button>
            </form>

            <form method="POST" action="{{ route('verification.resend') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="underline text-csprimary">Reenviar código</button>
            </form>
        </section>
    </main>
</x-guest-layout>
