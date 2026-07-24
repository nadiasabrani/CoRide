<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Détail du trajet
            </h2>
            <a href="{{ route('trajets.index') }}"
               class="text-sm text-brand-600 hover:underline">← Retour à la liste</a>
        </div>
    </x-slot>

    @php
        $user = auth()->user();
        $isOwner = $user->id === $trajet->conducteur_id;
        $isPassagerRole = in_array($user->role, ['passager', 'les_deux']);
    @endphp

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Carte principale du trajet --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                {{-- En-tête colorée --}}
                <div class="bg-brand-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="text-center">
                                <p class="text-xs uppercase tracking-wide opacity-75">Départ</p>
                                <p class="text-2xl font-bold mt-1">{{ $trajet->depart }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <svg class="h-6 w-16 opacity-75" fill="none" viewBox="0 0 64 24" stroke="currentColor">
                                    <line x1="2" y1="12" x2="54" y2="12" stroke-width="2"/>
                                    <polygon points="54,6 62,12 54,18" fill="currentColor" stroke="none"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-xs uppercase tracking-wide opacity-75">Arrivée</p>
                                <p class="text-2xl font-bold mt-1">{{ $trajet->destination }}</p>
                            </div>
                        </div>
                        <div class="text-right hidden sm:block">
                            <p class="text-3xl font-bold">{{ $trajet->prix }} <span class="text-lg">DH</span></p>
                            <p class="text-brand-200 text-sm">par trajet</p>
                        </div>
                    </div>
                </div>

                {{-- Détails --}}
                <div class="px-8 py-6 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Date</p>
                        <p class="font-semibold dark:text-gray-100 mt-1">
                            {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Heure</p>
                        <p class="font-semibold dark:text-gray-100 mt-1">{{ $trajet->heure_depart }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Places restantes</p>
                        <p class="font-semibold mt-1 {{ $trajet->placesRestantes() > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trajet->placesRestantes() }} / {{ $trajet->places }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Récurrence</p>
                        <p class="font-semibold dark:text-gray-100 mt-1 text-sm">{{ $trajet->joursRecurrenceFormates() }}</p>
                    </div>
                </div>

                {{-- Conducteur --}}
                <div class="px-8 pb-6 border-t dark:border-gray-700 pt-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Conducteur</p>
                    <div class="flex items-center gap-3">
                        <div class="bg-brand-100 dark:bg-brand-900 rounded-full p-3">
                            <svg class="h-5 w-5 text-brand-600 dark:text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold dark:text-gray-100">{{ optional($trajet->conducteur)->nom }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ optional($trajet->conducteur)->ville_residence }} •
                                {{ optional(optional($trajet->conducteur)->entreprise)->nom }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 1. Si l'utilisateur est le conducteur propriétaire du trajet --}}
            @if($isOwner)
                <div class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-700/60 rounded-2xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-amber-800 dark:text-amber-200">👑 Vous êtes le conducteur de ce trajet</p>
                            <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">Vous ne pouvez pas réserver votre propre trajet. Vous pouvez le modifier ou gérer les demandes reçues.</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('trajets.edit', $trajet) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded-lg font-medium transition">
                                ✏️ Modifier
                            </a>
                            <a href="{{ route('reservations.conducteur.index') }}"
                               class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition">
                                🎛️ Gérer demandes
                            </a>
                        </div>
                    </div>
                </div>
            {{-- 2. Si l'utilisateur est un conducteur strict (role === 'conducteur') consulté un autre trajet --}}
            @elseif(!$isPassagerRole)
                <div class="bg-brand-50 dark:bg-brand-900/30 border border-brand-200 dark:border-brand-700/60 rounded-2xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-brand-900 dark:text-brand-200">ℹ️ Rôle Conducteur uniquement</p>
                            <p class="text-xs text-brand-700 dark:text-brand-300 mt-1">Votre rôle actuel est défini comme <strong>Conducteur</strong>. Seuls les employés passagers peuvent évaluer et réserver des trajets.</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="text-xs bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-lg font-medium transition">
                            Modifier mon rôle →
                        </a>
                    </div>
                </div>
            {{-- 3. Si l'utilisateur est passager ou les_deux (non propriétaire) --}}
            @else
                {{-- Section Score IA --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6" id="ia-section">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-brand-100 dark:bg-brand-900 rounded-full p-2">
                            <svg class="h-5 w-5 text-brand-600 dark:text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-200">Score de compatibilité IA</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Entrez votre besoin pour que l'IA évalue ce trajet</p>
                        </div>
                    </div>

                    <form id="ia-form" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ma ville de départ</label>
                                <input type="text" id="ia-ville-depart" name="ville_depart"
                                       value="{{ auth()->user()->ville_residence }}"
                                       class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100"
                                       placeholder="Ex: Casablanca">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ma destination</label>
                                <input type="text" id="ia-ville-arrivee" name="ville_arrivee"
                                       value="{{ $trajet->destination }}"
                                       class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100"
                                       placeholder="Ex: Rabat">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mon horaire souhaité</label>
                                <input type="time" id="ia-horaire" name="horaire"
                                       value="{{ $trajet->heure_depart }}"
                                       class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100">
                            </div>
                        </div>

                        <button type="button" id="btn-calculer-ia"
                                onclick="calculerCompatibilite({{ $trajet->id }})"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-lg transition font-medium">
                            ✨ Calculer la compatibilité
                        </button>
                    </form>

                    {{-- Résultat IA --}}
                    <div id="ia-result" class="hidden mt-6">
                        <div class="border dark:border-gray-700 rounded-xl p-5 space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-semibold dark:text-gray-100">Score de compatibilité</span>
                                    <span id="ia-score-label" class="text-2xl font-bold"></span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                                    <div id="ia-score-bar"
                                         class="h-4 rounded-full transition-all duration-1000 ease-out"
                                         style="width: 0%"></div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Justification</p>
                                <p id="ia-justification" class="text-sm dark:text-gray-200 leading-relaxed"></p>
                            </div>

                            <div id="ia-horaire-block" class="hidden">
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Horaire suggéré</p>
                                <p id="ia-horaire-suggere" class="text-sm font-semibold text-brand-600 dark:text-brand-400"></p>
                            </div>

                            <div id="ia-badge" class="inline-block px-3 py-1 rounded-full text-sm font-semibold"></div>
                        </div>
                    </div>

                    <div id="ia-error" class="hidden mt-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                        <p class="text-sm text-red-700 dark:text-red-300" id="ia-error-msg"></p>
                    </div>
                </div>

                {{-- Section réservation passager --}}
                @php
                    $dejaReserve = $trajet->reservations
                        ->where('passager_id', auth()->id())
                        ->isNotEmpty();
                    $trajetComplet = $trajet->placesRestantes() === 0;
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">📌 Réserver ce trajet</h3>

                    @if($dejaReserve)
                        <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-700">
                            <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Vous avez déjà une réservation sur ce trajet.</p>
                        </div>
                    @elseif($trajetComplet)
                        <div class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/30 rounded-xl border border-red-200 dark:border-red-700">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-red-700 dark:text-red-300 font-medium">Ce trajet est complet. Aucune place disponible.</p>
                        </div>
                    @else
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 rounded-xl text-sm text-green-700 dark:text-green-300">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->has('trajet_id'))
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                                {{ $errors->first('trajet_id') }}
                            </div>
                        @endif

                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="trajet_id" value="{{ $trajet->id }}">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                En confirmant, votre demande de réservation sera envoyée au conducteur pour validation.
                                <strong>{{ $trajet->placesRestantes() }} place(s) disponible(s).</strong>
                            </p>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-xl font-medium transition">
                                ✅ Demander à réserver
                            </button>
                        </form>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- Script AJAX pour le scoring IA --}}
    <script>
    async function calculerCompatibilite(trajetId) {
        const btn = document.getElementById('btn-calculer-ia');
        const resultDiv = document.getElementById('ia-result');
        const errorDiv = document.getElementById('ia-error');

        const villeDepart  = document.getElementById('ia-ville-depart').value.trim();
        const villeArrivee = document.getElementById('ia-ville-arrivee').value.trim();
        const horaire      = document.getElementById('ia-horaire').value;

        if (!villeDepart || !villeArrivee || !horaire) {
            alert('Veuillez remplir tous les champs pour calculer la compatibilité.');
            return;
        }

        btn.disabled = true;
        btn.textContent = '⏳ Calcul en cours...';
        resultDiv.classList.add('hidden');
        errorDiv.classList.add('hidden');

        try {
            const response = await fetch(`/trajets/${trajetId}/compatibilite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    ville_depart:  villeDepart,
                    ville_arrivee: villeArrivee,
                    horaire:       horaire,
                }),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Erreur lors du calcul.');
            }

            afficherResultat(data);

        } catch (err) {
            document.getElementById('ia-error-msg').textContent = err.message;
            errorDiv.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.textContent = '✨ Recalculer';
        }
    }

    function afficherResultat(data) {
        const resultDiv = document.getElementById('ia-result');
        const score = data.score;

        document.getElementById('ia-score-label').textContent = score + '/100';

        const bar = document.getElementById('ia-score-bar');
        bar.style.width = score + '%';
        if (score >= 70) {
            bar.className = 'h-4 rounded-full transition-all duration-1000 ease-out bg-green-500';
        } else if (score >= 40) {
            bar.className = 'h-4 rounded-full transition-all duration-1000 ease-out bg-yellow-500';
        } else {
            bar.className = 'h-4 rounded-full transition-all duration-1000 ease-out bg-red-500';
        }

        document.getElementById('ia-justification').textContent = data.justification;

        const horaireBlock = document.getElementById('ia-horaire-block');
        if (data.horaire_suggere) {
            document.getElementById('ia-horaire-suggere').textContent = data.horaire_suggere;
            horaireBlock.classList.remove('hidden');
        } else {
            horaireBlock.classList.add('hidden');
        }

        const badge = document.getElementById('ia-badge');
        if (data.bonne_compatibilite) {
            badge.textContent = '✅ Bonne compatibilité';
            badge.className = 'inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        } else {
            badge.textContent = '⚠️ Compatibilité limitée';
            badge.className = 'inline-block px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        }

        resultDiv.classList.remove('hidden');
        resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    </script>
</x-app-layout>
