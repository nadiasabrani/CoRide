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
        $entreprise = Entreprise::create([
            'nom' => 'Coride',
            'ville' => 'Casablanca',
        ]);

        $response = $this->post('/register', [
            'entreprise_id' => $entreprise->id,
            'nom' => 'Test',
            'prenom' => 'User',
            'ville' => 'Casablanca',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();

       $response->assertRedirect(route('dashboard', absolute: false));
    }
}
