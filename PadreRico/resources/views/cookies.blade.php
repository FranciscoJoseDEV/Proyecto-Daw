{{-- filepath: c:\Users\frand\Documents\Proyecto Daw\PadreRico\resources\views\cookies.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-2 text-csprimary">{{ __('cookies.title') }}</h1>
        <p class="text-gray-600 mb-8 text-lg">
            {{ __('cookies.info') }}
        </p>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">{{ __('cookies.what_are') }}</h2>
            <p class="mb-4 text-gray-700">
                {{ __('cookies.what_are_text') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">{{ __('cookies.types') }}</h2>
            <ul class="list-disc list-inside mb-4 text-gray-700">
                <li>{{ __('cookies.essential') }}</li>
                <li>{{ __('cookies.analytics') }}</li>
                <li>{{ __('cookies.third_party') }}</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">{{ __('cookies.manage') }}</h2>
            <p class="mb-4 text-gray-700">
                {{ __('cookies.manage_text') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">{{ __('cookies.privacy') }}</h2>
            <p class="mb-4 text-gray-700">
                {{ __('cookies.privacy_text') }}
            </p>
            <ul class="list-disc list-inside mb-4 text-gray-700">
                <li>{{ __('cookies.privacy_list_1') }}</li>
                <li>{{ __('cookies.privacy_list_2') }}</li>
                <li>{!! __('cookies.privacy_list_3', ['contacto' => '<a href="'.route('contacto').'" class="text-csprimary underline">Contacto</a>']) !!}</li>
            </ul>
            <p class="text-gray-700">
                {{ __('cookies.privacy_more') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4 text-csprimary">{{ __('cookies.doubts') }}</h2>
            <p class="text-gray-700">
                {!! __('cookies.doubts_text', ['contacto' => '<a href="'.route('contacto').'" class="text-csprimary underline">Contacto</a>']) !!}
            </p>
        </div>
    </div>
@endsection