<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des réservations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('reservations.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Ajouter une réservation
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="p-6">

                    <table class="min-w-full border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">Employé</th>
                                <th class="border p-2">Trajet</th>
                                <th class="border p-2">Places</th>
                                <th class="border p-2">Statut</th>
                                <th class="border p-2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td class="border p-2">
                                    {{ $reservation->user->nom }}
                                    {{ $reservation->user->prenom }}
                                </td>

                                <td class="border p-2">
                                    {{ $reservation->trajet->depart }}
                                    →
                                    {{ $reservation->trajet->destination }}
                                </td>

                                <td class="border p-2">
                                    {{ $reservation->nombre_places }}
                                </td>

                                <td class="border p-2">
                                    {{ $reservation->statut }}
                                </td>

                                <td class="border p-2">

                                    <a href="{{ route('reservations.show',$reservation) }}"
                                       class="bg-blue-500 text-white px-3 py-1 rounded">
                                        Voir
                                    </a>

                                    <a href="{{ route('reservations.edit',$reservation) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Modifier
                                    </a>

                                    <form action="{{ route('reservations.destroy',$reservation) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Supprimer cette réservation ?')"
                                            class="bg-red-600 text-white px-3 py-1 rounded">
                                            Supprimer
                                        </button>
                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center p-4">
                                    Aucune réservation.
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
