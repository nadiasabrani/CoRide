<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-2xl font-bold mb-6">
                    Bienvenue {{ $employe->nom }} 👋
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Profil -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-bold text-lg mb-3">👤 Profil</h4>

                        <p>
                            <b>Email :</b> {{ $employe->email }}
                        </p>

                        <p>
                            <b>Ville :</b> {{ $employe->ville_residence }}
                        </p>
                    </div>

                    <!-- Entreprise -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-bold text-lg mb-3">🏢 Entreprise</h4>

                        <p>
                            <b>Nom :</b>
                            {{ optional($employe->entreprise)->nom ?? 'Aucune entreprise' }}
                        </p>

                        <p>
                            <b>Ville :</b>
                            {{ optional($employe->entreprise)->ville ?? 'Non définie' }}
                        </p>

                        <p>
                            <b>Adresse :</b>
                            {{ optional($employe->entreprise)->adresse ?? 'Non définie' }}
                        </p>

                        <p>
                            <b>Téléphone :</b>
                            {{ optional($employe->entreprise)->telephone ?? 'Non défini' }}
                        </p>
                    </div>

                    <!-- Rôle -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-bold text-lg mb-3">🔑 Rôle</h4>

                        <p>
                            {{ str_replace('_', ' ', $employe->role) }}
                        </p>
                    </div>

                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('employes.index') }}" class="text-indigo-600 underline">Annuaire des employés</a>
                    <a href="{{ route('trajets.index') }}" class="text-indigo-600 underline">Trajets disponibles</a>
                    <a href="{{ route('reservations.index') }}" class="text-indigo-600 underline">Mes réservations</a>
                         <a href="{{ route('trajets.search') }}" class="text-indigo-600 underline">
    Rechercher un trajet
</a>
                </div>

            </div>

        </div>
    </div>
<hr class="my-8">

<h3 class="text-2xl font-bold mb-4">
    🚗 Mes trajets publiés
</h3>

<a href="{{ route('trajets.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Publier un trajet
</a>

<div class="mt-4">
    <table class="min-w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Départ</th>
                <th class="border p-2">Destination</th>
                <th class="border p-2">Date</th>
                <th class="border p-2">Heure</th>
                <th class="border p-2">Places</th>
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
                    <td class="border p-2">{{ $trajet->places }}</td>

                    <td class="border p-2">
                        <a href="{{ route('trajets.edit', $trajet) }}">
                            Modifier
                        </a>

                        <form action="{{ route('trajets.destroy', $trajet) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Supprimer ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Aucun trajet publié.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
