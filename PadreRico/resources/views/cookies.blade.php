{{-- filepath: c:\Users\frand\Documents\Proyecto Daw\PadreRico\resources\views\cookies.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Política de Cookies</h1>
    <p class="mb-4">
        Este sitio web utiliza cookies para mejorar la experiencia del usuario y analizar el tráfico. Al continuar navegando, aceptas el uso de cookies conforme a esta política.
    </p>
    <h2 class="text-xl font-semibold mb-2">¿Qué son las cookies?</h2>
    <p class="mb-4">
        Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Sirven para recordar tus preferencias y mejorar tu experiencia de navegación.
    </p>
    <h2 class="text-xl font-semibold mb-2">¿Qué tipos de cookies utilizamos?</h2>
    <ul class="list-disc list-inside mb-4">
        <li><strong>Cookies esenciales:</strong> Necesarias para el funcionamiento básico del sitio.</li>
        <li><strong>Cookies de análisis:</strong> Nos ayudan a entender cómo interactúan los usuarios con el sitio.</li>
        <li><strong>Cookies de terceros:</strong> Utilizadas por servicios externos como redes sociales o análisis de tráfico.</li>
    </ul>
    <h2 class="text-xl font-semibold mb-2">¿Cómo puedes gestionar las cookies?</h2>
    <p class="mb-4">
        Puedes configurar tu navegador para aceptar o rechazar cookies, así como para eliminarlas en cualquier momento. Consulta la ayuda de tu navegador para obtener más información.
    </p>
    <p>
        Si tienes dudas sobre nuestra política de cookies, puedes contactarnos a través de la sección de <a href="{{ route('contacto') }}" class="text-csprimary underline">Contacto</a>.
    </p>
</div>
@endsection