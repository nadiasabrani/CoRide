<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter une réservation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Trajet</label>

                        <select name="trajet_id" class="w-full border rounded p-2" required>
                            <option value="">-- Choisir un trajet --</option>

                            @foreach($trajets as $trajet)
                                <option value="{{ $trajet->id }}">
                                    {{ $trajet->depart }} → {{ $trajet->destination }}
                                    ({{ $trajet->date_depart }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">
                            Nombre de places
                        </label>

                        <input
                            type="number"
                            name="nombre_places"
                            min="1"
                            class="w-full border rounded p-2"
                            required>
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                        Enregistrer
                    </button>

                    <a href="{{ route('reservations.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded ml-2">
                        Annuler
                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
