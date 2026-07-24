<?php

namespace Database\Factories;

use App\Models\Trajet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trajet>
 */
class TrajetFactory extends Factory
{
    public function definition(): array
    {
        $villes = ['Casablanca', 'Rabat', 'Mohammedia', 'Salé', 'Tanger', 'Fès', 'Meknès', 'Agadir'];
        $depart = fake()->randomElement($villes);
        $destination = fake()->randomElement(array_diff($villes, [$depart]));

        $joursOptions = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        $hasRecurrence = fake()->boolean(60); // 60% de chance d'avoir une récurrence
        $jours = $hasRecurrence
            ? fake()->randomElements($joursOptions, fake()->numberBetween(2, 5))
            : null;

        return [
            'entreprise_id'    => \App\Models\Entreprise::inRandomOrder()->first()->id,
            'conducteur_id'    => \App\Models\Employe::whereIn('role', ['conducteur', 'les_deux'])->inRandomOrder()->first()->id,
            'depart'           => $depart,
            'destination'      => $destination,
            'date_depart'      => fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'heure_depart'     => fake()->time('H:i'),
            'prix'             => fake()->randomFloat(2, 20, 150),
            'places'           => fake()->numberBetween(1, 5),
            'jours_recurrence' => $jours,
        ];
    }
}

