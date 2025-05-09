@extends('layouts.app')

@section('content')
    <div class="flex">
        @include('layouts.aside') <!-- Incluye el aside aquí -->

        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <!-- Formulario de actualización de información del perfil -->
                    <div class="flex justify-center items-center p-4 sm:p-8 bg-secondary shadow sm:rounded-lg">
                        <div>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Formulario de actualización de contraseña -->
                    <div class="flex justify-center items-center  p-4 sm:p-8 bg-secondary">
                        <div >
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Formulario de eliminación de usuario -->
                    <div class="flex justify-center items-center  p-4 sm:p-8 bg-secondary shadow sm:rounded-lg">
                        <div >
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection
