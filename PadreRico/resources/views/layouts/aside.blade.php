<aside x-data="{ open: false }"
    class="bg-cssecondary text-black flex flex-col transform transition-transform duration-300 md:translate-x-0"
    :class="{ 'w-64': open, 'w-12': !open }" @mouseenter="open = true" @mouseleave="open = false">
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="top-0">
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
            <li class="mb-4">
                <a href="{{ route('defaulter.index', ['id' => Auth::user()->id]) }}"
                    class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="material-icons mr-2">payments</span>
                    <span x-show="open" class="transition-opacity duration-300">&nbsp;Deudores</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="material-icons mr-2">settings</span>
                    <span x-show="open" class="transition-opacity duration-300">&nbsp;Configuración</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
