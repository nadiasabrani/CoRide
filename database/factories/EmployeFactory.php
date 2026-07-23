<?php

namespace Database\Factories;

use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Employe>
 */
class EmployeFactory extends Factory
{
    protected $model = Employe::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'entreprise_id' => Entreprise::factory(),
            'ville_residence' => fake()->randomElement([
                'Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger',
                'Agadir', 'Meknès', 'Oujda',
            ]),
            'role' => fake()->randomElement(['conducteur', 'passager', 'les_deux']),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the employee is a conducteur only.
     */
    public function conducteur(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'conducteur',
        ]);
    }

    /**
     * Indicate that the employee is a passager only.
     */
    public function passager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'passager',
        ]);
    }
}
