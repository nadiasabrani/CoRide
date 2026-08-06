<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display font-bold text-2xl text-white">
                🚗 Tous les trajets disponibles
            </h2>
            @if(in_array(auth()->user()->role, ['conducteur', 'les_deux']))
                <a href="{{ route('trajets.create') }}" class="btn-pro-primary text-xs">
                    + Publier un trajet
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-sm font-semibold text-emerald-400">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Filter & Total Info Bar --}}
            <div class="flex items-center justify-between bg-[#151D2A] border border-white/10 rounded-xl p-4">
                <a href="{{ route('trajets.search') }}" class="btn-pro-secondary text-xs">
                    🔍 Recherche & Filtres Avancés
                </a>
                <span class="text-xs font-mono text-slate-300">
                    <strong class="text-white font-bold">{{ $trajets->count() }}</strong> trajet(s) trouvé(s)
                </span>
            </div>

            {{-- Trajets Cards List --}}
            <div class="space-y-4">
                @forelse($trajets as $trajet)
                    @php $restantes = $trajet->placesRestantes(); @endphp
                    <div class="pro-card p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            
                            {{-- Route details --}}
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

                            {{-- Middle Info --}}
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="pro-badge pro-badge-emerald font-bold text-sm">
                                    {{ $trajet->prix }} DH
                                </span>

                                <span class="pro-badge {{ $restantes > 0 ? 'pro-badge-blue' : 'pro-badge-rose' }}">
                                    {{ $restantes > 0 ? "🟢 {$restantes} place(s) libre(s)" : '🔴 Complet' }}
                                </span>

                                <span class="text-xs text-slate-300 font-medium bg-white/5 border border-white/10 px-2.5 py-1 rounded-md">
                                    👤 Conducteur: <strong class="text-white">{{ optional($trajet->conducteur)->nom }}</strong>
                                </span>

                                @if($trajet->jours_recurrence)
                                    <span class="pro-badge pro-badge-slate">
                                        🔁 {{ $trajet->joursRecurrenceFormates() }}
                                    </span>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-3">
                                <a href="{{ route('trajets.show', $trajet) }}" class="btn-pro-primary text-xs py-2">
                                    Consulter →
                                </a>

                                @if(auth()->id() === $trajet->conducteur_id)
                                    <a href="{{ route('trajets.edit', $trajet) }}" class="btn-pro-secondary text-xs py-2">
                                        ✏️ Modifier
                                    </a>
                                    <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Supprimer ce trajet ?')" class="px-3 py-2 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 rounded-lg text-xs font-semibold transition">
                                            🗑️
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="pro-card p-12 text-center">
                        <div class="text-5xl mb-3">🚗</div>
                        <p class="text-lg font-bold text-white">Aucun trajet disponible</p>
                        <p class="text-sm text-slate-400 mt-1">Soyez le premier à proposer un trajet aux employés de votre entreprise.</p>
                        @if(in_array(auth()->user()->role, ['conducteur', 'les_deux']))
                            <a href="{{ route('trajets.create') }}" class="btn-pro-primary mt-4 inline-flex">
                                Publier le premier trajet →
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
