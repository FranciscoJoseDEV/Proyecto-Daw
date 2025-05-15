<aside x-data="{ open: false, subOpen: false, statsOpen: false }"
    class="bg-cssecondary text-black flex flex-col transform transition-transform duration-300 md:translate-x-0"
    :class="{ 'w-64': open, 'w-12': !open }" @mouseenter="open = true" @mouseleave="open = false">

    <!-- Cierra el submenú cuando el sidebar se cierre -->
    <div x-effect="if (!open) subOpen = false"></div>
    <div x-effect="if (!open) statsOpen = false"></div>


    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="top-0">
            <!-- Otros enlaces -->
            <li class="mb-4">
                <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="material-icons mr-2">person</span>
                    <span x-show="open" class="transition-opacity duration-300">&nbsp;Perfil</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('user.dashboard') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="material-icons mr-2">dashboard</span>
                    <span x-show="open" class="transition-opacity duration-300">&nbsp;Dashboard</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('income.index', ['id' => Auth::user()->id]) }}"
                    class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="material-icons mr-2">trending_up</span>
                    <span x-show="open" class="transition-opacity duration-300">&nbsp;Ingresos</span>
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('outcome.index', ['id' => Auth::user()->id]) }}"
                    class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="material-icons mr-2">trending_down</span>
                    <span x-show="open" class="transition-opacity duration-300">&nbsp;Gastos</span>
                </a>
            </li>

            <!-- Menú desplegable para Deudores -->
            <li class="mb-4">
                <button @click="subOpen = !subOpen"
                    class="flex items-center p-2 rounded hover:bg-gray-700 focus:outline-none">
                    <span class="material-icons mr-2">payments</span>
                    <span x-show="open" class="transition-opacity duration-300 flex-1 text-left">&nbsp;Deudas</span>
                    <span x-show="open" class="material-icons ml-auto transition-transform duration-300"
                        :class="{ 'rotate-45': subOpen }">keyboard_arrow_down</span>
                </button>

                <!-- Submenú -->
                <ul x-show="subOpen" x-collapse class="ml-8 mt-2 space-y-2" x-cloak>
                    <li>
                        <a href="{{ route('defaultors.index', ['id' => Auth::user()->id]) }}"
                            class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                            <span class="material-icons text-sm">receipt_long</span>
                            <span>Mis deudas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('defaulter.index', ['id' => Auth::user()->id]) }}"
                            class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                            <span class="material-icons text-sm">account_balance_wallet</span>
                            <span>Mis deudores</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Menú desplegable para Estadísticas -->
            <li class="mb-4">
                <button @click="statsOpen = !statsOpen"
                    class="flex items-center p-2 rounded hover:bg-gray-700 focus:outline-none">
                    <span class="material-icons mr-2">pie_chart</span>
                    <span x-show="open" class="transition-opacity duration-300 flex-1 text-left">&nbsp;Estadísticas</span>
                    <span x-show="open" class="material-icons ml-auto transition-transform duration-300"
                        :class="{ 'rotate-45': statsOpen }">keyboard_arrow_down</span>
                </button>
                <!-- Submenú -->
                <ul x-show="statsOpen" x-collapse class="ml-8 mt-2 space-y-2" x-cloak>
                    <li>
                        <a href="{{ route('statistics.index_monthly', ['id' => Auth::user()->id]) }}"
                            class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                            <span class="material-icons text-sm">calendar_month</span>
                            <span>Mensuales</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('statistics.index_weekly', ['id' => Auth::user()->id]) }}"
                            class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                            <span class="material-icons text-sm">calendar_view_week</span>
                            <span>Semanales</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
