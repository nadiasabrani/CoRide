<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🔍 Rechercher un trajet
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Formulaire de recherche --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <form method="GET" action="{{ route('trajets.search') }}" class="space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Ville de départ
                            </label>
                            <input type="text" name="depart"
                                   value="{{ request('depart') }}"
                                   placeholder="Ex: Casablanca"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Destination
                            </label>
                            <input type="text" name="destination"
                                   value="{{ request('destination') }}"
                                   placeholder="Ex: Rabat"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Conducteur
                            </label>
                            <select name="conducteur_id"
                                    class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Tous les conducteurs</option>
                                @foreach($conducteurs as $conducteur)
                                    <option value="{{ $conducteur->id }}" {{ request('conducteur_id') == $conducteur->id ? 'selected' : '' }}>
                                        👤 {{ $conducteur->nom }} ({{ optional($conducteur->entreprise)->nom }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date de départ
                            </label>
                            <input type="date" name="date_depart"
                                   value="{{ request('date_depart') }}"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Horaire <span class="text-gray-400">(± 30 min)</span>
                            </label>
                            <input type="time" name="heure_depart"
                                   value="{{ request('heure_depart') }}"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                            🔍 Filtrer les trajets
                        </button>
                        <a href="{{ route('trajets.search') }}"
                           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-lg font-medium transition">
                            ✕ Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            {{-- Résultats --}}
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    @if(request()->hasAny(['depart', 'destination', 'date_depart', 'heure_depart', 'conducteur_id']))
                        {{ $trajets->count() }} trajet(s) trouvé(s) pour votre recherche
                    @else
                        {{ $trajets->count() }} trajet(s) disponibles au total
                    @endif
                </p>

                @forelse($trajets as $trajet)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow mb-4 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row">
                            {{-- Bande colorée --}}
                            <div class="bg-gradient-to-b from-indigo-600 to-purple-600 sm:w-2 w-full h-2 sm:h-auto"></div>

                            <div class="flex-1 p-5">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    {{-- Trajet --}}
                                    <div class="flex items-center gap-4">
                                        <div class="text-center">
                                            <p class="text-lg font-bold dark:text-white">{{ $trajet->depart }}</p>
                                            <p class="text-xs text-gray-500">{{ $trajet->heure_depart }}</p>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <div class="text-gray-300 dark:text-gray-600">─────</div>
                                            <span class="text-xs text-indigo-600 dark:text-indigo-400">🚗</span>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-lg font-bold dark:text-white">{{ $trajet->destination }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Infos --}}
                                    <div class="flex flex-wrap gap-3 items-center">
                                        {{-- Places --}}
                                        @php $restantes = $trajet->placesRestantes(); @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $restantes > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                              : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $restantes > 0 ? "🟢 {$restantes} place(s)" : '🔴 Complet' }}
                                        </span>

                                        {{-- Prix --}}
                                        <span class="text-sm font-bold text-indigo-700 dark:text-indigo-400">
                                            {{ $trajet->prix }} DH
                                        </span>

                                        {{-- Conducteur cliquable --}}
                                        <a href="{{ route('trajets.search', ['conducteur_id' => $trajet->conducteur_id]) }}"
                                           title="Filtrer uniquement les trajets de {{ optional($trajet->conducteur)->nom }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 hover:text-indigo-600 transition">
                                            👤 {{ optional($trajet->conducteur)->nom }}
                                            <span class="text-[10px] opacity-75">({{ optional(optional($trajet->conducteur)->entreprise)->nom }})</span>
                                        </a>

                                        {{-- Récurrence --}}
                                        @if($trajet->jours_recurrence)
                                            <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs">
                                                🔁 {{ $trajet->joursRecurrenceFormates() }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Bouton voir/réserver --}}
                                    <div>
                                        <a href="{{ route('trajets.show', $trajet) }}"
                                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Voir le trajet →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-12 text-center">
                        <div class="text-6xl mb-4">🚗</div>
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-200">Aucun trajet trouvé</p>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Essayez de modifier vos critères de recherche.</p>
                        <a href="{{ route('trajets.search') }}" class="mt-4 inline-block text-indigo-600 hover:underline">
                            Voir tous les trajets →
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>