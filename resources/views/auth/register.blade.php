<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Entreprise -->
        <div>
            <x-input-label for="entreprise_id" value="Entreprise" />

            <select id="entreprise_id" name="entreprise_id" class="block mt-1 w-full rounded-md border-gray-300" required>
                <option value="" disabled selected>Choisissez votre entreprise</option>
                @foreach($entreprises as $entreprise)
                    <option value="{{ $entreprise->id }}" @selected(old('entreprise_id') == $entreprise->id)>
                        {{ $entreprise->nom }}
                    </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('entreprise_id')" class="mt-2" />
        </div>

        <!-- Nom -->
        <div class="mt-4">
            <x-input-label for="nom" value="Nom complet" />
            <x-text-input
                id="nom"
                class="block mt-1 w-full"
                type="text"
                name="nom"
                :value="old('nom')"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Ville de résidence -->
        <div class="mt-4">
            <x-input-label for="ville_residence" value="Ville de résidence" />
            <x-text-input
                id="ville_residence"
                class="block mt-1 w-full"
                type="text"
                name="ville_residence"
                :value="old('ville_residence')"
                required
            />
            <x-input-error :messages="$errors->get('ville_residence')" class="mt-2" />
        </div>

        <!-- Rôle -->
        <div class="mt-4">
            <x-input-label for="role" value="Rôle" />
            <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300" required>
                <option value="" disabled selected>Sélectionnez un rôle</option>
                <option value="conducteur" @selected(old('role') === 'conducteur')>Conducteur</option>
                <option value="passager" @selected(old('role') === 'passager')>Passager</option>
                <option value="les_deux" @selected(old('role') === 'les_deux')>Les deux</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a
                class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}"
            >
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
