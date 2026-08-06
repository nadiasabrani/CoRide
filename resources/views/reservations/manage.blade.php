<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-bold text-2xl text-white">
            🎛️ Gestion des réservations reçues
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-sm font-semibold text-emerald-400">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-sm font-semibold text-rose-400">
                    @foreach($errors->all() as $erreur)
                        <p>• {{ $erreur }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Quick Stats Bar --}}
            @php
                $totalReservations = $trajets->sum(fn($t) => $t->reservations->count());
                $enAttente = $trajets->sum(fn($t) => $t->reservations->where('statut', 'en_attente')->count());
                $confirmees = $trajets->sum(fn($t) => $t->reservations->where('statut', 'confirmee')->count());
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="pro-card p-5 border-l-4 border-l-blue-500 text-center">
                    <p class="text-3xl font-extrabold text-white">{{ $totalReservations }}</p>
                    <p class="text-xs font-mono text-slate-400 uppercase mt-1">Total Demandes Reçues</p>
                </div>
                <div class="pro-card p-5 border-l-4 border-l-amber-500 text-center">
                    <p class="text-3xl font-extrabold text-amber-400">{{ $enAttente }}</p>
                    <p class="text-xs font-mono text-slate-400 uppercase mt-1">En Attente de Traitement</p>
                </div>
                <div class="pro-card p-5 border-l-4 border-l-emerald-500 text-center">
                    <p class="text-3xl font-extrabold text-emerald-400">{{ $confirmees }}</p>
                    <p class="text-xs font-mono text-slate-400 uppercase mt-1">Réservations Confirmées</p>
                </div>
            </div>

            {{-- List of Trajets & Their Requests --}}
            @forelse($trajets as $trajet)
                <div class="pro-card overflow-hidden">
                    <!-- Trajet Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4 bg-gradient-to-r from-blue-900/40 to-indigo-900/30 border-b border-white/10 gap-3">
                        <div>
                            <h3 class="font-bold text-white text-lg">
                                {{ $trajet->depart }} <span class="text-blue-400 font-normal">→</span> {{ $trajet->destination }}
                            </h3>
                            <p class="text-xs font-mono text-slate-300 mt-0.5">
                                {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }} à {{ $trajet->heure_depart }}
                                • <span class="font-bold {{ $trajet->placesRestantes() > 0 ? 'text-emerald-400' : 'text-rose-400' }}">{{ $trajet->placesRestantes() }}/{{ $trajet->places }} place(s) libre(s)</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="pro-badge pro-badge-blue">
                                {{ $trajet->reservations->count() }} demande(s)
                            </span>
                            <a href="{{ route('trajets.show', $trajet) }}" class="btn-pro-secondary text-xs py-1.5 px-3">
                                Voir trajet →
                            </a>
                        </div>
                    </div>

                    <!-- Requests List -->
                    @if($trajet->reservations->isEmpty())
                        <div class="px-6 py-6 text-center text-slate-400 text-xs font-mono">
                            Aucune demande de réservation enregistrée pour ce trajet.
                        </div>
                    @else
                        <div class="divide-y divide-white/5">
                            @foreach($trajet->reservations as $reservation)
                                @php
                                    $statusMap = [
                                        'en_attente' => ['label' => '⏳ En attente', 'badge' => 'pro-badge-amber'],
                                        'confirmee'  => ['label' => '✅ Confirmée',  'badge' => 'pro-badge-emerald'],
                                        'refusee'    => ['label' => '❌ Refusée',    'badge' => 'pro-badge-rose'],
                                        'annulee'    => ['label' => '🚫 Annulée',    'badge' => 'pro-badge-slate'],
                                    ];
                                    $st = $statusMap[$reservation->statut] ?? ['label' => $reservation->statut, 'badge' => 'pro-badge-slate'];
                                @endphp

                                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 hover:bg-white/5 transition">
                                    <!-- Passenger info -->
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-lg bg-blue-600/20 text-blue-400 border border-blue-500/30 flex items-center justify-center font-bold text-xs">
                                            👤
                                        </div>
                                        <div>
                                            <p class="font-bold text-white text-sm">{{ $reservation->passager->nom }}</p>
                                            <p class="text-xs text-slate-400">
                                                {{ $reservation->passager->email }} • Ville: <span class="text-slate-200 font-semibold">{{ $reservation->passager->ville_residence }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Status & Action Buttons -->
                                    <div class="flex items-center gap-3">
                                        <span class="pro-badge {{ $st['badge'] }}">
                                            {{ $st['label'] }}
                                        </span>

                                        @if($reservation->statut === 'en_attente')
                                            <form action="{{ route('reservations.statut.update', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="confirmee">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 border border-emerald-500/40 rounded-lg text-xs font-bold transition">
                                                    ✅ Confirmer
                                                </button>
                                            </form>

                                            <form action="{{ route('reservations.statut.update', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="refusee">
                                                <button type="submit" onclick="return confirm('Refuser la demande de {{ $reservation->passager->nom }} ?')" class="px-3 py-1.5 bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/40 rounded-lg text-xs font-bold transition">
                                                    ❌ Refuser
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="pro-card p-12 text-center">
                    <div class="text-5xl mb-3">🚗</div>
                    <p class="text-lg font-bold text-white">Vous n'avez publié aucun trajet</p>
                    <p class="text-sm text-slate-400 mt-1">Publiez votre premier trajet pour recevoir des demandes de covoiturage.</p>
                    <a href="{{ route('trajets.create') }}" class="btn-pro-primary mt-4 inline-flex">
                        + Publier un trajet
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
