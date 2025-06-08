    <section class=" p-8 flex flex-col md:flex-row gap-8 w-full max-w-3xl">
        <!-- Imagen de perfil -->
        <div class="flex flex-col items-center justify-center md:w-1/3 w-full">
            <img src="{{ $user->img ? asset('storage/' . $user->img) : asset('imgs/9187604.png') }}"
                 alt="Imagen de perfil"
                 class="w-40 h-40 rounded-full border-4 border-gray-300 object-cover shadow-md mb-4">
            <h2 class="text-lg font-semibold text-gray-800 mt-2">{{ $user->name }}</h2>
        </div>

        <!-- Formulario -->
        <div class="md:w-2/3 w-full">
            <header class="mb-4">
                <h2 class="text-xl font-bold text-gray-900">
                    {{ __('Información del Perfil') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Actualiza la información de tu perfil, la dirección de correo electrónico y la imagen de perfil de tu cuenta.') }}
                </p>
            </header>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="img" :value="__('Imagen de Perfil')" />
                    <input id="img" name="img" type="file" class="mt-1 block w-full" accept="image/*">
                    <x-input-error class="mt-2" :messages="$errors->get('img')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Guardar') }}</x-primary-button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-600">{{ __('Guardado.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </section>

