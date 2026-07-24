<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Recherche de trajets
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto">

            <form method="GET" action="{{ route('trajets.search') }}" class="mb-6">

                <input
                    type="text"
                    name="depart"
                    placeholder="Ville de départ"
                    value="{{ request('depart') }}"
                    class="border rounded p-2"
                >

                <input
                    type="time"
                    name="heure_depart"
                    value="{{ request('heure_depart') }}"
                    class="border rounded p-2"
                >

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                    Rechercher
                </button>

            </form>

            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Départ</th>
                        <th class="border p-2">Destination</th>
                        <th class="border p-2">Date</th>
                        <th class="border p-2">Heure</th>
                        <th class="border p-2">Places</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($trajets as $trajet)

                    <tr>
                        <td class="border p-2">{{ $trajet->depart }}</td>
                        <td class="border p-2">{{ $trajet->destination }}</td>
                        <td class="border p-2">{{ $trajet->date_depart }}</td>
                        <td class="border p-2">{{ $trajet->heure_depart }}</td>
                        <td class="border p-2">{{ $trajet->places }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center p-4">
                            Aucun trajet trouvé.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>