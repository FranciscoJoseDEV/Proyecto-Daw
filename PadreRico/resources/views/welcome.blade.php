<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary text-gray-800 font-sans flex flex-col min-h-screen">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main class="flex-grow">

        <!-- Hero Section -->
        <section class="flex flex-col items-center justify-center min-h-screen bg-primary p-8 text-center">
            <div class="mt-8 flex space-x-4 gap-4">
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-secondary text-white font-semibold rounded-lg hover:bg-gray-700">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-secondary text-white font-semibold rounded-lg hover:bg-gray-700">
                    {{ __('Registro') }}
                </a>
            </div>
            <div class="space-y-6">
                <h1>Gestiona tus Finanzas Inteligentemente</h1>
                <p class="text-lg md:text-xl text-gray-800 text-justify">Administra tus ingresos, gastos y objetivos de
                    ahorro
                    mientras desbloqueas logros para compartir con amigos y familiares.</p>
            </div>
            <div class="mt-10 flex justify-center">
                <img src="{{ asset('imgs/grafico.png') }}" alt="Gráfica de Finanzas" class="w-3/4 max-w-md">
            </div>
            <p class="text-lg md:text-xl text-gray-800 text-justify">Con resumenes mensuales y semanales para que no se
                te escape ningun detalle</p>



        </section>

        <!-- About Section -->
        <section class="flex flex-col items-center justify-center min-h-screen bg-secondary p-8 text-center">
            <div class="space-y-6">
                <div class="flex justify-center">
                    <img src="{{ asset('imgs/robertkiyosaki.png') }}" alt="Robert Kiyosaki"
                        class="rounded-full w-60 h-60 object-cover shadow-lg">
                </div>
                <h2>¿De dónde viene el nombre?</h2>
                <p class="text-lg md:text-xl text-gray-800 text-justify">Inspirados por el libro "Padre Rico, Padre
                    Pobre" de
                    Robert T. Kiyosaki, nuestro proyecto toma como base la importancia de saber <br> en qué gastas tu
                    dinero y cómo
                    usarlo inteligentemente para hacer que trabaje para ti.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    @include('layouts.footer')
</body>

</html>
