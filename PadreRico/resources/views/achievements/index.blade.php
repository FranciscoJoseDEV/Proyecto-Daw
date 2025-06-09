@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center text-3xl font-bold text-gray-800">Vitrina de Logros</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($achievements as $achievement)
                <div class="col">
                    <div class="card h-100 text-center p-3 border-0 shadow-sm 
                        @if(in_array($achievement->id, $userAchievements)) 
                            bg-white achievement-unlocked 
                        @else 
                            bg-light achievement-locked 
                        @endif"
                        style="transition: transform 0.3s ease;">

                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="trophy-icon mb-3">
                                <i class="material-icons" style="font-size: 48px;">
                                    @if(in_array($achievement->id, $userAchievements)) emoji_events
                                    @else lock
                                    @endif
                                </i>
                            </div>
                            <h5 class="card-title fw-bold">
                                {{ $achievement->name }}
                            </h5>
                            <p class="card-text text-muted small">
                                {{ $achievement->description }}
                            </p>
                            <span class="badge 
                                @if(in_array($achievement->id, $userAchievements)) bg-success 
                                @else bg-secondary 
                                @endif">
                                {{ $achievement->points }} puntos
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    
@endsection
@push('styles')<style>
        .achievement-unlocked {
            border: 2px solid #4ade80; /* verde */
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .achievement-locked {
            filter: grayscale(100%) opacity(0.5);
        }

        .card:hover {
            transform: scale(1.03);
        }

        .trophy-icon i {
            color: #facc15; /* amarillo */
        }

        .achievement-locked .trophy-icon i {
            color: #9ca3af; /* gris */
        }
    </style>
@endpush
