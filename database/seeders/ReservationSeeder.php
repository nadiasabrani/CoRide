<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Le fichier reservations.csv fourni dans l'enonce n'a pas ete retrouve
     * en local. On genere donc un jeu de donnees equivalent via factory
     * (35 reservations, statuts varies) pour respecter l'esprit du cahier
     * des charges, en respectant la contrainte unique(trajet_id, passager_id).
     */
    public function run(): void
    {
        $trajets = Trajet::all();
        $employes = Employe::where('role', '!=', 'conducteur')->get();

        if ($trajets->isEmpty() || $employes->isEmpty()) {
            $this->command->warn('ReservationSeeder: aucun trajet ou employe disponible, seeder ignore.');
            return;
        }

        // On construit toutes les combinaisons possibles (trajet, passager)
        // puis on les melange pour piocher 35 paires uniques.
        $paires = collect();
        foreach ($trajets as $trajet) {
            foreach ($employes as $employe) {
                $paires->push([$trajet->id, $employe->id]);
            }
        }

        $nbSouhaite = 35;
        $paires = $paires->shuffle()->take($nbSouhaite);

        if ($paires->count() < $nbSouhaite) {
            $this->command->warn(
                "ReservationSeeder: seulement {$paires->count()} combinaisons trajet/passager disponibles (au lieu de {$nbSouhaite})."
            );
        }

        foreach ($paires as [$trajetId, $passagerId]) {
            $donneesFactice = Reservation::factory()->make();

            Reservation::firstOrCreate(
                [
                    'trajet_id' => $trajetId,
                    'passager_id' => $passagerId,
                ],
                [
                    'statut' => $donneesFactice->statut,
                    'date_reservation' => $donneesFactice->date_reservation,
                ]
            );
        }

        $this->command->info('ReservationSeeder: '.Reservation::count().' reservations en base.');
    }
}
