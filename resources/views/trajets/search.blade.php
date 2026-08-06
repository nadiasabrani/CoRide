<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-bold text-2xl text-white">
            🔍 Rechercher un trajet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Formulaire de Recherche --}}
            <div class="pro-card p-6">
                <form method="GET" action="{{ route('trajets.search') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Ville de départ</label>
                            <input type="text" name="depart" value="{{ request('depart') }}" placeholder="Ex: Casablanca" class="pro-input">
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Destination</label>
                            <input type="text" name="destination" value="{{ request('destination') }}" placeholder="Ex: Rabat" class="pro-input">
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Conducteur</label>
                            <select name="conducteur_id" class="pro-input">
                                <option value="">Tous les conducteurs</option>
                                @foreach($conducteurs as $conducteur)
                                    <option value="{{ $conducteur->id }}" {{ request('conducteur_id') == $conducteur->id ? 'selected' : '' }}>
                                        👤 {{ $conducteur->nom }} ({{ optional($conducteur->entreprise)->nom }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Date de départ</label>
                            <input type="date" name="date_depart" value="{{ request('date_depart') }}" class="pro-input">
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Horaire (± 30 min)</label>
                            <input type="time" name="heure_depart" value="{{ request('heure_depart') }}" class="pro-input">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-pro-primary">
                            🔍 Filtrer les trajets
                        </button>
                        <a href="{{ route('trajets.search') }}" class="btn-pro-secondary">
                            ✕ Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            {{-- Résultats --}}
            <div>
                <p class="text-sm font-semibold text-slate-300 mb-4">
                    @if(request()->hasAny(['depart', 'destination', 'date_depart', 'heure_depart', 'conducteur_id']))
                        Résultats : <span class="text-blue-400 font-bold">{{ $trajets->count() }}</span> trajet(s) trouvé(s)
                    @else
                        Total : <span class="text-blue-400 font-bold">{{ $trajets->count() }}</span> trajet(s) disponibles
                    @endif
                </p>

                <div class="space-y-4">
                    @forelse($trajets as $trajet)
                        @php $restantes = $trajet->placesRestantes(); @endphp
                        <div class="pro-card p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                
                                <div class="flex items-center gap-6">
                                    <div>
                                        <p class="text-xs font-mono text-slate-400 uppercase">Départ</p>
                                        <p class="text-xl font-bold text-white mt-0.5">{{ $trajet->depart }}</p>
                                        <p class="text-xs font-mono text-blue-400 font-semibold mt-0.5">{{ $trajet->heure_depart }}</p>
                                    </div>
                                    <div class="flex flex-col items-center w-24">
                                        <div class="route-line-pro"></div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-mono text-slate-400 uppercase">Arrivée</p>
                                        <p class="text-xl font-bold text-white mt-0.5">{{ $trajet->destination }}</p>
                                        <p class="text-xs font-mono text-slate-300 mt-0.5">
                                            {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="pro-badge pro-badge-emerald font-bold text-sm">
                                        {{ $trajet->prix }} DH
                                    </span>

                                    <span class="pro-badge {{ $restantes > 0 ? 'pro-badge-blue' : 'pro-badge-rose' }}">
                                        {{ $restantes > 0 ? "🟢 {$restantes} place(s)" : '🔴 Complet' }}
                                    </span>

                                    <a href="{{ route('trajets.search', ['conducteur_id' => $trajet->conducteur_id]) }}" class="pro-badge pro-badge-slate hover:border-blue-400 transition">
                                        👤 {{ optional($trajet->conducteur)->nom }}
                                    </a>

                                    @if($trajet->jours_recurrence)
                                        <span class="pro-badge pro-badge-slate">
                                            🔁 {{ $trajet->joursRecurrenceFormates() }}
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <a href="{{ route('trajets.show', $trajet) }}" class="btn-pro-primary text-xs py-2">
                                        Voir le trajet →
                                    </a>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="pro-card p-12 text-center">
                            <div class="text-5xl mb-3">🔍</div>
                            <p class="text-lg font-bold text-white">Aucun trajet ne correspond à votre recherche</p>
                            <p class="text-sm text-slate-400 mt-1">Modifiez vos filtres ou réinitialisez la recherche.</p>
                            <a href="{{ route('trajets.search') }}" class="btn-pro-secondary mt-4 inline-flex">
                                Voir tous les trajets →
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>