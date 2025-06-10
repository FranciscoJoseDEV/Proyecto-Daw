<aside x-data="{ open: false, subOpen: false, statsOpen: false }"
    :class="open ? 'aside-transition open' : 'aside-transition'"
    class="bg-cssecondary text-black flex flex-col overflow-hidden"
    @mouseenter="open = true"
    @mouseleave="open = false">

    <!-- Cierra los submenús cuando el sidebar se cierre -->
    <div x-effect="if (!open) subOpen = false"></div>
    <div x-effect="if (!open) statsOpen = false"></div>

    <nav class="flex-1 p-4 flex flex-col justify-center">
        <ul class="top-0">
            @if (Auth::user()->role == 1)
                <li class="mb-4">
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">person</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Perfil</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">dashboard</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Dashboard</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('income.index', ['id' => Auth::user()->id]) }}"
                        class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">trending_up</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Ingresos</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('outcome.index', ['id' => Auth::user()->id]) }}"
                        class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">trending_down</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Gastos</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('savingsobj.index', ['id' => Auth::user()->id]) }}"
                        class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">track_changes</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Objetivos</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('achievements.index', ['id' => Auth::user()->id]) }}"
                        class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">military_tech</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Logros</span>
                    </a>
                </li>
                <!-- Menú desplegable para Deudores -->
                <li class="mb-4">
                    <button @click="subOpen = !subOpen"
                        class="flex items-center p-2 rounded hover:bg-gray-700 focus:outline-none group">
                        <span class="material-icons mr-2 group-hover:text-white">payments</span>
                        <span x-show="open"
                            class="transition-opacity duration-300 flex-1 text-left">&nbsp;Deudas</span>
                        <span x-show="open"
                            class="material-icons ml-auto transition-transform duration-300 group-hover:text-white"
                            :class="{ 'rotate-[-90]': subOpen }">chevron_left</span>
                    </button>
                    <!-- Submenú -->
                    <ul x-show="subOpen" x-collapse class="ml-8 mt-2 space-y-2" x-cloak>
                        <li>
                            <a href="{{ route('defaultors.index', ['id' => Auth::user()->id]) }}"
                                class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                                <span class="material-icons text-sm group-hover:text-white">receipt_long</span>
                                <span>Mis deudas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('defaulter.index', ['id' => Auth::user()->id]) }}"
                                class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                                <span
                                    class="material-icons text-sm group-hover:text-white">account_balance_wallet</span>
                                <span>Mis deudores</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Menú desplegable para Estadísticas -->
                <li class="mb-4">
                    <button @click="statsOpen = !statsOpen"
                        class="flex items-center p-2 rounded hover:bg-gray-700 focus:outline-none group">
                        <span class="material-icons mr-2 group-hover:text-white">pie_chart</span>
                        <span x-show="open"
                            class="transition-opacity duration-300 flex-1 text-left">&nbsp;Estadísticas</span>
                        <span x-show="open"
                            class="material-icons ml-auto transition-transform duration-300 group-hover:text-white"
                            :class="{ 'rotate-[-90]': statsOpen }">chevron_left</span>
                    </button>
                    <!-- Submenú -->
                    <ul x-show="statsOpen" x-collapse class="ml-8 mt-2 space-y-2" x-cloak>
                        <li>
                            <a href="{{ route('statistics.index_monthly', ['id' => Auth::user()->id]) }}"
                                class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                                <span class="material-icons text-sm group-hover:text-white">calendar_month</span>
                                <span>Mensuales</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('statistics.index_weekly', ['id' => Auth::user()->id]) }}"
                                class="flex items-center gap-2 p-2 rounded hover:bg-gray-700 text-sm transition-colors duration-200">
                                <span class="material-icons text-sm group-hover:text-white">calendar_view_week</span>
                                <span>Semanales</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            {{-- Opción solo para admin --}}
            @if (Auth::user()->role == 0)
                <li class="mb-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-2 rounded hover:bg-gray-700 group">
                        <span class="material-icons mr-2 group-hover:text-white">admin_panel_settings</span>
                        <span x-show="open" class="transition-opacity duration-300">&nbsp;Administración</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
    <style>
        .aside-transition {
            transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);
            /* Puedes ajustar la duración y la curva para más suavidad */
            width: 6rem;
            /* ancho cerrado */
            overflow: hidden;
        }

        .aside-transition.open {
            width: 16rem;

        }
    </style>
</aside>
