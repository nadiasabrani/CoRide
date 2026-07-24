<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeSeeder extends Seeder
{
    /**
     * Peuple la table employes depuis le fichier CSV fourni.
     * Crée aussi le compte de démo admin@coride.ma.
     */
    public function run(): void
    {
        // 1. Compte de démo pour la soutenance
        Employe::updateOrCreate(
            ['email' => 'admin@coride.ma'],
            [
                'entreprise_id' => Entreprise::where('nom', 'MobiliTech')->value('id') ?? Entreprise::first()->id,
                'nom'           => 'Admin CoRide',
                'ville_residence' => 'Casablanca',
                'role'          => 'les_deux',
                'password'      => Hash::make('password'),
            ]
        );

        // 2. Lecture du CSV
        $csvPath = database_path('data/employes.csv');
        if (!file_exists($csvPath)) {
            $this->command->warn('EmployeSeeder: employes.csv introuvable, seeder ignoré.');
            return;
        }

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle); // Ignorer l'en-tête

        while (($row = fgetcsv($handle)) !== false) {
            [$id, $nom, $email, $nomEntreprise, $villeResidence, $role] = $row;

            $entreprise = Entreprise::where('nom', $nomEntreprise)->first();
            if (!$entreprise) {
                continue;
            }

            Employe::updateOrCreate(
                ['email' => $email],
                [
                    'nom'             => $nom,
                    'entreprise_id'   => $entreprise->id,
                    'ville_residence' => $villeResidence,
                    'role'            => $role,
                    'password'        => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        fclose($handle);
        $this->command->info('EmployeSeeder : ' . Employe::count() . ' employés en base.');
    }
}
