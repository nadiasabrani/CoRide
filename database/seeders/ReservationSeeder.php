<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Peuple les réservations depuis reservations.csv.
     * Respecte la contrainte unique(trajet_id, passager_id) et les règles métier.
     */
    public function run(): void
    {
        $csvPath = database_path('data/reservations.csv');

        if (!file_exists($csvPath)) {
            $this->command->warn('ReservationSeeder: reservations.csv introuvable, génération par factory.');
            $this->genererParFactory();
            return;
        }

        $trajets  = Trajet::orderBy('id')->get()->values();
        $employes = Employe::orderBy('id')->get()->values();

        // Map email → employe pour les passagers du CSV
        $emailPassagers = [
            2  => 's.alaoui@mobilitech.ma',
            4  => 'n.chraibi@mobilitech.ma',
            8  => 'a.mansouri@mobilitech.ma',
            10 => 'z.raji@nextbuild.ma',
            12 => 'h.filali@nextbuild.ma',
            14 => 'k.tazi@nextbuild.ma',
            16 => 'i.skalli@nextbuild.ma',
        ];

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            [$id, $trajetIdCsv, $passagerIdCsv, $statut, $dateReservation] = $row;

            // Récupérer le trajet correspondant (par position dans la liste)
            $trajet = $trajets->get((int) $trajetIdCsv - 1);
            if (!$trajet) {
                continue;
            }

            // Récupérer le passager par email
            $email = $emailPassagers[(int) $passagerIdCsv] ?? null;
            $passager = $email ? Employe::where('email', $email)->first() : null;
            if (!$passager) {
                continue;
            }

            // Ne pas créer une réservation si le passager est le conducteur
            if ($passager->id === $trajet->conducteur_id) {
                continue;
            }

            Reservation::firstOrCreate(
                [
                    'trajet_id'  => $trajet->id,
                    'passager_id' => $passager->id,
                ],
                [
                    'statut'           => $statut,
                    'date_reservation' => $dateReservation,
                ]
            );
        }

        fclose($handle);
        $this->command->info('ReservationSeeder : ' . Reservation::count() . ' réservations en base.');
    }

    private function genererParFactory(): void
    {
        $trajets  = Trajet::all();
        $employes = Employe::where('role', '!=', 'conducteur')->get();

        if ($trajets->isEmpty() || $employes->isEmpty()) {
            $this->command->warn('ReservationSeeder: aucun trajet ou employé disponible.');
            return;
        }

        $paires = collect();
        foreach ($trajets as $trajet) {
            foreach ($employes as $employe) {
                if ($employe->id !== $trajet->conducteur_id) {
                    $paires->push([$trajet->id, $employe->id]);
                }
            }
        }

        $paires = $paires->shuffle()->take(35);

        foreach ($paires as [$trajetId, $passagerId]) {
            $donnees = Reservation::factory()->make();
            Reservation::firstOrCreate(
                ['trajet_id' => $trajetId, 'passager_id' => $passagerId],
                ['statut' => $donnees->statut, 'date_reservation' => $donnees->date_reservation]
            );
        }
    }
}
