<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Trajet;
use Illuminate\Database\Seeder;

class TrajetSeeder extends Seeder
{
    /**
     * Peuple la table trajets depuis trajets.csv.
     * Mappe les conducteur_id CSV vers les vrais IDs en base (par position).
     */
    public function run(): void
    {
        $csvPath = database_path('data/trajets.csv');
        if (!file_exists($csvPath)) {
            $this->command->warn('TrajetSeeder: trajets.csv introuvable, génération par factory.');
            Trajet::factory()->count(25)->create();
            return;
        }

        // Index des conducteurs du CSV par leur position (id CSV → employe réel)
        // Les IDs CSV correspondent aux numéros de ligne dans employes.csv (1-based)
        $employes = Employe::whereIn('role', ['conducteur', 'les_deux'])
            ->orderBy('id')
            ->get()
            ->values();

        // Map : id_csv => employe en base (position approximative)
        // On utilise les emails des conducteurs présents dans les deux fichiers
        $csvEmailMap = [
            1  => 'k.benali@mobilitech.ma',
            3  => 'y.tahiri@mobilitech.ma',
            5  => 'o.ziani@mobilitech.ma',
            6  => 'f.lahlou@mobilitech.ma',
            7  => 'h.berrada@mobilitech.ma',
            9  => 'm.kettani@nextbuild.ma',
            11 => 'a.bensaid@nextbuild.ma',
            13 => 'r.ouali@nextbuild.ma',
            15 => 's.benkirane@nextbuild.ma',
            17 => 'a.hafidi@atlasdigital.ma',
            19 => 'b.elmostafa@atlasdigital.ma',
            21 => 'y.benmoussa@atlasdigital.ma',
            23 => 'k.ouazzani@atlasdigital.ma',
            25 => 't.naciri@greenlogix.ma',
            27 => 'd.abbadi@greenlogix.ma',
            29 => 'n.hassani@greenlogix.ma',
            31 => 'm.fikri@greenlogix.ma',
            33 => 'h.bouazza@kandia.ma',
            35 => 'a.bensouda@kandia.ma',
            37 => 'i.rhazali@kandia.ma',
            39 => 'r.chbihi@kandia.ma',
        ];

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            [$id, $conducteurIdCsv, $villeDepart, $villeArrivee, $horaire, $places, $joursRecurrence] = $row;

            $email = $csvEmailMap[(int) $conducteurIdCsv] ?? null;
            $conducteur = $email ? Employe::where('email', $email)->first() : null;

            if (!$conducteur) {
                $conducteur = Employe::whereIn('role', ['conducteur', 'les_deux'])->inRandomOrder()->first();
            }

            // jours_recurrence : string CSV "lundi,mercredi,vendredi" → tableau JSON
            $joursArray = $joursRecurrence
                ? array_filter(array_map('trim', explode(',', $joursRecurrence)))
                : null;

            // Date de départ : prochaine occurrence si récurrent, sinon dans 2 semaines
            $dateDepart = !empty($joursArray)
                ? now()->addDays(rand(1, 7))->format('Y-m-d')
                : now()->addDays(rand(7, 30))->format('Y-m-d');

            Trajet::updateOrCreate(
                [
                    'conducteur_id' => $conducteur->id,
                    'depart'        => $villeDepart,
                    'destination'   => $villeArrivee,
                    'heure_depart'  => $horaire,
                ],
                [
                    'entreprise_id'    => $conducteur->entreprise_id,
                    'date_depart'      => $dateDepart,
                    'prix'             => rand(20, 80),
                    'places'           => (int) $places,
                    'jours_recurrence' => !empty($joursArray) ? array_values($joursArray) : null,
                ]
            );
        }

        fclose($handle);
        $this->command->info('TrajetSeeder : ' . Trajet::count() . ' trajets en base.');
    }
}