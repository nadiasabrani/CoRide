<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier une réservation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold">Trajet</label>

                        <select name="trajet_id" class="w-full border rounded p-2">
                            @foreach($trajets as $trajet)
                                <option value="{{ $trajet->id }}"
                                    {{ $reservation->trajet_id == $trajet->id ? 'selected' : '' }}>
                                    {{ $trajet->depart }} → {{ $trajet->destination }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nombre de places</label>

                        <input
                            type="number"
                            name="nombre_places"
                            value="{{ $reservation->nombre_places }}"
                            class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Statut</label>

                        <select name="statut" class="w-full border rounded p-2">

                            <option value="en_attente"
                                {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>
                                En attente
                            </option>

                            <option value="confirmée"
                                {{ $reservation->statut == 'confirmée' ? 'selected' : '' }}>
                                Confirmée
                            </option>

                            <option value="annulée"
                                {{ $reservation->statut == 'annulée' ? 'selected' : '' }}>
                                Annulée
                            </option>

                        </select>
                    </div>

                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Modifier
                    </button>

                    <a href="{{ route('reservations.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded ml-2">
                        Retour
                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
