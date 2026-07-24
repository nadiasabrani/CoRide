<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mes réservations
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

                <div class="mt-2">
                    <table class="min-w-full border bg-white dark:bg-gray-700">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-600">
                                <th class="border p-2">Départ</th>
                                <th class="border p-2">Destination</th>
                                <th class="border p-2">Date</th>
                                <th class="border p-2">Heure</th>
                                <th class="border p-2">Statut</th>
                                <th class="border p-2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($reservations as $reservation)
                                <tr>
                                    <td class="border p-2">{{ $reservation->trajet->depart }}</td>
                                    <td class="border p-2">{{ $reservation->trajet->destination }}</td>
                                    <td class="border p-2">{{ $reservation->trajet->date_depart }}</td>
                                    <td class="border p-2">{{ $reservation->trajet->heure_depart }}</td>
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
                                        @if ($reservation->estAnnulable())
                                            <form action="{{ route('reservations.destroy', $reservation) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        onclick="return confirm('Annuler cette réservation ?')"
                                                        class="text-red-600 underline">
                                                    Annuler
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4">
                                        Vous n'avez aucune réservation pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
