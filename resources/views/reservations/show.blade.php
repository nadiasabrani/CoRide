<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Détails de la réservation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <p><strong>Employé :</strong>
                    {{ $reservation->user->nom }}
                    {{ $reservation->user->prenom }}
                </p>

                <p><strong>Trajet :</strong>
                    {{ $reservation->trajet->depart }}
                    →
                    {{ $reservation->trajet->destination }}
                </p>

                <p><strong>Date :</strong>
                    {{ $reservation->trajet->date_depart }}
                </p>

                <p><strong>Heure :</strong>
                    {{ $reservation->trajet->heure_depart }}
                </p>

                <p><strong>Nombre de places :</strong>
                    {{ $reservation->nombre_places }}
                </p>

                <p><strong>Statut :</strong>
                    {{ $reservation->statut }}
                </p>

                <div class="mt-6">

                    <a href="{{ route('reservations.edit', $reservation->id) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded">
                        Modifier
                    </a>

                    <a href="{{ route('reservations.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded">
                        Retour
                    </a>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
