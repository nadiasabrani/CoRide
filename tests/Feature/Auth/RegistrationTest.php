<?php

namespace Tests\Feature\Auth;

use App\Models\Entreprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->post('/register', [
            'entreprise_id' => $entreprise->id,
            'nom' => 'Test User',
            'ville_residence' => 'Casablanca',
            'role' => 'passager',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('employes', [
            'email' => 'test@example.com',
            'entreprise_id' => $entreprise->id,
            'role' => 'passager',
        ]);
    }

    public function test_registration_requires_a_valid_role(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->post('/register', [
            'entreprise_id' => $entreprise->id,
            'nom' => 'Test User',
            'ville_residence' => 'Casablanca',
            'role' => 'admin',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();
    }
}
