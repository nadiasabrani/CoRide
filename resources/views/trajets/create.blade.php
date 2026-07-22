<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un trajet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('trajets.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Départ</label>
                        <input type="text" name="depart" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Destination</label>
                        <input type="text" name="destination" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Date de départ</label>
                        <input type="date" name="date_depart" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Heure de départ</label>
                        <input type="time" name="heure_depart" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Prix (DH)</label>
                        <input type="number" name="prix" class="w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nombre de places</label>
                        <input type="number" name="places" class="w-full border rounded p-2" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Enregistrer
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
