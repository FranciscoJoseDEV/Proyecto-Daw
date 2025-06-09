<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .bg-csprimary {
            background-color: #F2EFE7 !important;
        }

        .bg-csdetails {
            background-color: #48A6A7 !important;
        }

        .bg-cssecondary {
            background-color: #9ACBD0 !important;
        }

        /* Estructura fija */
        .layout-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .layout-main {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        aside {
            width: 250px;
            flex-shrink: 0;
            overflow-y: auto;
        }

        main {
            flex: 1;
            overflow-y: auto;
        }

        footer {
            flex-shrink: 0;
        }
    </style>

    @stack('styles') <!-- Aquí se insertarán los estilos de las vistas -->

    <title>{{ config('TU PADRE RICO', 'TU PADRE RICO') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Otros enlaces y scripts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="layout-container bg-csprimary">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Main Layout -->
        <div class="layout-main">
            <!-- Aside -->
            @include('layouts.aside')

            <!-- Page Content -->
            <main>
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                @yield('content')
                @include('layouts.ia')
            </main>
        </div>
        
        <!-- Footer -->
        @include('layouts.footer')
    </div>
    @stack('scripts') <!-- Aquí se insertarán los scripts de las vistas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>