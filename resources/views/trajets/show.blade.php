<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display font-bold text-2xl text-white">
                Détail du trajet
            </h2>
            <a href="{{ route('trajets.index') }}" class="btn-pro-secondary text-xs">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    @php
        $user = auth()->user();
        $isOwner = $user->id === $trajet->conducteur_id;
        $isPassagerRole = in_array($user->role, ['passager', 'les_deux']);
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Main Trajet Card --}}
            <div class="pro-card overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-900/60 to-indigo-900/40 p-8 border-b border-white/10">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-8">
                            <div>
                                <p class="text-xs font-mono uppercase text-slate-300 font-semibold">Départ</p>
                                <p class="text-3xl font-extrabold text-white mt-1">{{ $trajet->depart }}</p>
                            </div>
                            <div class="text-blue-400 font-bold text-2xl">→</div>
                            <div>
                                <p class="text-xs font-mono uppercase text-slate-300 font-semibold">Arrivée</p>
                                <p class="text-3xl font-extrabold text-white mt-1">{{ $trajet->destination }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-extrabold text-emerald-400">{{ $trajet->prix }} <span class="text-lg">DH</span></p>
                            <p class="text-xs font-mono text-slate-300">par place</p>
                        </div>
                    </div>
                </div>

                <!-- Specs -->
                <div class="p-8 grid grid-cols-2 sm:grid-cols-4 gap-6 border-b border-white/10">
                    <div>
                        <p class="text-xs font-mono text-slate-400 uppercase">Date</p>
                        <p class="font-bold text-white text-base mt-1">
                            {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-mono text-slate-400 uppercase">Heure de départ</p>
                        <p class="font-bold text-blue-400 text-base mt-1">{{ $trajet->heure_depart }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-mono text-slate-400 uppercase">Places disponibles</p>
                        <p class="font-bold text-base mt-1 {{ $trajet->placesRestantes() > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $trajet->placesRestantes() }} / {{ $trajet->places }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-mono text-slate-400 uppercase">Récurrence</p>
                        <p class="font-semibold text-slate-200 text-sm mt-1">{{ $trajet->joursRecurrenceFormates() }}</p>
                    </div>
                </div>

                <!-- Driver Info -->
                <div class="p-8 flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-blue-600 text-white font-bold text-lg flex items-center justify-center font-display">
                        {{ strtoupper(substr(optional($trajet->conducteur)->nom, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-bold text-white text-base">{{ optional($trajet->conducteur)->nom }}</p>
                        <p class="text-xs text-slate-300">
                            {{ optional($trajet->conducteur)->ville_residence }} • {{ optional(optional($trajet->conducteur)->entreprise)->nom }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 1. Si le visiteur est le conducteur du trajet --}}
            @if($isOwner)
                <div class="pro-card p-6 bg-amber-500/10 border-l-4 border-l-amber-500 text-amber-200 space-y-2">
                    <p class="font-bold text-base">👑 Vous êtes le conducteur de ce trajet</p>
                    <p class="text-xs text-slate-300">Vous pouvez gérer les réservations reçues pour ce trajet ou modifier ses informations.</p>
                    <div class="pt-2 flex gap-3">
                        <a href="{{ route('reservations.conducteur.index') }}" class="btn-pro-primary text-xs">Gérer les demandes →</a>
                        <a href="{{ route('trajets.edit', $trajet) }}" class="btn-pro-secondary text-xs">Modifier le trajet</a>
                    </div>
                </div>
            @endif

            {{-- 2. Section Réservation pour les passagers --}}
            @if($isPassagerRole && !$isOwner)

                <script>
                    function scoreIA(trajetId, depart, destination, heureDepart, villeResidence) {
                        return {
                            villeDepart: villeResidence || depart,
                            villeArrivee: destination,
                            horaire: heureDepart ? heureDepart.substring(0, 5) : '',
                            loading: false,
                            error: null,
                            result: null,
                            async calculer() {
                                this.loading = true;
                                this.error = null;
                                this.result = null;
                                try {
                                    const res = await fetch(`/trajets/${trajetId}/compatibilite`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        },
                                        body: JSON.stringify({
                                            ville_depart: this.villeDepart,
                                            ville_arrivee: this.villeArrivee,
                                            horaire: this.horaire,
                                        }),
                                    });
                                    const data = await res.json();
                                    if (!res.ok) throw new Error(data.message || "Erreur lors du calcul.");
                                    this.result = data;
                                } catch (e) {
                                    this.error = e.message;
                                } finally {
                                    this.loading = false;
                                }
                            },
                        };
                    }
                </script>

                <div class="pro-card p-8 space-y-6"
                     x-data="scoreIA(
                         {{ $trajet->id }},
                         {{ Js::from($trajet->depart) }},
                         {{ Js::from($trajet->destination) }},
                         {{ Js::from($trajet->heure_depart) }},
                         {{ Js::from(auth()->user()->ville_residence ?? '') }}
                     )">
                    <h3 class="font-bold text-white text-lg border-b border-white/10 pb-3">Réserver une place</h3>

                    @if(session('success'))
                        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-sm font-semibold text-emerald-400">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-sm font-semibold text-rose-400">
                            @foreach($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if($trajet->placesRestantes() <= 0)
                        <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-sm font-bold text-rose-400 text-center">
                            🔴 Ce trajet est complet. Aucune place disponible.
                        </div>
                    @else
                        {{-- Score IA Box --}}
                        <div class="pro-card p-4 space-y-3">
                            <p class="text-xs font-semibold uppercase tracking-wide" style="color: var(--text-muted)">
                                🧠 Vérification de compatibilité IA
                            </p>

                            <div class="grid sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs mb-1" style="color: var(--text-muted)">Ville de départ souhaitée</label>
                                    <input type="text" class="pro-input" x-model="villeDepart">
                                </div>
                                <div>
                                    <label class="block text-xs mb-1" style="color: var(--text-muted)">Ville d'arrivée souhaitée</label>
                                    <input type="text" class="pro-input" x-model="villeArrivee">
                                </div>
                                <div>
                                    <label class="block text-xs mb-1" style="color: var(--text-muted)">Horaire souhaité</label>
                                    <input type="time" class="pro-input" x-model="horaire">
                                </div>
                            </div>

                            <button type="button" class="btn-pro-secondary text-xs" @click="calculer()" :disabled="loading">
                                <span x-show="!loading">Calculer la compatibilité IA</span>
                                <span x-show="loading">Analyse en cours...</span>
                            </button>

                            <template x-if="error">
                                <p class="text-xs" style="color: var(--accent-rose)" x-text="error"></p>
                            </template>

                            <template x-if="result">
                                <div class="pt-3 space-y-2" style="border-top: 1px solid var(--border-subtle)">
                                    <div class="flex justify-between items-center flex-wrap gap-2">
                                        <span class="pro-badge"
                                              :class="result.score >= 70 ? 'pro-badge-emerald' : (result.score >= 40 ? 'pro-badge-amber' : 'pro-badge-rose')">
                                            Score : <span x-text="result.score"></span>/100
                                        </span>
                                        <template x-if="result.horaire_suggere">
                                            <span class="text-xs" style="color: var(--text-muted)">
                                                Horaire suggéré : <strong x-text="result.horaire_suggere"></strong>
                                            </span>
                                        </template>
                                    </div>
                                    <p class="text-xs leading-relaxed" style="color: var(--text-muted)" x-text="result.justification"></p>
                                </div>
                            </template>
                        </div>

                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="trajet_id" value="{{ $trajet->id }}">
                            <button type="submit" class="btn-pro-primary w-full py-3.5 text-base font-bold">
                                ✋ Confirmer la demande de réservation
                            </button>
                        </form>
                    @endif
                </div>
            @endif


        </div>
    </div>
</x-app-layout>
