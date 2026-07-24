<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🎛️ Gestion des réservations reçues
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl text-sm text-green-700 dark:text-green-300">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-xl">
                    @foreach($errors->all() as $erreur)
                        <p class="text-sm text-red-700 dark:text-red-300">• {{ $erreur }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Statistiques rapides --}}
            @php
                $totalReservations = $trajets->sum(fn($t) => $t->reservations->count());
                $enAttente = $trajets->sum(fn($t) => $t->reservations->where('statut', 'en_attente')->count());
                $confirmees = $trajets->sum(fn($t) => $t->reservations->where('statut', 'confirmee')->count());
            @endphp

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 border-l-4 border-indigo-500 text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ $totalReservations }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total reçues</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 border-l-4 border-yellow-500 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $enAttente }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">En attente</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 border-l-4 border-green-500 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $confirmees }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Confirmées</p>
                </div>
            </div>

            {{-- Trajets avec leurs réservations --}}
            @forelse($trajets as $trajet)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                    {{-- En-tête du trajet --}}
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-700 border-b dark:border-gray-600">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg">
                                {{ $trajet->depart }}
                                <span class="text-gray-400 font-normal mx-2">→</span>
                                {{ $trajet->destination }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($trajet->date_depart)->format('d/m/Y') }}
                                à {{ $trajet->heure_depart }}
                                •
                                <span class="{{ $trajet->placesRestantes() > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                    {{ $trajet->placesRestantes() }}/{{ $trajet->places }} place(s)
                                </span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $trajet->reservations->count() }} demande(s)
                            </span>
                            <a href="{{ route('trajets.show', $trajet) }}"
                               class="text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 px-3 py-1 rounded-lg transition">
                                Voir →
                            </a>
                        </div>
                    </div>

                    {{-- Réservations --}}
                    @if($trajet->reservations->isEmpty())
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <p class="text-sm">Aucune demande de réservation reçue pour ce trajet.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($trajet->reservations as $reservation)
                                @php
                                    $statuts = [
                                        'en_attente' => ['label' => 'En attente', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-200', 'icon' => '⏳'],
                                        'confirmee'  => ['label' => 'Confirmée',  'class' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',  'icon' => '✅'],
                                        'refusee'    => ['label' => 'Refusée',    'class' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',          'icon' => '❌'],
                                        'annulee'    => ['label' => 'Annulée',    'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',          'icon' => '🚫'],
                                    ];
                                    $s = $statuts[$reservation->statut] ?? $statuts['annulee'];
                                @endphp

                                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    {{-- Passager --}}
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-100 dark:bg-indigo-900 rounded-full p-2.5 shrink-0">
                                            <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium dark:text-gray-100">{{ $reservation->passager->nom }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $reservation->passager->email }}
                                                • {{ $reservation->passager->ville_residence }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Statut + Actions --}}
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold {{ $s['class'] }}">
                                            {{ $s['icon'] }} {{ $s['label'] }}
                                        </span>

                                        @if($reservation->statut === 'en_attente')
                                            <form action="{{ route('reservations.statut.update', $reservation) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="confirmee">
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1.5 rounded-lg transition">
                                                    ✅ Confirmer
                                                </button>
                                            </form>

                                            <form action="{{ route('reservations.statut.update', $reservation) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="refusee">
                                                <button type="submit"
                                                        onclick="return confirm('Refuser la demande de {{ $reservation->passager->nom }} ?')"
                                                        class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1.5 rounded-lg transition">
                                                    ❌ Refuser
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500 italic">— Aucune action disponible</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-12 text-center">
                    <div class="text-6xl mb-4">🚗</div>
                    <p class="text-lg font-medium text-gray-700 dark:text-gray-200">Vous n'avez publié aucun trajet</p>
                    <a href="{{ route('trajets.create') }}"
                       class="mt-4 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        + Publier mon premier trajet
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
