{{-- filepath: c:\Users\frand\Documents\Proyecto Daw\PadreRico\resources\views\cookies.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-2 text-csprimary">Política de Cookies</h1>
        <p class="text-gray-600 mb-8 text-lg">
            Información sobre el uso de cookies en nuestro sitio web.
        </p>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">¿Qué son las cookies?</h2>
            <p class="mb-4 text-gray-700">
                Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Sirven para recordar tus preferencias y mejorar tu experiencia de navegación.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">¿Qué tipos de cookies utilizamos?</h2>
            <ul class="list-disc list-inside mb-4 text-gray-700">
                <li><strong>Cookies esenciales:</strong> Necesarias para el funcionamiento básico del sitio.</li>
                <li><strong>Cookies de análisis:</strong> Nos ayudan a entender cómo interactúan los usuarios con el sitio.</li>
                <li><strong>Cookies de terceros:</strong> Utilizadas por servicios externos como redes sociales o análisis de tráfico.</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">¿Cómo puedes gestionar las cookies?</h2>
            <p class="mb-4 text-gray-700">
                Puedes configurar tu navegador para aceptar o rechazar cookies, así como para eliminarlas en cualquier momento. Consulta la ayuda de tu navegador para obtener más información.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">Política de Privacidad</h2>
            <p class="mb-4 text-gray-700">
                En nuestro sitio web, nos comprometemos a proteger tu privacidad y tus datos personales. Los datos que nos proporciones a través de formularios, como tu nombre y correo electrónico, serán utilizados únicamente para responder a tus consultas o proporcionarte información relacionada con nuestros servicios.
            </p>
            <ul class="list-disc list-inside mb-4 text-gray-700">
                <li>No compartimos tus datos personales con terceros, salvo obligación legal.</li>
                <li>Solo almacenamos la información necesaria para la finalidad para la que fue recogida.</li>
                <li>Puedes ejercer tus derechos de acceso, rectificación o eliminación de tus datos contactándonos a través de la sección de <a href="{{ route('contacto') }}" class="text-csprimary underline">Contacto</a>.</li>
            </ul>
            <p class="text-gray-700">
                Para más información sobre cómo tratamos tus datos personales, no dudes en ponerte en contacto con nosotros.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">¿Tienes dudas?</h2>
            <p class="text-gray-700">
                Si tienes dudas sobre nuestra política de cookies o privacidad, puedes contactarnos a través de la sección de
                <a href="{{ route('contacto') }}" class="text-csprimary underline">Contacto</a>.
            </p>
        </div>
    </div>
@endsection