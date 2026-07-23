<?php

namespace Database\Factories;

use App\Models\Trajet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trajet>
 */
class TrajetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'entreprise_id' => \App\Models\Entreprise::inRandomOrder()->first()->id,
        'conducteur_id' => \App\Models\Employe::inRandomOrder()->first()->id,
        'depart' => fake()->city(),
        'destination' => fake()->city(),
        'date_depart' => fake()->date(),
        'heure_depart' => fake()->time(),
        'prix' => fake()->randomFloat(2, 20, 150),
        'places' => fake()->numberBetween(1, 5),
    ];
}
}
