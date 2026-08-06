<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter une réservation
        </h2>
    </x-slot>

    <script>
        function reservationForm(trajets, villeResidence) {
            return {
                trajets: trajets,
                selectedId: '',
                villeDepart: villeResidence || '',
                villeArrivee: '',
                horaire: '',
                loading: false,
                error: null,
                result: null,
                onSelect() {
                    this.result = null;
                    this.error = null;
                    const t = this.trajets.find(tr => String(tr.id) === String(this.selectedId));
                    if (t) {
                        this.villeArrivee = t.destination;
                        this.horaire = t.heure_depart ? t.heure_depart.substring(0, 5) : '';
                        if (!this.villeDepart) {
                            this.villeDepart = t.depart;
                        }
                    }
                },
                async calculer() {
                    if (!this.selectedId) return;
                    this.loading = true;
                    this.error = null;
                    this.result = null;
                    try {
                        const res = await fetch(`/trajets/${this.selectedId}/compatibilite`, {
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
                        if (!res.ok) {
                            throw new Error(data.message || "Erreur lors du calcul de compatibilité.");
                        }
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

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"
             x-data="reservationForm({{ Js::from($trajets->map(fn ($t) => [
                 'id' => $t->id,
                 'depart' => $t->depart,
                 'destination' => $t->destination,
                 'heure_depart' => $t->heure_depart,
             ])) }}, {{ Js::from(auth()->user()->ville_residence ?? '') }})">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Trajet</label>

                        <select name="trajet_id" class="w-full border rounded p-2" required
                                x-model="selectedId" @change="onSelect()">
                            <option value="">-- Choisir un trajet --</option>

                            @foreach($trajets as $trajet)
                                <option value="{{ $trajet->id }}">
                                    {{ $trajet->depart }} → {{ $trajet->destination }}
                                    ({{ $trajet->date_depart->format('Y-m-d') }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Score IA Box : apparaît dès qu'un trajet est sélectionné -->
                    <div class="mb-4" x-show="selectedId" x-cloak>
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
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">
                            Nombre de places
                        </label>

                        <input
                            type="number"
                            name="nombre_places"
                            min="1"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                        Enregistrer
                    </button>

                    <a href="{{ route('reservations.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded ml-2">
                        Annuler
                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
