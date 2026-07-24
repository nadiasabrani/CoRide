<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Profil de {{ $employe->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg space-y-4">
                <p><b>Nom :</b> {{ $employe->nom }}</p>
                <p><b>Email :</b> {{ $employe->email }}</p>
                <p><b>Entreprise :</b> {{ $employe->entreprise->nom ?? '—' }}</p>
                <p><b>Ville de résidence :</b> {{ $employe->ville_residence }}</p>
                <p><b>Rôle :</b> {{ str_replace('_', ' ', $employe->role) }}</p>

                <a href="{{ route('employes.index') }}" class="text-brand-600 underline text-sm">← Retour à l'annuaire</a>
            </div>
        </div>
    </div>
</x-app-layout>
