<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-bold text-2xl text-white">
            👥 Annuaire des employés
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Card -->
            <div class="pro-card p-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="ville" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Ville</label>
                        <input id="ville" name="ville" type="text" class="pro-input" value="{{ request('ville') }}" placeholder="Ex: Casablanca..." />
                    </div>

                    <div>
                        <label for="entreprise_id" class="block text-xs font-mono font-semibold uppercase text-slate-300 mb-1.5">Entreprise</label>
                        <select id="entreprise_id" name="entreprise_id" class="pro-input">
                            <option value="">Toutes les entreprises</option>
                            @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" @selected(request('entreprise_id') == $entreprise->id)>
                                    {{ $entreprise->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-pro-primary">Filtrer</button>

                    @if(request()->hasAny(['ville', 'entreprise_id']))
                        <a href="{{ route('employes.index') }}" class="btn-pro-secondary text-xs">✕ Réinitialiser</a>
                    @endif
                </form>
            </div>

            <!-- Employes Table -->
            <div class="pro-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[#0D1420] text-xs font-mono uppercase text-slate-400 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4">Nom</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Entreprise</th>
                                <th class="px-6 py-4">Ville</th>
                                <th class="px-6 py-4">Rôle</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($employes as $employe)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-4 font-bold text-white">{{ $employe->nom }}</td>
                                    <td class="px-6 py-4 text-slate-300 font-mono text-xs">{{ $employe->email }}</td>
                                    <td class="px-6 py-4 text-slate-300 font-semibold">{{ $employe->entreprise->nom ?? '—' }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $employe->ville_residence }}</td>
                                    <td class="px-6 py-4">
                                        <span class="pro-badge pro-badge-blue capitalize">
                                            {{ str_replace('_', ' ', $employe->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('employes.show', $employe) }}" class="btn-pro-secondary text-xs py-1 px-3">
                                            Voir profil →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-mono text-xs">
                                        Aucun employé ne correspond aux critères de recherche.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-2">
                {{ $employes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
