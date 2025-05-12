<!-- Cambia el color de fondo de la barra de navegación -->
<style>
    .bg-cssecondary {
        background-color: #9ACBD0 !important;
        /* Cambia este color al que usabas antes */
    }
</style>
<nav x-data="{ open: false }" class="bg-cssecondary border-b border-gray-100 text-black">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('user.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-black" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('dashboard')" class="text-black hover:text-gray-100">
                        {{ __('Inicio') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Texto TU PADRE RICO y Logout Button -->
            <div class="hidden sm:flex items-center space-x-8">
                <h1 class="text-black italic text-4xl font-extrabold">
                    TU PADRE RICO
                </h1>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-black hover:text-gray-100 font-bold flex items-center">
                            <span class="material-icons">logout</span>
                        </button>
                    </form>
                @endauth
            </div>

        </div>
    </div>
</nav>
