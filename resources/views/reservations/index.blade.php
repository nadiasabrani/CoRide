<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📋 Mes réservations
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl text-sm text-green-700 dark:text-green-300">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-xl text-sm text-red-700 dark:text-red-300">
                    @foreach($errors->all() as $erreur)
                        <p>• {{ $erreur }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Résumé --}}
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $reservations->count() }} réservation(s) au total
                </p>
                <a href="{{ route('trajets.search') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    🔍 Trouver un trajet
                </a>
            </div>

            @forelse($reservations as $reservation)
                @php
                    $couleurs = [
                        'en_attente' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-200', 'border' => 'border-yellow-300 dark:border-yellow-700'],
                        'confirmee'  => ['bg' => 'bg-green-100 dark:bg-green-900/30',  'text' => 'text-green-800 dark:text-green-200',  'border' => 'border-green-300 dark:border-green-700'],
                        'refusee'    => ['bg' => 'bg-red-100 dark:bg-red-900/30',    'text' => 'text-red-800 dark:text-red-200',    'border' => 'border-red-300 dark:border-red-700'],
                        'annulee'    => ['bg' => 'bg-gray-100 dark:bg-gray-700',      'text' => 'text-gray-600 dark:text-gray-400',   'border' => 'border-gray-300 dark:border-gray-600'],
                    ];
                    $c = $couleurs[$reservation->statut] ?? $couleurs['annulee'];
                    $icones = ['en_attente' => '⏳', 'confirmee' => '✅', 'refusee' => '❌', 'annulee' => '🚫'];
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="flex flex-col sm:flex-row">
                        {{-- Bande de statut --}}
                        <div class="{{ $c['bg'] }} sm:w-2 w-full h-2 sm:h-auto border-r {{ $c['border'] }}"></div>

                        <div class="flex-1 p-5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                {{-- Trajet --}}
                                <div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg font-bold dark:text-white">{{ $reservation->trajet->depart }}</span>
                                        <span class="text-gray-400">→</span>
                                        <span class="text-lg font-bold dark:text-white">{{ $reservation->trajet->destination }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($reservation->trajet->date_depart)->format('d/m/Y') }}
                                        à {{ $reservation->trajet->heure_depart }}
                                        • {{ $reservation->trajet->prix }} DH
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        Réservé le {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}
                                    </p>
                                </div>

                                {{-- Statut + Actions --}}
                                <div class="flex flex-col sm:items-end gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }}">
                                        {{ $icones[$reservation->statut] ?? '' }}
                                        {{ str_replace('_', ' ', $reservation->statut) }}
                                    </span>

                                    <div class="flex gap-2">
                                        <a href="{{ route('trajets.show', $reservation->trajet) }}"
                                           class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Voir le trajet →
                                        </a>

                                        @if($reservation->estAnnulable())
                                            <form action="{{ route('reservations.destroy', $reservation) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Annuler cette réservation ?')"
                                                        class="text-xs text-red-600 dark:text-red-400 hover:underline">
                                                    Annuler
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-12 text-center">
                    <div class="text-6xl mb-4">📋</div>
                    <p class="text-lg font-medium text-gray-700 dark:text-gray-200">Aucune réservation pour le moment</p>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Trouvez un trajet et faites votre première demande de réservation.</p>
                    <a href="{{ route('trajets.search') }}"
                       class="mt-4 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        🔍 Rechercher un trajet
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
