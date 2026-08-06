<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-bold text-2xl text-white">
            Tableau de bord
        </h2>
    </x-slot>

    @php
        $isConducteur = in_array($employe->role, ['conducteur', 'les_deux']);
        $isPassager   = in_array($employe->role, ['passager', 'les_deux']);
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Bienvenue Banner --}}
            <div class="pro-card p-8 bg-gradient-to-r from-blue-900/40 via-indigo-900/30 to-[#151D2A] border-l-4 border-l-blue-500">
                <div class="flex items-center gap-5">
                    <div class="h-14 w-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-bold text-xl flex items-center justify-center font-display shadow-lg shadow-blue-500/20 shrink-0">
                        {{ strtoupper(substr($employe->nom, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Bienvenue, {{ $employe->nom }} 👋</h3>
                        <p class="text-slate-300 text-sm mt-1 flex flex-wrap items-center gap-2">
                            <span>{{ $employe->email }}</span>
                            <span class="text-slate-500">•</span>
                            <span class="pro-badge pro-badge-blue capitalize">Rôle : {{ str_replace('_', ' ', $employe->role) }}</span>
                            <span class="text-slate-500">•</span>
                            <span class="text-slate-200 font-semibold">{{ optional($employe->entreprise)->nom }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @if($isConducteur)
                    <div class="pro-card p-5 border-l-4 border-l-blue-500">
                        <p class="text-xs font-mono text-slate-400 uppercase tracking-wider font-semibold">Trajets publiés</p>
                        <p class="text-3xl font-extrabold text-white mt-2">{{ $trajets->count() }}</p>
                        <a href="{{ route('trajets.index') }}" class="text-xs font-semibold text-blue-400 hover:text-blue-300 mt-3 inline-block">Voir tous les trajets →</a>
                    </div>

                    <div class="pro-card p-5 border-l-4 border-l-emerald-500">
                        <p class="text-xs font-mono text-slate-400 uppercase tracking-wider font-semibold">Demandes reçues</p>
                        <p class="text-3xl font-extrabold text-emerald-400 mt-2">{{ $totalReservationsRecues }}</p>
                        <a href="{{ route('reservations.conducteur.index') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 mt-3 inline-block">Gérer les demandes →</a>
                    </div>

                    <div class="pro-card p-5 border-l-4 border-l-amber-500">
                        <p class="text-xs font-mono text-slate-400 uppercase tracking-wider font-semibold">En attente</p>
                        <p class="text-3xl font-extrabold text-amber-400 mt-2">{{ $reservationsEnAttente }}</p>
                        <a href="{{ route('reservations.conducteur.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300 mt-3 inline-block">Traiter →</a>
                    </div>
                @endif

                @if($isPassager)
                    <div class="pro-card p-5 border-l-4 border-l-indigo-500">
                        <p class="text-xs font-mono text-slate-400 uppercase tracking-wider font-semibold">Mes réservations</p>
                        <p class="text-3xl font-extrabold text-indigo-400 mt-2">{{ $mesReservations }}</p>
                        <a href="{{ route('reservations.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 mt-3 inline-block">Voir mes demandes →</a>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="pro-card p-6">
                <h4 class="font-bold text-white text-base mb-4">Actions rapides</h4>
                <div class="flex flex-wrap gap-3">
                    @if($isPassager)
                        <a href="{{ route('trajets.search') }}" class="btn-pro-primary">
                            🔍 Rechercher un trajet
                        </a>
                        <a href="{{ route('reservations.index') }}" class="btn-pro-secondary">
                            📋 Mes réservations
                        </a>
                    @endif

                    @if($isConducteur)
                        <a href="{{ route('trajets.create') }}" class="btn-pro-primary">
                            ➕ Publier un trajet
                        </a>
                        <a href="{{ route('reservations.conducteur.index') }}" class="btn-pro-secondary">
                            🎛️ Gérer les demandes
                        </a>
                    @endif

                    <a href="{{ route('employes.index') }}" class="btn-pro-secondary">
                        👥 Annuaire
                    </a>
                </div>
            </div>

            {{-- Profile & Entreprise Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="pro-card p-6 space-y-4">
                    <h4 class="font-bold text-white text-base border-b border-white/10 pb-3">👤 Mon profil</h4>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Nom complet</dt>
                            <dd class="font-semibold text-white">{{ $employe->nom }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Email professionnel</dt>
                            <dd class="font-medium text-slate-200">{{ $employe->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Ville de résidence</dt>
                            <dd class="font-semibold text-white">{{ $employe->ville_residence }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-slate-400">Rôle principal</dt>
                            <dd><span class="pro-badge pro-badge-blue capitalize">{{ str_replace('_', ' ', $employe->role) }}</span></dd>
                        </div>
                    </dl>
                    <div class="pt-2">
                        <a href="{{ route('profile.edit') }}" class="text-xs font-semibold text-blue-400 hover:underline">Modifier mes informations →</a>
                    </div>
                </div>

                <div class="pro-card p-6 space-y-4">
                    <h4 class="font-bold text-white text-base border-b border-white/10 pb-3">🏢 Mon entreprise</h4>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Nom</dt>
                            <dd class="font-semibold text-white">{{ optional($employe->entreprise)->nom ?? 'Non définie' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Ville siège</dt>
                            <dd class="font-medium text-slate-200">{{ optional($employe->entreprise)->ville ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Email contact</dt>
                            <dd class="font-medium text-slate-200">{{ optional($employe->entreprise)->email ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-400">Téléphone</dt>
                            <dd class="font-medium text-slate-200">{{ optional($employe->entreprise)->telephone ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Mes trajets publiés Table (For Drivers) --}}
            @if($isConducteur)
                <div class="pro-card overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
                        <h4 class="font-bold text-white text-base">🚗 Mes trajets publiés</h4>
                        <a href="{{ route('trajets.create') }}" class="btn-pro-primary text-xs py-1.5 px-3">
                            + Nouveau trajet
                        </a>
                    </div>

                    @if($trajets->isEmpty())
                        <div class="p-8 text-center text-slate-400">
                            <p class="text-base font-medium">Vous n'avez pas encore publié de trajet.</p>
                            <a href="{{ route('trajets.create') }}" class="mt-2 inline-block text-sm text-blue-400 hover:underline">Publier mon premier trajet →</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-[#0D1420] text-xs font-mono uppercase text-slate-400 border-b border-white/10">
                                    <tr>
                                        <th class="px-6 py-3">Trajet</th>
                                        <th class="px-6 py-3">Date & Heure</th>
                                        <th class="px-6 py-3">Places</th>
                                        <th class="px-6 py-3">Récurrence</th>
                                        <th class="px-6 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($trajets as $trajet)
                                        <tr class="hover:bg-white/5 transition">
                                            <td class="px-6 py-4 font-bold text-white">
                                                {{ $trajet->depart }} <span class="text-slate-400 font-normal">→</span> {{ $trajet->destination }}
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-mono text-xs">
                                                {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }} à {{ $trajet->heure_depart }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="pro-badge {{ $trajet->placesRestantes() > 0 ? 'pro-badge-emerald' : 'pro-badge-rose' }}">
                                                    {{ $trajet->placesRestantes() }}/{{ $trajet->places }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 text-xs">
                                                {{ $trajet->joursRecurrenceFormates() }}
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-3">
                                                <a href="{{ route('trajets.show', $trajet) }}" class="text-slate-300 hover:text-white text-xs font-semibold">Voir</a>
                                                <a href="{{ route('trajets.edit', $trajet) }}" class="text-blue-400 hover:text-blue-300 text-xs font-semibold">Modifier</a>
                                                <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Supprimer ce trajet ?')" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
