<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display font-bold text-2xl text-white">
                ➕ Publier un trajet
            </h2>
            <a href="{{ route('trajets.index') }}" class="btn-pro-secondary text-xs">← Retour à la liste</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="pro-card overflow-hidden">
                <div class="bg-gradient-to-r from-blue-900/50 to-indigo-900/30 px-6 py-5 border-b border-white/10">
                    <h3 class="text-white font-bold text-lg">Informations du trajet</h3>
                    <p class="text-slate-300 text-xs mt-0.5">Saisissez les coordonnées de votre trajet domicile-travail.</p>
                </div>

                <form action="{{ route('trajets.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    @if($errors->any())
                        <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-sm text-rose-400 font-medium">
                            @foreach($errors->all() as $err)
                                <p>• {{ $err }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">
                                Ville de départ <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="depart" value="{{ old('depart') }}" class="pro-input" placeholder="Ex: Casablanca" required>
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">
                                Destination <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" name="destination" value="{{ old('destination') }}" class="pro-input" placeholder="Ex: Rabat" required>
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">
                                Date de départ <span class="text-rose-400">*</span>
                            </label>
                            <input type="date" name="date_depart" value="{{ old('date_depart') }}" min="{{ date('Y-m-d') }}" class="pro-input" required>
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">
                                Heure de départ <span class="text-rose-400">*</span>
                            </label>
                            <input type="time" name="heure_depart" value="{{ old('heure_depart') }}" class="pro-input" required>
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">
                                Nombre de places disponibles <span class="text-rose-400">*</span>
                            </label>
                            <input type="number" name="places" min="1" max="8" value="{{ old('places', 3) }}" class="pro-input" required>
                        </div>

                        <div>
                            <label class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">
                                Prix par place (DH) <span class="text-rose-400">*</span>
                            </label>
                            <input type="number" name="prix" min="0" step="5" value="{{ old('prix', 40) }}" class="pro-input" required>
                        </div>
                    </div>

                    {{-- Récurrence --}}
                    <div class="border-t border-white/10 pt-5 space-y-3">
                        <label class="block text-xs font-mono font-semibold uppercase text-slate-300">
                            Jours de récurrence (Optionnel)
                        </label>
                        <p class="text-xs text-slate-400">Cochez les jours où ce trajet est habituellement répété.</p>
                        
                        @php
                            $jours = ['lun' => 'Lundi', 'mar' => 'Mardi', 'mer' => 'Mercredi', 'jeu' => 'Jeudi', 'ven' => 'Vendredi', 'sam' => 'Samedi', 'dim' => 'Dimanche'];
                            $oldJours = old('jours_recurrence', []);
                        @endphp

                        <div class="flex flex-wrap gap-3">
                            @foreach($jours as $code => $label)
                                <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 hover:border-blue-500/40 cursor-pointer text-xs font-semibold text-slate-200">
                                    <input type="checkbox" name="jours_recurrence[]" value="{{ $code }}" @checked(in_array($code, $oldJours)) class="rounded bg-[#0B0F19] border-white/20 text-blue-600 focus:ring-blue-500">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-white/10 pt-5">
                        <a href="{{ route('trajets.index') }}" class="btn-pro-secondary text-xs">Annuler</a>
                        <button type="submit" class="btn-pro-primary">Publier le trajet →</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
