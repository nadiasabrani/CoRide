<x-guest-layout>
    <div class="border-b border-white/10 pb-4 mb-6">
        <h2 class="font-display font-extrabold text-2xl text-white">Inscription Employé</h2>
        <p class="text-xs text-slate-400 mt-1">Créez votre compte pour réserver ou publier des trajets.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Entreprise -->
        <div>
            <label for="entreprise_id" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Entreprise partenaire</label>
            <select id="entreprise_id" name="entreprise_id" class="pro-input" required>
                <option value="" disabled selected>Choisissez votre entreprise</option>
                @foreach($entreprises as $entreprise)
                    <option value="{{ $entreprise->id }}" @selected(old('entreprise_id') == $entreprise->id)>
                        {{ $entreprise->nom }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('entreprise_id')" class="mt-1" />
        </div>

        <!-- Nom -->
        <div>
            <label for="nom" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Nom complet</label>
            <input id="nom" class="pro-input" type="text" name="nom" :value="old('nom')" required autofocus placeholder="Ex: Sarah Alaoui" />
            <x-input-error :messages="$errors->get('nom')" class="mt-1" />
        </div>

        <!-- Ville de résidence -->
        <div>
            <label for="ville_residence" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Ville de résidence</label>
            <input id="ville_residence" class="pro-input" type="text" name="ville_residence" :value="old('ville_residence')" required placeholder="Ex: Casablanca" />
            <x-input-error :messages="$errors->get('ville_residence')" class="mt-1" />
        </div>

        <!-- Rôle -->
        <div>
            <label for="role" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Rôle covoiturage</label>
            <select id="role" name="role" class="pro-input" required>
                <option value="" disabled selected>Sélectionnez un rôle</option>
                <option value="conducteur" @selected(old('role') === 'conducteur')>Conducteur (je propose des trajets)</option>
                <option value="passager" @selected(old('role') === 'passager')>Passager (je cherche des trajets)</option>
                <option value="les_deux" @selected(old('role') === 'les_deux')>Les deux (Conducteur & Passager)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Email professionnel</label>
            <input id="email" class="pro-input" type="email" name="email" :value="old('email')" required placeholder="nom@entreprise.ma" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Mot de passe</label>
            <input id="password" class="pro-input" type="password" name="password" required placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Confirmer le mot de passe</label>
            <input id="password_confirmation" class="pro-input" type="password" name="password_confirmation" required placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <a class="text-xs text-slate-400 hover:text-blue-400 underline font-medium" href="{{ route('login') }}">
                Déjà un compte ? Se connecter
            </a>

            <button type="submit" class="btn-pro-primary">
                Créer mon compte →
            </button>
        </div>
    </form>
</x-guest-layout>
