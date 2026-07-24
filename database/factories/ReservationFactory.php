<?php

namespace Database\Factories;

use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trajet_id' => Trajet::factory(),
            'passager_id' => Employe::factory(),
            'statut' => fake()->randomElement(['en_attente', 'confirmee', 'refusee', 'annulee']),
            'date_reservation' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
