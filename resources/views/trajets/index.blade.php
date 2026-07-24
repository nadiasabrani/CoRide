<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🚗 Tous les trajets
            </h2>
            @if(in_array(auth()->user()->role, ['conducteur', 'les_deux']))
                <a href="{{ route('trajets.create') }}"
                   class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    + Publier un trajet
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl text-sm text-green-700 dark:text-green-300">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Barre de recherche rapide --}}
            <div class="flex gap-3">
                <a href="{{ route('trajets.search') }}"
                   class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg text-sm transition shadow-sm">
                    🔍 Recherche avancée
                </a>
                <span class="self-center text-sm text-gray-500 dark:text-gray-400">
                    {{ $trajets->count() }} trajet(s) au total
                </span>
            </div>

            {{-- Liste des trajets --}}
            @forelse($trajets as $trajet)
                @php $restantes = $trajet->placesRestantes(); @endphp
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-md transition-shadow overflow-hidden">
                    <div class="flex flex-col sm:flex-row">
                        <div class="bg-brand-800 sm:w-2 w-full h-2 sm:h-auto"></div>
                        <div class="flex-1 p-5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                {{-- Trajet --}}
                                <div class="flex items-center gap-4">
                                    <div>
                                        <p class="text-lg font-bold dark:text-white">{{ $trajet->depart }}</p>
                                        <p class="text-xs text-gray-500">{{ $trajet->heure_depart }}</p>
                                    </div>
                                    <span class="text-gray-300 dark:text-gray-600 text-xl">→</span>
                                    <div>
                                        <p class="text-lg font-bold dark:text-white">{{ $trajet->destination }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Badges --}}
                                <div class="flex flex-wrap gap-2 items-center">
                                    <span class="text-sm font-bold text-brand-700 dark:text-brand-400">{{ $trajet->prix }} DH</span>

                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $restantes > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                          : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $restantes > 0 ? "{$restantes} place(s)" : 'Complet' }}
                                    </span>

                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        👤 {{ optional($trajet->conducteur)->nom }}
                                    </span>

                                    @if($trajet->jours_recurrence)
                                        <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs">
                                            🔁 {{ $trajet->joursRecurrenceFormates() }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex gap-2 items-center">
                                    <a href="{{ route('trajets.show', $trajet) }}"
                                       class="text-sm bg-brand-50 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition">
                                        Voir
                                    </a>

                                    @if(auth()->id() === $trajet->conducteur_id)
                                        <a href="{{ route('trajets.edit', $trajet) }}"
                                           class="text-sm bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-100 px-3 py-1.5 rounded-lg transition">
                                            ✏️ Modifier
                                        </a>
                                        <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Supprimer ce trajet ?')"
                                                    class="text-sm bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-12 text-center">
                    <div class="text-6xl mb-4">🚗</div>
                    <p class="text-lg font-medium text-gray-700 dark:text-gray-200">Aucun trajet disponible</p>
                    @if(in_array(auth()->user()->role, ['conducteur', 'les_deux']))
                        <a href="{{ route('trajets.create') }}" class="mt-3 inline-block text-brand-600 hover:underline">
                            Publiez le premier trajet →
                        </a>
                    @endif
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
