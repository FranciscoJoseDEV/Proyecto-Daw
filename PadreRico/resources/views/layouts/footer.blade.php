{{-- filepath: c:\Users\frand\Documents\Proyecto Daw\PadreRico\resources\views\layouts\footer.blade.php --}}
<footer
    class="bg-cssecondary text-black py-4 flex flex-col md:flex-row justify-between items-center w-full px-4 border-t border-gray-300"
    role="contentinfo" aria-label="Pie de página">
    <p class="text-sm mb-2 md:mb-0">© {{ date('Y') }} Tu Padre Rico. Todos los derechos reservados.</p>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('cookies') }}"
            class="flex items-center hover:underline focus:outline-none focus:ring-2 focus:ring-csprimary"
            aria-label="Política de cookies">
            <span class="material-icons mr-1" style="font-size: 20px;">cookie</span>
            Cookies
        </a>
        <a href="{{ route('sobre-nosotros') }}"
            class="flex items-center hover:underline focus:outline-none focus:ring-2 focus:ring-csprimary"
            aria-label="Sobre Nosotros">
            <span class="material-icons mr-1" style="font-size: 20px;">groups</span>
            Sobre Nosotros
        </a>
        <a href="{{ route('contacto') }}"
            class="flex items-center hover:underline focus:outline-none focus:ring-2 focus:ring-csprimary"
            aria-label="Contáctanos">
            <span class="material-icons mr-1" style="font-size: 20px;">mail</span>
            Contáctanos
        </a>
        <a href="https://instagram.com/" target="_blank" rel="noopener"
            class="flex items-center hover:underline focus:outline-none focus:ring-2 focus:ring-csprimary"
            aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" height="20" fill="currentColor"
                viewBox="0 0 24 24" aria-hidden="true">
                <path
                    d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 22h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zM12 8.25a3.75 3.75 0 1 1 0 7.5 3.75 3.75 0 0 1 0-7.5zm0 1.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5zm4.25-3.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5a.75.75 0 0 1 .75-.75z" />
            </svg>
        </a>
        <a href="https://facebook.com/" target="_blank" rel="noopener"
            class="flex items-center hover:underline focus:outline-none focus:ring-2 focus:ring-csprimary"
            aria-label="Facebook">
            <span class="material-icons mr-1" style="font-size: 20px;">facebook</span>
        </a>
    </div>
</footer>
