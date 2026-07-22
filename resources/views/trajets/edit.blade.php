<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier un trajet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('trajets.update', $trajet->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold">Départ</label>
                        <input
                            type="text"
                            name="depart"
                            value="{{ old('depart', $trajet->depart) }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Destination</label>
                        <input
                            type="text"
                            name="destination"
                            value="{{ old('destination', $trajet->destination) }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Date de départ</label>
                        <input
                            type="date"
                            name="date_depart"
                            value="{{ old('date_depart', $trajet->date_depart) }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Heure de départ</label>
                        <input
                            type="time"
                            name="heure_depart"
                            value="{{ old('heure_depart', $trajet->heure_depart) }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Prix (DH)</label>
                        <input
                            type="number"
                            step="0.01"
                            name="prix"
                            value="{{ old('prix', $trajet->prix) }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nombre de places</label>
                        <input
                            type="number"
                            name="places"
                            value="{{ old('places', $trajet->places) }}"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Modifier
                        </button>

                        <a href="{{ route('trajets.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Annuler
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
