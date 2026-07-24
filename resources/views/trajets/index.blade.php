<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des trajets
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
                <a href="{{ route('trajets.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Ajouter un trajet
                </a>
                <a href="{{ route('trajets.search') }}"
   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    Rechercher
</a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border p-2">Départ</th>
                                <th class="border p-2">Destination</th>
                                <th class="border p-2">Date</th>
                                <th class="border p-2">Heure</th>
                                <th class="border p-2">Prix</th>
                                <th class="border p-2">Places</th>
                                <th class="border p-2">Entreprise</th>
                                <th class="border p-2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($trajets as $trajet)
                                <tr>
                                    <td class="border p-2">{{ $trajet->depart }}</td>
                                    <td class="border p-2">{{ $trajet->destination }}</td>
                                    <td class="border p-2">{{ $trajet->date_depart }}</td>
                                    <td class="border p-2">{{ $trajet->heure_depart }}</td>
                                    <td class="border p-2">{{ $trajet->prix }} DH</td>
                                    <td class="border p-2">{{ $trajet->places }}</td>
                                    <td class="border p-2">
                                        {{ optional($trajet->entreprise)->nom }}
                                    </td>

                                    <td class="border p-2">

                                        <a href="{{ route('trajets.show', $trajet->id) }}"
                                           class="bg-blue-600 text-white px-3 py-1 rounded">
                                            Voir
                                        </a>

                                        <a href="{{ route('trajets.edit', $trajet->id) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                                            Modifier
                                        </a>

                                        <form action="{{ route('trajets.destroy', $trajet->id) }}"
                                              method="POST"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Supprimer ce trajet ?')"
                                                    class="bg-red-600 text-white px-3 py-1 rounded">
                                                Supprimer
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4">
                                        Aucun trajet disponible.
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
