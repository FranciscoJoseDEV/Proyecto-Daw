{{-- filepath: c:\Users\frand\Documents\Proyecto Daw\PadreRico\resources\views\sobre-nosotros.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-2 text-csprimary">Sobre Nosotros</h1>
    <p class="text-gray-600 mb-8 text-lg">Conoce al autor y la ubicación de este proyecto.</p>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-10">
        <h2 class="text-2xl font-semibold mb-4 text-csprimary">Presentación</h2>
        <p class="text-lg mb-4 text-gray-700">
            ¡Hola! Mi nombre es <strong>Francisco José Sánche LLoret</strong> y soy alumno de segundo de Desarrollo de Aplicaciones Web (DAW).
            Este proyecto es mi trabajo de fin de módulo, en el que he puesto mucho esfuerzo y dedicación con la esperanza de obtener un <span class="font-bold text-csprimary">10</span>.
        </p>
        <p class="text-gray-700">
            El objetivo de este sitio es demostrar los conocimientos adquiridos durante el curso, aplicando buenas prácticas de desarrollo web, diseño y accesibilidad.
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-semibold mb-4 text-csprimary">Nuestra ubicación</h2>
        <p class="mb-4 text-gray-700">
            El centro de estudios donde se ha desarrollado este proyecto es el <strong>IES Mar de Cádiz</strong>.
        </p>
        <div class="rounded-lg overflow-hidden shadow-md" style="height: 350px;">
            <iframe
                src="https://www.google.com/maps?q=IES+Mar+de+Cádiz,+Av.+de+la+Constitución,+11540+Sanlúcar+de+Barrameda,+Cádiz,+España&hl=es&z=16&output=embed"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Mapa IES Mar de Cádiz" aria-label="Mapa de la ubicación del IES Mar de Cádiz"></iframe>
        </div>
    </div>
</div>
@endsection