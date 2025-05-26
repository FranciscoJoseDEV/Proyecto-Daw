@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-2xl font-semibold mb-4">Logros Desbloqueados</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($achievements as $achievement)
                <div
                    class="p-4 rounded shadow-sm bg-{{ in_array($achievement->id, $userAchievements) ? 'green-100' : 'gray-100' }}">
                    <h3 class="text-xl font-bold">{{ $achievement->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $achievement->description }}</p>
                    <p class="mt-2 text-xs text-gray-400">Puntos: {{ $achievement->points }}</p>
                    @if (in_array($achievement->id, $userAchievements))
                        <span class="text-green-600 font-semibold">¡Desbloqueado!</span>
                    @else
                        <span class="text-gray-400">No desbloqueado</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
