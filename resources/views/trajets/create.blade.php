<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                + Publier un trajet
            </h2>
            <a href="{{ route('trajets.index') }}" class="text-sm text-indigo-600 hover:underline">← Retour</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg">Informations du trajet</h3>
                    <p class="text-indigo-200 text-sm">Remplissez les détails pour publier votre trajet</p>
                </div>

                <form action="{{ route('trajets.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    @if($errors->any())
                        <div class="p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-xl text-sm text-red-700 dark:text-red-300">
                            @foreach($errors->all() as $err)
                                <p>• {{ $err }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Ville de départ <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="depart" value="{{ old('depart') }}"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Ex: Casablanca" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Destination <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="destination" value="{{ old('destination') }}"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Ex: Rabat" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date de départ <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_depart" value="{{ old('date_depart') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Heure de départ <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="heure_depart" value="{{ old('heure_depart') }}"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Prix (DH) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="prix" value="{{ old('prix') }}"
                                   min="0" max="999" step="0.5"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Ex: 50" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nombre de places <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="places" value="{{ old('places') }}"
                                   min="1" max="8"
                                   class="w-full border dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   required>
                        </div>
                    </div>

                    {{-- Jours de récurrence --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jours de récurrence <span class="text-gray-400 font-normal">(optionnel — si trajet régulier)</span>
                        </label>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['lundi' => 'Lun', 'mardi' => 'Mar', 'mercredi' => 'Mer', 'jeudi' => 'Jeu', 'vendredi' => 'Ven', 'samedi' => 'Sam', 'dimanche' => 'Dim'] as $value => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox"
                                           name="jours_recurrence[]"
                                           value="{{ $value }}"
                                           {{ in_array($value, old('jours_recurrence', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm dark:text-gray-200">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                            ✅ Publier le trajet
                        </button>
                        <a href="{{ route('trajets.index') }}"
                           class="inline-flex items-center bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-lg font-medium transition">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
