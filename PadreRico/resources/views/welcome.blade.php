<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-section {
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            margin: 2rem auto;
            max-width: 900px;
            padding: 3rem 2rem;
            position: relative;
            background-color: #fbf0e3;
            border: 1px solid #000000;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .hero-section p {
            color: #374151;
            margin-bottom: 1.5rem;
        }

        .hero-section img {
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.10);
            margin-top: 2rem;
            margin-bottom: 1rem;
            transition: transform 0.3s;
        }

        .hero-section img:hover {
            transform: scale(1.03);
        }

        .hero-section .flex.space-x-4.gap-4 a {
            transition: background 0.2s, transform 0.2s;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.08);
        }

        .hero-section .flex.space-x-4.gap-4 a:hover {
            background: #1e293b !important;
            transform: translateY(-2px) scale(1.05);
        }

        .about-section {
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            margin: 2rem auto;
            max-width: 900px;
            padding: 3rem 2rem;
            color: #fff;
            position: relative;
            border: 1px solid #000000;
        }

        .about-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #f3f4f6;
        }

        .about-section p {
            color: #f3f4f6;
            font-size: 1.15rem;
        }

        .about-section img {
            border: 4px solid #5f5f5d;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.10);
            transition: transform 0.3s;
        }

        .about-section img:hover {
            transform: scale(1.04) rotate(-2deg);
        }

        @media (max-width: 900px) {

            .hero-section,
            .about-section {
                max-width: 98vw;
                padding: 2rem 0.5rem;
            }
        }

        @media (max-width: 600px) {

            .hero-section h1,
            .about-section h2 {
                font-size: 1.5rem;
            }

            .hero-section img,
            .about-section img {
                width: 90vw !important;
                max-width: 320px;
            }
        }
    </style>
</head>

<body class="bg-primary text-gray-800 font-sans flex flex-col min-h-screen">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Botones centrados fuera del contenido principal -->
    <div class="w-full flex justify-center mt-4">
        <div class="flex space-x-4 gap-4">
            <a href="{{ route('login') }}"
                class="px-6 py-3 bg-secondary text-white font-semibold rounded-lg hover:bg-gray-700">
                {{ __('Login') }}
            </a>
            <a href="{{ route('register') }}"
                class="px-6 py-3 bg-secondary text-white font-semibold rounded-lg hover:bg-gray-700">
                {{ __('Registro') }}
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto flex flex-col lg:flex-row gap-8 justify-center items-stretch py-2 ">
            <!-- Hero Section -->
            <section
                class="hero-section flex flex-col items-center justify-center bg-primary p-8 text-center w-full lg:w-1/2">
                <div class="space-y-6">
                    <h1>Gestiona tus Finanzas Inteligentemente</h1>
                    <p class="text-lg md:text-xl text-gray-800 text-justify">
                        Administra tus ingresos, gastos y objetivos de ahorro mientras desbloqueas logros para compartir
                        con amigos y familiares.
                    </p>
                    <p class="text-lg md:text-xl text-gray-800 text-justify">
                        ¿Sabías que el 67% de los jóvenes españoles reconoce no tener conocimientos suficientes sobre
                        educación financiera? Según un estudio de la CNMV, solo 1 de cada 4 jóvenes lleva un control
                        regular de sus gastos e ingresos.
                    </p>
                    <p class="text-lg md:text-xl text-gray-800 text-justify">
                        Además, el 60% de los jóvenes entre 18 y 30 años admite que no sabe cómo ahorrar de manera
                        efectiva y un 45% ha tenido problemas para llegar a fin de mes al menos una vez en el último
                        año.
                    </p>
                    <p class="text-lg md:text-xl text-gray-800 text-justify">
                        Con nuestra plataforma, aprenderás a gestionar tu dinero de forma sencilla y visual, con
                        herramientas adaptadas a tus necesidades y consejos prácticos para mejorar tu salud financiera.
                    </p>
                </div>
                <div class="mt-10 flex justify-center">
                    <img src="{{ asset('imgs/Gestion.png') }}" alt="Gráfica de Finanzas"
                        class="w-3/4 max-w-md rounded-lg shadow-lg">
                </div>
                <p class="text-lg md:text-xl text-gray-800 text-justify">
                    Con resúmenes mensuales y semanales para que no se te escape ningún detalle.
                    Además, podrás comparar tu progreso con el de otros usuarios y descubrir en qué áreas puedes
                    mejorar.
                </p>
                <p class="text-lg md:text-xl text-gray-800 text-justify">
                    Recuerda: <span class="font-semibold text-secondary">el 80% de los jóvenes que empiezan a controlar
                        sus finanzas logran ahorrar más en menos de 6 meses.</span>
                </p>
            </section>

            <!-- About Section -->
            <section
                class="about-section flex flex-col items-center justify-center bg-secondary p-8 text-center w-full lg:w-1/2">
                <div class="space-y-6">
                    <div class="flex justify-center mt-4">
                        <img src="{{ asset('imgs/robertkiyosaki.png') }}" alt="Robert Kiyosaki"
                            class="rounded-full w-60 h-60 object-cover shadow-lg">
                    </div>
                    <div class="text-center">
                        <h2>¿De dónde viene el nombre?</h2>
                        <p class="text-lg md:text-xl text-gray-800 text-justify">
                            Inspirados por el libro "Padre Rico, Padre Pobre" de Robert T. Kiyosaki, nuestro proyecto
                            toma como base la importancia de saber en qué gastas tu dinero y cómo usarlo
                            inteligentemente para hacer que trabaje para ti.
                        </p>
                        <p class="text-lg md:text-xl text-gray-800 text-justify">
                            Nuestra misión es ayudarte a desarrollar hábitos financieros saludables desde joven, para
                            que puedas alcanzar tus metas y evitar los errores más comunes en la gestión del dinero.
                        </p>
                        <p class="text-lg md:text-xl text-gray-800 text-justify">
                            <span class="font-semibold text-primary">¡Empieza hoy a tomar el control de tu futuro
                                financiero!</span>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
