<div class="justify-center  min-h-screen bg-secondary">
    <section class="flex-row gap-6 w-full max-w-4xl p-6 rounded-lg">
        <div class="w-1/2 p-4 rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-black">
                    {{ __('Información del Perfil') }}
                </h2>
                <p class="mt-1 text-sm text-black">
                    {{ __('Actualiza la información de tu perfil, la dirección de correo electrónico y la imagen de perfil de tu cuenta.') }}
                </p>
            </header>

            <div class="w-1/2 flex justify-center items-center">
                <img src="{{ $user->img ? asset('storage/' . $user->img) : asset('profilePictures/Default-profile.jpg') }}" 
                     alt="Imagen de perfil" 
                     class="w-48 h-48 rounded-full border-2 border-gray-300 object-cover">
            </div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
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
                            class="text-sm text-gray-600 dark:text-gray-400">{{ __('Guardado.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </section>
</div>
