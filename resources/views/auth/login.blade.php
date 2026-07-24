<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Bannière Aide à la connexion Démo --}}
    <div class="mb-6 p-4 bg-indigo-50 dark:bg-indigo-900/40 border border-indigo-200 dark:border-indigo-700/60 rounded-xl">
        <p class="text-xs font-bold uppercase tracking-wider text-indigo-700 dark:text-indigo-300 mb-2">
            💡 Comptes de démonstration
        </p>
        <div class="space-y-1.5 text-xs text-gray-700 dark:text-gray-300">
            <p>
                <strong>Admin Démo :</strong>
                <button type="button" onclick="fillLogin('admin@coride.ma', 'password')"
                        class="text-indigo-600 dark:text-indigo-400 font-mono underline hover:text-indigo-800">
                    admin@coride.ma
                </button>
            </p>
            <p>
                <strong>Conducteur :</strong>
                <button type="button" onclick="fillLogin('k.benali@mobilitech.ma', 'password')"
                        class="text-indigo-600 dark:text-indigo-400 font-mono underline hover:text-indigo-800">
                    k.benali@mobilitech.ma
                </button>
            </p>
            <p>
                <strong>Passager :</strong>
                <button type="button" onclick="fillLogin('s.alaoui@mobilitech.ma', 'password')"
                        class="text-indigo-600 dark:text-indigo-400 font-mono underline hover:text-indigo-800">
                    s.alaoui@mobilitech.ma
                </button>
            </p>
            <p class="text-[11px] text-gray-400 mt-1">Mot de passe pour tous : <code class="bg-gray-200 dark:bg-gray-700 px-1 rounded">password</code></p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email professionnel')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400" href="{{ route('register') }}">
                    Pas de compte ? S'inscrire
                </a>
            @endif

            <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Connexion') }}
            </x-primary-button>
        </div>
    </form>

    <script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
    </script>
</x-guest-layout>
