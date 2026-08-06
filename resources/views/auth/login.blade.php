<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="border-b border-white/10 pb-4 mb-6">
        <h2 class="font-display font-extrabold text-2xl text-white">Connexion Espace Employé</h2>
        <p class="text-xs text-slate-400 mt-1">Accédez à vos trajets et réservations d'entreprise.</p>
    </div>

    {{-- Bannière Aide à la connexion Démo --}}
    <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl space-y-2">
        <p class="text-xs font-bold uppercase tracking-wider text-blue-400 font-mono flex items-center gap-1.5">
            💡 Comptes de démonstration
        </p>
        <div class="space-y-1 text-xs text-slate-300">
            <p class="flex items-center justify-between">
                <span>Admin:</span>
                <button type="button" onclick="fillLogin('admin@coride.ma', 'password')" class="text-blue-400 font-mono underline hover:text-blue-300 font-semibold">
                    admin@coride.ma
                </button>
            </p>
            <p class="flex items-center justify-between">
                <span>Conducteur:</span>
                <button type="button" onclick="fillLogin('k.benali@mobilitech.ma', 'password')" class="text-blue-400 font-mono underline hover:text-blue-300 font-semibold">
                    k.benali@mobilitech.ma
                </button>
            </p>
            <p class="flex items-center justify-between">
                <span>Passager:</span>
                <button type="button" onclick="fillLogin('s.alaoui@mobilitech.ma', 'password')" class="text-blue-400 font-mono underline hover:text-blue-300 font-semibold">
                    s.alaoui@mobilitech.ma
                </button>
            </p>
            <p class="text-[11px] text-slate-400 mt-1 border-t border-white/10 pt-1">Mot de passe pour tous : <code class="bg-black/40 px-1.5 py-0.5 rounded text-slate-200 font-mono">password</code></p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Email professionnel</label>
            <input id="email" class="pro-input" type="email" name="email" :value="old('email')" required autofocus placeholder="votre.nom@entreprise.ma" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Mot de passe</label>
            <input id="password" class="pro-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-[#0B0F19] border-white/20 text-blue-600 focus:ring-blue-500" name="remember">
                <span class="text-xs text-slate-300 font-medium">Se souvenir de moi</span>
            </label>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            @if (Route::has('register'))
                <a class="text-xs text-slate-400 hover:text-blue-400 underline font-medium" href="{{ route('register') }}">
                    Pas de compte ? S'inscrire
                </a>
            @endif

            <button type="submit" class="btn-pro-primary">
                Connexion →
            </button>
        </div>
    </form>

    <script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
    </script>
</x-guest-layout>
