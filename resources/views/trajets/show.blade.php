<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Détails du trajet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-xl font-bold mb-6">
                        Trajet #{{ $trajet->id }}
                    </h3>

                    <p><strong>Départ :</strong> {{ $trajet->depart }}</p>
                    <p><strong>Destination :</strong> {{ $trajet->destination }}</p>
                    <p><strong>Date :</strong> {{ $trajet->date_depart }}</p>
                    <p><strong>Heure :</strong> {{ $trajet->heure_depart }}</p>
                    <p><strong>Prix :</strong> {{ $trajet->prix }} DH</p>
                    <p><strong>Places :</strong> {{ $trajet->places }}</p>
                    <p><strong>Entreprise :</strong> {{ optional($trajet->entreprise)->nom }}</p>

                    <div class="mt-6">
                        <a href="{{ route('trajets.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Retour
                        </a>

                        <a href="{{ route('trajets.edit', $trajet->id) }}"
                           class="bg-yellow-500 text-white px-4 py-2 rounded ml-2">
                            Modifier
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
