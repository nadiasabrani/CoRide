<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gérer les réservations reçues
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        @foreach ($errors->all() as $erreur)
                            <p>{{ $erreur }}</p>
                        @endforeach
                    </div>
                @endif

                @forelse ($trajets as $trajet)
                    <div class="mb-8 bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold mb-1">
                            {{ $trajet->depart }} → {{ $trajet->destination }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-300 mb-4">
                            {{ $trajet->date_depart }} à {{ $trajet->heure_depart }} —
                            {{ $trajet->places }} place(s) au total
                        </p>

                        @if ($trajet->reservations->isEmpty())
                            <p class="text-gray-500">Aucune réservation reçue sur ce trajet.</p>
                        @else
                            <table class="min-w-full border">
                                <thead>
                                    <tr class="bg-gray-200 dark:bg-gray-600">
                                        <th class="border p-2">Passager</th>
                                        <th class="border p-2">Email</th>
                                        <th class="border p-2">Statut</th>
                                        <th class="border p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trajet->reservations as $reservation)
                                        <tr>
                                            <td class="border p-2">{{ $reservation->passager->nom }}</td>
                                            <td class="border p-2">{{ $reservation->passager->email }}</td>
                                            <td class="border p-2">
                                                @php
                                                    $couleurs = [
                                                        'en_attente' => 'bg-yellow-100 text-yellow-800',
                                                        'confirmee' => 'bg-green-100 text-green-800',
                                                        'refusee' => 'bg-red-100 text-red-800',
                                                        'annulee' => 'bg-gray-200 text-gray-600',
                                                    ];
                                                    $classe = $couleurs[$reservation->statut] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 py-1 rounded text-sm font-medium {{ $classe }}">
                                                    {{ str_replace('_', ' ', $reservation->statut) }}
                                                </span>
                                            </td>
                                            <td class="border p-2">
                                                @if ($reservation->statut === 'en_attente')
                                                    <form action="{{ route('reservations.statut.update', $reservation) }}"
                                                          method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="statut" value="confirmee">
                                                        <button type="submit" class="text-green-600 underline">
                                                            Confirmer
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('reservations.statut.update', $reservation) }}"
                                                          method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="statut" value="refusee">
                                                        <button type="submit"
                                                                onclick="return confirm('Refuser cette réservation ?')"
                                                                class="text-red-600 underline">
                                                            Refuser
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 text-sm">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Vous n'avez publié aucun trajet pour le moment.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
