<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeSeeder extends Seeder
{
    /**
     * Peuple la table employes : 1 compte de démo + 40 employés
     * répartis sur les 5 entreprises partenaires.
     */
    public function run(): void
    {
        // Compte de démo simple à utiliser en soutenance (mot de passe : password).
        Employe::updateOrCreate(
            ['email' => 'admin@coride.ma'],
            [
                'entreprise_id' => Entreprise::where('nom', 'MobiliTech')->value('id') ?? Entreprise::first()->id,
                'nom' => 'Admin Coride',
                'ville_residence' => 'Casablanca',
                'role' => 'les_deux',
                'password' => Hash::make('password'),
            ]
        );

        $entreprises = Entreprise::all();

        if ($entreprises->isEmpty()) {
            return;
        }

        // 40 employés répartis équitablement sur les entreprises partenaires.
        $entreprises->each(function (Entreprise $entreprise) {
            Employe::factory()
                ->count(8)
                ->create(['entreprise_id' => $entreprise->id]);
        });
    }
}
