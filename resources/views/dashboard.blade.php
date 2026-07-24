<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tableau de bord
        </h2>
    </x-slot>

    @php
        $isConducteur = in_array($employe->role, ['conducteur', 'les_deux']);
        $isPassager   = in_array($employe->role, ['passager', 'les_deux']);
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Bienvenue --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 rounded-full p-4">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">Bienvenue, {{ $employe->nom }} 👋</h3>
                        <p class="text-indigo-200 mt-1">
                            {{ $employe->email }} •
                            <span class="font-medium capitalize px-2 py-0.5 bg-white/20 rounded-full text-xs">Rôle : {{ str_replace('_', ' ', $employe->role) }}</span>
                            • {{ optional($employe->entreprise)->nom }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Stats rapides adaptées au rôle --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                @if($isConducteur)
                    {{-- Trajets publiés --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-indigo-500">
                        <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">Trajets publiés</p>
                        <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $trajets->count() }}</p>
                        <a href="{{ route('trajets.index') }}" class="text-sm text-indigo-500 hover:underline mt-2 block">Voir tous →</a>
                    </div>

                    {{-- Réservations reçues (conducteur) --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-green-500">
                        <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">Demandes reçues</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalReservationsRecues }}</p>
                        <a href="{{ route('reservations.conducteur.index') }}" class="text-sm text-green-500 hover:underline mt-2 block">Gérer →</a>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-yellow-500">
                        <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">Demandes en attente</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $reservationsEnAttente }}</p>
                        <a href="{{ route('reservations.conducteur.index') }}" class="text-sm text-yellow-500 hover:underline mt-2 block">Traiter →</a>
                    </div>
                @endif

                @if($isPassager)
                    {{-- Mes réservations passager --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 border-l-4 border-purple-500">
                        <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">Mes réservations</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $mesReservations }}</p>
                        <a href="{{ route('reservations.index') }}" class="text-sm text-purple-500 hover:underline mt-2 block">Voir →</a>
                    </div>
                @endif
            </div>

            {{-- Actions rapides adaptées --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h4 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Actions rapides</h4>
                <div class="flex flex-wrap gap-3">
                    @if($isPassager)
                        <a href="{{ route('trajets.search') }}"
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                            🔍 Rechercher un trajet
                        </a>
                        <a href="{{ route('reservations.index') }}"
                           class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                            📋 Mes réservations
                        </a>
                    @endif

                    @if($isConducteur)
                        <a href="{{ route('trajets.create') }}"
                           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            ➕ Publier un trajet
                        </a>
                        <a href="{{ route('reservations.conducteur.index') }}"
                           class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition">
                            🎛️ Gérer les demandes
                        </a>
                    @endif

                    <a href="{{ route('employes.index') }}"
                       class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                        👥 Annuaire
                    </a>
                </div>
            </div>

            {{-- Profil & Entreprise --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">👤 Mon profil</h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Nom</dt>
                            <dd class="font-medium dark:text-gray-100">{{ $employe->nom }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="font-medium dark:text-gray-100">{{ $employe->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Ville de résidence</dt>
                            <dd class="font-medium dark:text-gray-100">{{ $employe->ville_residence }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Rôle</dt>
                            <dd>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $employe->role === 'conducteur' ? 'bg-blue-100 text-blue-800' :
                                       ($employe->role === 'passager' ? 'bg-green-100 text-green-800' :
                                        'bg-purple-100 text-purple-800') }}">
                                    {{ str_replace('_', ' ', $employe->role) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                    <a href="{{ route('profile.edit') }}" class="mt-4 block text-sm text-indigo-500 hover:underline">Modifier mon profil →</a>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">🏢 Mon entreprise</h4>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Nom</dt>
                            <dd class="font-medium dark:text-gray-100">{{ optional($employe->entreprise)->nom ?? 'Non définie' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Ville</dt>
                            <dd class="font-medium dark:text-gray-100">{{ optional($employe->entreprise)->ville ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="font-medium dark:text-gray-100">{{ optional($employe->entreprise)->email ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Téléphone</dt>
                            <dd class="font-medium dark:text-gray-100">{{ optional($employe->entreprise)->telephone ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Mes trajets publiés (Conducteurs & les_deux) --}}
            @if($isConducteur)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-700">
                        <h4 class="font-semibold text-gray-700 dark:text-gray-200">🚗 Mes trajets publiés</h4>
                        <a href="{{ route('trajets.create') }}"
                           class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg transition">
                            + Nouveau
                        </a>
                    </div>

                    @if($trajets->isEmpty())
                        <div class="p-8 text-center text-gray-500">
                            <p class="text-lg">Vous n'avez pas encore publié de trajet.</p>
                            <a href="{{ route('trajets.create') }}" class="mt-3 inline-block text-indigo-600 hover:underline">Publier mon premier trajet →</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trajet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date / Heure</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Places</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Récurrence</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($trajets as $trajet)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            <td class="px-6 py-4">
                                                <span class="font-medium dark:text-gray-100">{{ $trajet->depart }}</span>
                                                <span class="text-gray-400 mx-1">→</span>
                                                <span class="font-medium dark:text-gray-100">{{ $trajet->destination }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                                                à {{ $trajet->heure_depart }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm font-medium
                                                    {{ $trajet->placesRestantes() > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $trajet->placesRestantes() }}/{{ $trajet->places }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $trajet->joursRecurrenceFormates() }}
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                <a href="{{ route('trajets.show', $trajet) }}"
                                                   class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-300">Voir</a>
                                                <a href="{{ route('trajets.edit', $trajet) }}"
                                                   class="text-sm text-indigo-600 hover:text-indigo-800">Modifier</a>
                                                <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Supprimer ce trajet ?')"
                                                            class="text-sm text-red-600 hover:text-red-800">
                                                        Supprimer
                                                    </button>
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
