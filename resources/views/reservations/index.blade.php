<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-bold text-2xl text-white">
            📋 Mes réservations (Passager)
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

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

            {{-- Summary bar --}}
            <div class="flex items-center justify-between bg-[#151D2A] border border-white/10 rounded-xl p-4">
                <p class="text-xs font-mono text-slate-300">
                    Total: <strong class="text-white font-bold">{{ $reservations->count() }}</strong> réservation(s)
                </p>
                <a href="{{ route('trajets.search') }}" class="btn-pro-primary text-xs">
                    🔍 Rechercher un nouveau trajet
                </a>
            </div>

            <div class="space-y-4">
                @forelse($reservations as $reservation)
                    @php
                        $badges = [
                            'en_attente' => 'pro-badge-amber',
                            'confirmee'  => 'pro-badge-emerald',
                            'refusee'    => 'pro-badge-rose',
                            'annulee'    => 'pro-badge-slate',
                        ];
                        $labels = [
                            'en_attente' => '⏳ En attente de confirmation',
                            'confirmee'  => '✅ Réservation Confirmée',
                            'refusee'    => '❌ Demande Refusée',
                            'annulee'    => '🚫 Réservation Annulée',
                        ];
                        $badgeClass = $badges[$reservation->statut] ?? 'pro-badge-slate';
                        $statusLabel = $labels[$reservation->statut] ?? $reservation->statut;
                    @endphp

                    <div class="pro-card p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                            
                            {{-- Trajet Info --}}
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl font-bold text-white">{{ $reservation->trajet->depart }}</span>
                                    <span class="text-blue-400 font-bold">→</span>
                                    <span class="text-xl font-bold text-white">{{ $reservation->trajet->destination }}</span>
                                </div>
                                <p class="text-xs font-mono text-slate-300">
                                    Départ: <strong class="text-white">{{ \Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }}</strong> à <strong class="text-blue-400">{{ $reservation->trajet->heure_depart }}</strong>
                                    • Prix: <strong class="text-emerald-400 font-bold">{{ $reservation->trajet->prix }} DH</strong>
                                </p>
                                <p class="text-[11px] text-slate-400">
                                    Réservation faite le {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            {{-- Status & Action --}}
                            <div class="flex flex-col sm:items-end gap-3">
                                <span class="pro-badge {{ $badgeClass }} text-sm py-1 px-3">
                                    {{ $statusLabel }}
                                </span>

                                <div class="flex items-center gap-3">
                                    <a href="{{ route('trajets.show', $reservation->trajet) }}" class="text-xs text-blue-400 hover:underline font-semibold">
                                        Détails du trajet →
                                    </a>

                                    @if($reservation->estAnnulable())
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Annuler cette réservation ?')" class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 rounded-lg text-xs font-semibold transition">
                                                Annuler ma demande
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="pro-card p-12 text-center">
                        <div class="text-5xl mb-3">📋</div>
                        <p class="text-lg font-bold text-white">Aucune réservation trouvée</p>
                        <p class="text-sm text-slate-400 mt-1">Recherchez un trajet proposé par vos collègues pour soumettre votre demande.</p>
                        <a href="{{ route('trajets.search') }}" class="btn-pro-primary mt-4 inline-flex">
                            🔍 Rechercher un trajet
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
