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
                    Bienvenue {{ Auth::user()->name }} 👋
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Profil -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-bold text-lg mb-3">👤 Profil</h4>

                        <p>
                            <b>Email :</b> {{ Auth::user()->email }}
                        </p>

                        <p>
                            <b>Ville :</b> {{ Auth::user()->ville }}
                        </p>
                    </div>


                    <!-- Entreprise -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-bold text-lg mb-3">🏢 Entreprise</h4>

                        <p>
                            <b>Nom :</b>
                            {{ optional(Auth::user()->entreprise)->nom ?? 'Aucune entreprise' }}
                        </p>

                        <p>
                            <b>Ville :</b>
                            {{ optional(Auth::user()->entreprise)->ville ?? 'Non définie' }}
                        </p>

                        <p>
                            <b>Adresse :</b>
                            {{ optional(Auth::user()->entreprise)->adresse ?? 'Non définie' }}
                        </p>

                        <p>
                            <b>Téléphone :</b>
                            {{ optional(Auth::user()->entreprise)->telephone ?? 'Non défini' }}
                        </p>

                    </div>


                    <!-- Rôle -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="font-bold text-lg mb-3">🔑 Rôle</h4>

                        <p>
                            {{ Auth::user()->role }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
