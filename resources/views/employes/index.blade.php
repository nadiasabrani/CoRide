<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Annuaire des employés
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <x-input-label for="ville" value="Ville" />
                        <x-text-input id="ville" name="ville" type="text" class="mt-1" value="{{ request('ville') }}" placeholder="Casablanca..." />
                    </div>

                    <div>
                        <x-input-label for="entreprise_id" value="Entreprise" />
                        <select id="entreprise_id" name="entreprise_id" class="mt-1 rounded-md border-gray-300">
                            <option value="">Toutes</option>
                            @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" @selected(request('entreprise_id') == $entreprise->id)>
                                    {{ $entreprise->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-primary-button>Filtrer</x-primary-button>

                    @if(request()->hasAny(['ville', 'entreprise_id']))
                        <a href="{{ route('employes.index') }}" class="text-sm text-gray-600 underline">Réinitialiser</a>
                    @endif
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3">Nom</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Entreprise</th>
                            <th class="px-4 py-3">Ville</th>
                            <th class="px-4 py-3">Rôle</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employes as $employe)
                            <tr class="border-t border-gray-100 dark:border-gray-700">
                                <td class="px-4 py-3">{{ $employe->nom }}</td>
                                <td class="px-4 py-3">{{ $employe->email }}</td>
                                <td class="px-4 py-3">{{ $employe->entreprise->nom ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $employe->ville_residence }}</td>
                                <td class="px-4 py-3">{{ str_replace('_', ' ', $employe->role) }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('employes.show', $employe) }}" class="text-indigo-600 underline">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucun employé trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $employes->links() }}
        </div>
    </div>
</x-app-layout>
