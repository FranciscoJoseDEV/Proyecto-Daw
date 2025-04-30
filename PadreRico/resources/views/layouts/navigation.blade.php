<nav x-data="{ open: false }" class="bg-secondary border-b border-gray-100 text-black">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-black" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-black hover:text-gray-100">
                        {{ __('Inicio') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Texto TU PADRE RICO -->
            <div class="hidden sm:flex items-center">
                <h1 class="text-black italic text-4xl font-extrabold">
                    TU PADRE RICO
                </h1>
            </div>
        </div>
    </div>
</nav>
