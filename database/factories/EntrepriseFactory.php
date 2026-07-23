<?php

namespace Database\Factories;

use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entreprise>
 */
class EntrepriseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->company(),
            'ville' => fake()->randomElement([
                'Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger',
                'Agadir', 'Meknès', 'Oujda',
            ]),
            'adresse' => fake()->streetAddress(),
            'telephone' => fake()->numerify('05########'),
            'email' => fake()->unique()->companyEmail(),
        ];
    }
}
